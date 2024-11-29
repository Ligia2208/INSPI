<?php

namespace App\Http\Livewire\Evento;

use App\Models\Intranet\Evento;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $userPresent;
        
    //Tools
    public $perPage = 10;
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
        $count = Evento::where('estado','=','A')->where('usuario_id','=',Auth::user()->id)->count();
        $Eventos = Evento::where('estado','=','A')->where('usuario_id','=',Auth::user()->id)->orderBy('id', 'desc');       
        if($this->search){
            $Eventos = $Eventos->where('nombreactividad', 'LIKE', "%{$this->search}%");
        }
        $Eventos = $Eventos->paginate($this->perPage);
        return view('livewire.intranet.evento.index', compact('count', 'Eventos'));
    }

    public function destroy($id)
    {
        try{
            $Eventos = Evento::findOrFail($id);
            if(Storage::exists($Eventos->archivo)){
                Storage::delete($Eventos->archivo);
            }
            $Eventos->delete();
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
