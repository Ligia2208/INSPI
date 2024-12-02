<?php

namespace App\Http\Livewire\Inventario\Participante;

use App\Models\Inventario\Participante;
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
        $count = Participante::count();
        $Participantes = Participante::orderBy('estado', 'asc')->orderBy('fecharegistro','desc');


        if($this->search){
            $Participantes = $Participantes->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $Participantes = $Participantes->paginate($this->perPage);


        return view('livewire.inventario.participante.index', compact('count', 'Participantes'));
    }

    public function destroy(Participante $Participantes)
    {
        try{
            $Participantes->delete();
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
