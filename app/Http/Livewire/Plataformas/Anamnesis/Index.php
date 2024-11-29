<?php

namespace App\Http\Livewire\Anamnesis;

use App\Models\Plataformas\Anamnesis;
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
        $count = Anamnesis::count();
        $Anamnesiss = Anamnesis::orderBy('id', 'asc');
        

        if($this->search){
            $Anamnesiss = $Anamnesiss->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Anamnesiss = $Anamnesiss->paginate($this->perPage);

        return view('livewire.plataformas.anamnesis.index', compact('count', 'Anamnesiss'));
    }

    public function destroy($id)
    {   try{
            $Anamnesiss = Anamnesis::findOrFail($id);
            $Anamnesiss->delete();
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
