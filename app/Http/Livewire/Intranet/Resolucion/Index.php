<?php

namespace App\Http\Livewire\Intranet\Resolucion;

use App\Models\Intranet\Resolucion;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $userPresent;

    //Tools
    public $perPage = 12;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Resolucion::where('estado','=','A')->count();
        $Resoluciones = Resolucion::where('estado','=','A')->orderBy('id', 'asc');
        if($this->search){
            $Resoluciones = $Resoluciones->where('titulo', 'LIKE', "%{$this->search}%");
            $count = Resolucion::where('estado','=','A')->where('titulo', 'LIKE', "%{$this->search}%")->count();

        }
        $Resoluciones = $Resoluciones->paginate($this->perPage);
        return view('livewire.intranet.resolucion.index', compact('count', 'Resoluciones'));
    }

    public function destroy($id)
    {
        try{
            $Resoluciones = Resolucion::findOrFail($id);
            if(Storage::exists($Resoluciones->archivo)){
                Storage::delete($Resoluciones->archivo);
            }
            $Resoluciones->delete();
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
