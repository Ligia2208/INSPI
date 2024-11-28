<?php

namespace App\Http\Livewire\Solicitudcor;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\Solicitudcor;
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
        if ($this->cargo==9){
            $count = Asignacion::where('area_id','=',$this->area)->where('procesado','=',0)->count();
            $Solicitudescor = Asignacion::where('procesado','=',0)->where('area_id','=',$this->area)->orderBy('id','asc')->orderBy('id', 'asc');       
        }
        else{
            $count = 0;
            $Solicitudescor = Asignacion::where('procesado','=',-1)->orderBy('id','asc')->orderBy('id', 'asc');       
        }
        
        if($this->search){
            $Solicitudescor = $Solicitudescor->where('numerodocumento', 'LIKE', "%{$this->search}%");
        }
        $Solicitudescor = $Solicitudescor->paginate($this->perPage);
        return view('livewire.gestiondocumental.solicitudcor.index', compact('count', 'Solicitudescor'));
    }

    public function destroy($id)
    {
        try{
            $Solicitudescor = Solicitudcor::findOrFail($id);
            if(Storage::exists($Solicitudescor->archivo)){
                Storage::delete($Solicitudescor->archivo);
            }
            $Solicitudescor->delete();
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
