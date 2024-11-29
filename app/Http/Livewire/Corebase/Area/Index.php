<?php

namespace App\Http\Livewire\Corebase\Area;

use App\Models\CoreBase\Area;
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
        $count = Area::where('status','=','A')->count();
        $areas = Area::where('status','=','A')->orderBy('id', 'asc');


        if($this->search){
            $areas = $areas->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $areas = $areas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.corebase.area.index', compact('count', 'areas'));
    }

    public function destroy(Area $areas)
    {
        try{
            $areas->status='I';
            $areas->update();
            $this->alert('success', 'Área eliminada con éxito');
        }catch(Exception $e){
            $this->alert('error', 'Ocurrio un error en la eliminación');
        }
    }
}
