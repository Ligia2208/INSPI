<?php

namespace App\Http\Livewire\Solicituddirtec;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\Solicituddirtec;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

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
        $this->direccion = $this->filiacion->direccion_id;
        $this->cargo = $this->filiacion->cargo_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {    
        
        if ($this->cargo==10){
            $count = Asignacion::where('area_id','=',$this->area)->where('dirtecnica_id','=',$this->direccion)->where('procesado','=',0)->count();
            $Solicitudesdirtec = Asignacion::where('procesado','=',0)->where('area_id','=',$this->area)->where('dirtecnica_id','=',$this->direccion)->orderBy('id', 'asc');       
        }
        else{
            $count = 0;
            $Solicitudesdirtec = Asignacion::where('procesado','=',-1)->orderBy('id','asc')->orderBy('id', 'asc');       
        }
        
        if($this->search){
            $Solicitudesdirtec = $Solicitudesdirtec->where('numerodocumento', 'LIKE', "%{$this->search}%");
        }
        $Solicitudesdirtec = $Solicitudesdirtec->paginate($this->perPage);
        return view('livewire.gestiondocumental.solicituddirtec.index', compact('count', 'Solicitudesdirtec'));
    }

    public function destroy($id)
    {
        try{
            $Solicitudesdirtec = Solicituddirtec::findOrFail($id);
            if(Storage::exists($Solicitudesdirtec->archivo)){
                Storage::delete($Solicitudesdirtec->archivo);
            }
            $Solicitudesdirtec->delete();
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
