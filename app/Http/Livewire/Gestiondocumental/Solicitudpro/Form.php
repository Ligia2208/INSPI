<?php

namespace App\Http\Livewire\Solicitudpro;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Solicitudpro;
use App\Models\GestionDocumental\EstadoSolicitud;
use App\Models\GestionDocumental\Asignacion;
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
    public $Solicitudespro;
    public $Asignaciones;
    public $Areas;
    public $userId;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Solicitudespro.numerodocumento' => 'required|max:75',
            'Solicitudespro.fechadocumento' => 'required',
            'Solicitudespro.fecharecepcion' => 'required',
            'Solicitudespro.descripcion' => 'required|max:175',
            'Solicitudespro.sumillado' => 'sometimes|max:175',
            'Solicitudespro.archivo' => 'sometimes|max:191',
            'Solicitudespro.area_id' => 'sometimes',
            'Solicitudespro.fechaasignacionde' => 'required',
            'Solicitudespro.fechaasignaciondg' => 'sometimes',
            'Solicitudespro.sumillado_dirgen' => 'required',
            'Solicitudespro.fechaasignaciondt' => 'sometimes',
            'Solicitudespro.sumillado_dirtec' => 'required',
            'Solicitudespro.usuario_dirid' => 'sometimes',
            'Solicitudespro.respuesta' => 'required',
            'Solicitudespro.estado_id' => 'required',
        ];
    }

    public function mount(Solicitudpro $Solicitudpro, $method){
        $this->Solicitudespro = $Solicitudpro;
        $this->method = $method;
    }

    public function render()
    {
        $areas = Area::orderBy('id', 'asc')->cursor();
        $filiaciones = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $filiaciones->area_id;
        $filiaciones = Filiacion::where('area_id', '=', $this->area)->where('cargo_id','<>',6)->cursor();
        $estados = EstadoSolicitud::orderBy('id','asc')->cursor();

        $this->emit('renderJs');
        return view('livewire.gestiondocumental.solicitudpro.form', compact('areas','filiaciones','estados'));
    }

    public function store(){
        $this->validate();
        $this->saveSolicitud();
        $this->Solicitudespro->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('solicitudpro.show', $this->Solicitudespro);
    }

    public function update(){
        $this->validate();
        $this->Solicitudespro->fecharespuesta=date('Y-m-d');
        $this->Solicitudespro->procesado=4;
        $this->Solicitudespro->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('solicitudpro.show', $this->Solicitudespro);
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
