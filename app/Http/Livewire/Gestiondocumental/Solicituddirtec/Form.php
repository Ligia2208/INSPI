<?php

namespace App\Http\Livewire\Solicituddirtec;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Solicituddirtec;
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
    public $user;

    public $method;
 
    //Tools
    public $SolicitudTmp;
    public $area;
    public $direccion;
    public $Solicitudesdirtec;
    public $Asignaciones;
    public $Areas;
    public $userId;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Solicitudesdirtec.numerodocumento' => 'required|max:75',
            'Solicitudesdirtec.fechadocumento' => 'required',
            'Solicitudesdirtec.fecharecepcion' => 'required',
            'Solicitudesdirtec.descripcion' => 'required|max:175',
            'Solicitudesdirtec.sumillado' => 'sometimes|max:175',
            'Solicitudesdirtec.archivo' => 'sometimes|max:191',
            'Solicitudesdirtec.area_id' => 'sometimes',
            'Solicitudesdirtec.fechaasignacionde' => 'required',
            'Solicitudesdirtec.fechaasignaciondg' => 'sometimes',
            'Solicitudesdirtec.sumillado_dirgen' => 'required',
            'Solicitudesdirtec.usuario_tecid' => 'required',
            'Solicitudesdirtec.sumillado_dirtec' => 'required',
            'Solicitudesdirtec.estado_id' => 'required',
        ];
    }

    public function mount(Solicituddirtec $Solicituddirtec, $method){
        $this->Solicitudesdir = $Solicituddirtec;
        $this->method = $method;
    }

    public function render()
    {
        $areas = Area::orderBy('id', 'asc')->cursor();
        $filiaciones = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $filiaciones->area_id;
        $this->direccion = $filiaciones->direccion_id;
        $filiaciones = Filiacion::where('area_id', '=', $this->area)->where('direccion_id','=',$this->direccion)->where('cargo_id','<>',10)->cursor();
        $estados = EstadoSolicitud::orderBy('id','asc')->where('validez','=','S')->cursor();
        $this->emit('renderJs');
        return view('livewire.gestiondocumental.solicituddirtec.form', compact('estados','areas','filiaciones'));
    }

    public function store(){
        $this->validate();
        $this->saveSolicitud();
        $this->Solicitudesdirtec->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('solicituddirtec.show', $this->Solicitudesdirtec);
    }

    public function update(){
        $this->validate();
        $this->Solicitudesdirtec->procesado=4;
        $this->Solicitudesdirtec->fechaasignaciondt=date('Y-m-d');
        $this->Solicitudesdirtec->fecharespuesta=date('Y-m-d');
        $this->Solicitudesdirtec->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('solicituddirtec.show', $this->Solicitudesdirtec);
    }


    public function saveSolicitud(){
        if($this->SolicitudTmp){
            if(Storage::exists($this->Solicitudesdirtec->archivo)){
                Storage::delete($this->Solicitudesdirtec->archivo);
            }

            $path = $this->SolicitudTmp->store('public/solicitudes/inspi');
            $this->Solicitudesdirtec->archivo = $path;
        }
    }

    public function removeSolicitud(){
        if($this->Solicitudesdirtec->archivo){
            if(Storage::exists($this->Solicitudesdirtec->archivo)){
                Storage::delete($this->Solicitudesdirtec->archivo);
            }
            
            $this->Solicitudesdirtec->archivo = null;
            $this->Solicitudesdirtec->update();
        }
        $this->reset('SolicitudTmp');
        $this->alert('success', 'Archivo digitalizado eliminado con exito');
    }
}
