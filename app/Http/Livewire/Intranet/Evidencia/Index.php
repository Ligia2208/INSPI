<?php

namespace App\Http\Livewire\Evidencia;

use App\Models\Intranet\Evidencia;
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
        $count = Evidencia::count();
        $Evidencias = Evidencia::orderBy('id', 'asc');


        if($this->search){
            $Evidencias = $Evidencias->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Evidencias = $Evidencias->paginate($this->perPage);

        return view('livewire.intranet.evidencia.index', compact('count', 'Evidencias'));
    }

    public function destroy(Evidencia $Evidencia)
    {
        try{
            $Evidencia->delete();
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
