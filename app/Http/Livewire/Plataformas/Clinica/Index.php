<?php

namespace App\Http\Livewire\Clinica;

use App\Models\Plataformas\Clinica;
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
        $count = Clinica::count();
        $Clinicas = Clinica::orderBy('id', 'asc');
        

        if($this->search){
            $Clinicas = $Clinicas->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Clinicas = $Clinicas->paginate($this->perPage);

        return view('livewire.plataformas.clinica.index', compact('count', 'Clinicas'));
    }

    public function destroy($id)
    {   try{
            $Clinicas = Clinica::findOrFail($id);
            $Clinicas->delete();
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
