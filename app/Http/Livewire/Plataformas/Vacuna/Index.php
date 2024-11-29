<?php

namespace App\Http\Livewire\Vacuna;

use App\Models\Plataformas\Vacuna;
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
        $count = Vacuna::count();
        $Vacunas = Vacuna::orderBy('id', 'asc');
        

        if($this->search){
            $Vacunas = $Vacunas->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $Vacunas = $Vacunas->paginate($this->perPage);

        return view('livewire.plataformas.vacuna.index', compact('count', 'Vacunas'));
    }

    public function destroy($id)
    {   try{
            $Vacunas = Vacuna::findOrFail($id);
            $Vacunas->delete();
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
