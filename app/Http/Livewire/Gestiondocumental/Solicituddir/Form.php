<?php

namespace App\Http\Livewire\Solicituddir;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Solicituddir;
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
    public $Solicitudesdir;
    public $Asignaciones;
    public $Areas;
    public $userId;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Solicitudesdir.numerodocumento' => 'required|max:75',
            'Solicitudesdir.fechadocumento' => 'required',
            'Solicitudesdir.fecharecepcion' => 'required',
            'Solicitudesdir.descripcion' => 'required|max:175',
            'Solicitudesdir.sumillado' => 'sometimes|max:500',
            'Solicitudesdir.archivo' => 'sometimes|max:191',
            'Solicitudesdir.area_id' => 'sometimes',
            'Solicitudesdir.fechaasignacionde' => 'required',
            'Solicitudesdir.fechaasignaciondg' => 'sometimes',
            'Solicitudesdir.sumillado_dirgen' => 'required|max:2000',
            'Solicitudesdir.estado_id' => 'required',
        ];
    }

    public function mount(Solicituddir $Solicituddir, $method){
        $this->Solicitudesdir = $Solicituddir;
        $this->method = $method;
    }

    public function render()
    {
        $areas = Area::orderBy('id', 'asc')->cursor();
        $filiaciones = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $filiaciones->area_id;
        $filiaciones = Filiacion::where('area_id', '=', $this->area)->where('cargo_id','<>',6)->cursor();
        $estados = EstadoSolicitud::orderBy('id','asc')->where('validez','=','S')->cursor();
        //$users = User::orderBy('id','asc')->cursor();

        $this->emit('renderJs');
        return view('livewire.gestiondocumental.solicituddir.form', compact('estados','areas','filiaciones'));
    }

    public function store(){
        $this->validate();
        $this->saveSolicitud();
        $this->Solicitudesdir->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('solicituddir.show', $this->Solicitudesdir);
    }

    public function update(){
        $this->validate();
        $this->Solicitudesdir->procesado=4;
        $this->Solicitudesdir->estado_id=2;
        $this->Solicitudesdir->fechaasignaciondg=date('Y-m-d');
        $this->Solicitudesdir->fecharespuesta=date('Y-m-d');
        $this->Solicitudesdir->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('solicituddir.show', $this->Solicitudesdir);
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
