<?php

namespace App\Http\Livewire\Solicituddir;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\Solicituddir;
use App\Models\CoreBase\Area;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $userPresent;
    public $filiacion;
    public $area;
            
    //Tools
    public $perPage = 10;
    public $search;
    protected $queryString = ['search' => ['except' => '']];   

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->userPresent = User::find(Auth::user()->id);
        $this->filiacion = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $this->filiacion->area_id;
        $this->cargo = $this->filiacion->cargo_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {    
        
        if ($this->cargo==6){
            $count = Asignacion::where('area_id','=',$this->area)->where('procesado','=',0)->count();
            $Solicitudesdir = Asignacion::where('procesado','=',0)->where('area_id','=',$this->area)->orderBy('id','asc')->orderBy('id', 'asc');       
        }
        else{
            $count = 0;
            $Solicitudesdir = Asignacion::where('procesado','=',-1)->orderBy('id','asc')->orderBy('id', 'asc');       
        }
        
        if($this->search){
            $Solicitudesdir = $Solicitudesdir->where('numerodocumento', 'LIKE', "%{$this->search}%");
        }
        $Solicitudesdir = $Solicitudesdir->paginate($this->perPage);
        return view('livewire.gestiondocumental.solicituddir.index', compact('count', 'Solicitudesdir'));
    }

    public function destroy($id)
    {
        try{
            $Solicitudesdir = Solicituddir::findOrFail($id);
            if(Storage::exists($Solicitudesdir->archivo)){
                Storage::delete($Solicitudesdir->archivo);
            }
            $Solicitudesdir->delete();
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
