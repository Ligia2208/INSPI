<?php

namespace App\Http\Livewire\Parasito;

use App\Models\Plataformas\Parasito;
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
        $count = Parasito::count();
        $Parasitos = Parasito::orderBy('id', 'asc');
        

        if($this->search){
            $Parasitos = $Parasitos->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $Parasitos = $Parasitos->paginate($this->perPage);

        return view('livewire.plataformas.parasito.index', compact('count', 'Parasitos'));
    }

    public function destroy($id)
    {   try{
            $Parasitos = Parasito::findOrFail($id);
            $Parasitos->delete();
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
