<?php

namespace App\Http\Livewire\Centrosreferencia\Responsable;

use App\Models\CentrosReferencia\Responsable;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
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
        $count = Responsable::where('estado','=','A')->count();
        $responsables = Responsable::where('estado','=','A')->orderBy('id', 'asc');


        if($this->search){
            $responsables = $responsables->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $responsables = $responsables->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.responsable.index', compact('count', 'responsables'));
    }

    public function destroy(Responsable $responsables)
    {
        try{
            $responsables->vigente_hasta=now();
            $responsables->update();
            $this->alert('success', 'Área eliminada con éxito');
        }catch(Exception $e){
            $this->alert('error', 'Ocurrio un error en la eliminación');
        }
    }
}
