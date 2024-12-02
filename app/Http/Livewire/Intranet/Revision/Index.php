<?php

namespace App\Http\Livewire\Revision;

use App\Models\Intranet\Revision;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    //Tools
    public $perPage = 10;
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
        $count = Revision::count();
        $Revisiones = Revision::orderBy('id', 'asc');


        if($this->search){
            $Revisiones = $Revisiones->where('nombreactividad', 'LIKE', "%{$this->search}%");
        }

        $Revisiones = $Revisiones->paginate($this->perPage);

        return view('livewire.intranet.revision.index', compact('count', 'Revisiones'));

    }

    public function destroy(Revision $Revisiones)
    {
        try{
            $Revisiones->delete();
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
