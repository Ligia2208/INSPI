<?php

namespace App\Http\Livewire\Soporte\Tecnico;

use App\Models\Soporte\Tecnico;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
//use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    //use LivewireAlert;

    //Tools
    public $perPage = 20;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    //Listeners
    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Tecnico::where('status','=','A')->count();
        $tecnicos = Tecnico::where('status','=','A')->orderBy('id', 'asc');


        if($this->search){
            $tecnicos = $tecnicos->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $tecnicos = $tecnicos->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.soporte.tecnico.index', compact('count', 'tecnicos'));
    }

    public function destroy(Tecnico $tecnicos)
    {
        try{
            $tecnicos->status='I';
            $tecnicos->update();
            $this->alert('success', 'Área eliminada con éxito');
        }catch(Exception $e){
            $this->alert('error', 'Ocurrio un error en la eliminación');
        }
    }
}
