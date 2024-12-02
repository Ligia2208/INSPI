<?php

namespace App\Http\Livewire\Dieta;

use App\Models\Plataformas\Dieta;
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
        $count = Dieta::count();
        $Dietas = Dieta::orderBy('id', 'asc');


        if($this->search){
            $Dietas = $Dietas->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Dietas = $Dietas->paginate($this->perPage);

        return view('livewire.plataformas.dieta.index', compact('count', 'Dietas'));
    }

    public function destroy($id)
    {   try{
            $Dietas = Dieta::findOrFail($id);
            $Dietas->delete();
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
