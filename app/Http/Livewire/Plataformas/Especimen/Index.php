<?php

namespace App\Http\Livewire\Especimen;

use App\Models\Plataformas\Especie;
use App\Models\Plataformas\Sexoespecimen;
use App\Models\Plataformas\Especimen;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

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
        $count = Especimen::count();
        $Especimenes = Especimen::orderBy('id', 'asc');       

        if($this->search){
            $Especimenes = $Especimenes->where('nombres', 'LIKE', "%{$this->search}%")->orWhere('apellidos', 'LIKE', "%{$this->search}%");
            $count = Especimen::where('nombres', 'LIKE', "%{$this->search}%")->orWhere('apellidos', 'LIKE', "%{$this->search}%")->count();
        }

        $Especimenes = $Especimenes->paginate($this->perPage);
        $this->emit('render');
        $this->emit('renderJs');

        return view('livewire.plataformas.especimen.index', compact('count', 'Especimenes'));
    }


    public function destroy(Especimen $Especimenes)
    {
        try{
            $Especimenes->delete();
            $this->alert('success', 'Eliminación con exito');
        }catch(Exception $e){
            $this->alert('error', 
                'Ocurrio un error en la eliminación: '.$e->getMessage(), 
                [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entiendo',
                    'timer' => null,
                ]);
        }
    }
}
