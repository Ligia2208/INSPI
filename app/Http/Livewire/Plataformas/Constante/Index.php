<?php

namespace App\Http\Livewire\Constante;

use App\Models\Plataformas\Constante;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
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
        $count = Constante::count();
        $Constantes = Constante::orderBy('id', 'asc');


        if($this->search){
            $Constantes = $Constantes->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $Constantes = $Constantes->paginate($this->perPage);

        return view('livewire.plataformas.constante.index', compact('count', 'Constantes'));
    }

    public function destroy($id)
    {   try{
            $Constantes = Constante::findOrFail($id);
            $Constantes->delete();
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
