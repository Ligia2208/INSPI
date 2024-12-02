<?php

namespace App\Http\Livewire\Tratamiento;

use App\Models\Plataformas\Tratamiento;
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
        $count = Tratamiento::count();
        $Tratamientos = Tratamiento::orderBy('id', 'asc');


        if($this->search){
            $Tratamientos = $Tratamientos->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Tratamientos = $Tratamientos->paginate($this->perPage);

        return view('livewire.plataformas.tratamiento.index', compact('count', 'Tratamientos'));
    }

    public function destroy($id)
    {   try{
            $Tratamientos = Tratamiento::findOrFail($id);
            $Tratamientos->delete();
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
