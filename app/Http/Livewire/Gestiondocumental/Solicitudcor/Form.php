<?php

namespace App\Http\Livewire\Solicitudcor;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Solicitudcor;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\EstadoSolicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Form extends Component
{

    use WithFileUploads;
    
    //User actual
    public $method;
 
    //Tools
    public $SolicitudTmp;
    public $area;
    public $Solicitudescor;
    public $Asignaciones;
    public $Areas;
    public $userId;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Solicitudescor.numerodocumento' => 'required|max:75',
            'Solicitudescor.fechadocumento' => 'required',
            'Solicitudescor.fecharecepcion' => 'required',
            'Solicitudescor.descripcion' => 'required|max:175',
            'Solicitudescor.sumillado' => 'sometimes|max:175',
            'Solicitudescor.archivo' => 'sometimes|max:191',
            'Solicitudescor.area_id' => 'sometimes',
            'Solicitudescor.fechaasignacionde' => 'required',
            'Solicitudescor.fechaasignaciondg' => 'sometimes',
            'Solicitudescor.sumillado_dirgen' => 'required',
            'Solicitudescor.dirtecnica_id' => 'required',
            'Solicitudescor.estado_id' => 'required',
        ];
    }

    public function mount(Solicitudcor $Solicitudcor, $method){
        $this->Solicitudescor = $Solicitudcor;
        $this->method = $method;
    }

    public function render()
    {
        $areas = Area::orderBy('id', 'asc')->cursor();
        $filiaciones = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $filiaciones->area_id;
        $filiaciones = Filiacion::where('area_id', '=', $this->area)->where('cargo_id','<>',6)->cursor();
        $dirtecnicas = Direccion::where('area_id','=',$this->area)->orderBy('id','asc')->cursor();
        $estados = EstadoSolicitud::orderBy('id','asc')->where('validez','=','S')->cursor();
        $this->emit('renderJs');
        return view('livewire.gestiondocumental.solicitudcor.form', compact('estados','areas','filiaciones','dirtecnicas'));
    }

    public function store(){
        $this->validate();
        $this->saveSolicitud();
        $this->Solicitudescor->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('solicitudcor.show', $this->Solicitudescor);
    }

    public function update(){
        $this->validate();
        $this->Solicitudescor->procesado=4;
        $this->Solicitudescor->estado_id=2;
        $this->Solicitudescor->fechaasignaciondg=date('Y-m-d');
        $this->Solicitudescor->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('solicitudcor.show', $this->Solicitudescor);
    }


    public function saveSolicitud(){
        if($this->SolicitudTmp){
            if(Storage::exists($this->Solicitudes->archivo)){
                Storage::delete($this->Solicitudes->archivo);
            }

            $path = $this->SolicitudTmp->store('public/solicitudes/inspi');
            $this->Solicitudes->archivo = $path;
        }
    }

    public function removeSolicitud(){
        if($this->Solicitudes->archivo){
            if(Storage::exists($this->Solicitudes->archivo)){
                Storage::delete($this->Solicitudes->archivo);
            }
            
            $this->Solicitudes->archivo = null;
            $this->Solicitudes->update();
        }
        $this->reset('SolicitudTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
