<?php

namespace App\Http\Livewire\Solicitudenv;

use App\Models\User;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Origen;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Solicitudenv;
use App\Models\GestionDocumental\Asignacion;
use App\Models\RecursosHumanos\Filiacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{

    use WithFileUploads;
    use LivewireAlert;
    
    //User actual
    public $user;

    public $method;
    public $quotation;

    //Tools
    public $SolicitudTmp;
    public $Origenes;
    public $Dependencias;
    public $Solicitudesenv;
    public $Asignaciones;
    public $Areas;
    public $userId;
    public $selectedOrigen = null;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Solicitudesenv.origen_id' => 'sometimes',
            'Solicitudesenv.dependencia_id' => 'sometimes',
            'Solicitudesenv.numerodocumento' => 'required|max:75',
            'Solicitudesenv.fechadocumento' => 'required',
            'Solicitudesenv.fecharecepcion' => 'sometimes',
            'Solicitudesenv.remitente' => 'required|max:175',
            'Solicitudesenv.entidad' => 'sometimes|max:175',
            'Solicitudesenv.descripcion' => 'required|max:175',
            'Solicitudesenv.referencia' => 'sometimes|max:75',
            'Solicitudesenv.sumillado' => 'sometimes|max:175',
            'Solicitudesenv.tiempo' => 'required|numeric',            
            'Solicitudesenv.destino_id' => 'required|numeric',
            'Solicitudesenv.procesado' => 'sometimes',
            'Solicitudesenv.respuesta' => 'sometimes|max:175',
        ];
    }

    public function mount(Solicitudenv $Solicitudenv, $method){
        $this->Solicitudesenv = $Solicitudenv;
        $this->method = $method;
    }

    public function render()
    {
        $origenes = Origen::orderBy('id', 'asc')->cursor();
        $dependencias = Dependencia::orderBy('id', 'asc')->cursor();
        $areas = Area::orderBy('id', 'asc')->cursor();
        
        $this->emit('renderJs');
        return view('livewire.gestiondocumental.solicitudenv.form', compact('origenes','dependencias','areas'));
    }

    public function updatedselectedOrigen($id){
        $this->dependencias = Dependencia::orderBy('id', 'asc')->where('origen_id','=',$id)->get();
        $this->selectedOrigen = $id; 
    }

    public function store(){
        $this->validate();
        $this->Solicitudesenv->procesado = 0;
        $this->Solicitudesenv->save();
        $this->Asignaciones = new Asignacion();
        $this->Asignaciones->solicitud_id=$this->Solicitudesenv->id;
        $this->Asignaciones->area_id=$this->Solicitudesenv->destino_id;
        $this->Asignaciones->numerodocumento=$this->Solicitudesenv->numerodocumento;
        $this->Asignaciones->fechadocumento=$this->Solicitudesenv->fechadocumento;
        $this->Asignaciones->fecharecepcion=$this->Solicitudesenv->fecharecepcion;
        $this->Asignaciones->remitente=$this->Solicitudesenv->remitente;
        $this->Asignaciones->descripcion=$this->Solicitudesenv->descripcion;
        $this->Asignaciones->referencia=$this->Solicitudesenv->referencia;
        $this->Asignaciones->entidad=$this->Solicitudesenv->entidad;
        $this->Asignaciones->sumillado=$this->Solicitudesenv->sumillado;
        $this->Asignaciones->tiempo=$this->Solicitudesenv->tiempo;
        $this->Asignaciones->respuesta=$this->Solicitudesenv->respuesta;
        $this->Asignaciones->estado_id=2;
        $this->Asignaciones->usuario_dirid=Auth::user()->id;
        if ($this->Solicitudesenv->destino_id=9){
            $this->Asignaciones->dirtecnica_id=26;
        }
        $this->Asignaciones->fechaasignacionde=date('Y-m-d');
        $this->Asignaciones->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('solicitudenv.index');
    }

    public function update(){
        $respuesta = '';
        $procesado = 0;
        $this->validate();
        if ($this->Solicitudesenv->respuesta <> ''){
            $this->Solicitudesenv->procesado=1;
            $respuesta = $this->Solicitudesenv->respuesta;
            $procesado = 4;
        }   
        $this->Solicitudesenv->update();
        
        $this->Asignaciones = Asignacion::findOrFail($this->Solicitudesenv->id);     
        $this->Asignaciones->respuesta=$respuesta;
        $this->Asignaciones->procesado=$procesado;
        $this->Asignaciones->fecharespuesta=date('Y-m-d');
        $this->Asignaciones->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('solicitudenv.index');
    }


    public function saveSolicitud(){
        if($this->SolicitudTmp){
            if(Storage::exists($this->Solicitudes->archivo)){
                Storage::delete($this->Solicitudes->archivo);
            }
            $this->Solicitudes->estado_id=2;
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
