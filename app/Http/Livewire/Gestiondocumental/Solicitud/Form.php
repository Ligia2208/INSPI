<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\GestionDocumental\Origen;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Solicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Form extends Component
{

    use WithFileUploads;
    
    public $method;
    public $quotation;

    //Tools
    public $SolicitudTmp;
    public $Origenes;
    public $Dependencias;
    public $Solicitudes;
    public $Areas;
    public $selectedOrigen = null;
    
    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Solicitudes.origen_id' => 'required|numeric',
            'Solicitudes.dependencia_id' => 'required|numeric',
            'Solicitudes.numerodocumento' => 'required|max:75',
            'Solicitudes.fechadocumento' => 'required',
            'Solicitudes.fecharecepcion' => 'required',
            'Solicitudes.descripcion' => 'required|max:175',
            'Solicitudes.sumillado' => 'sometimes|max:175',
        ];
    }

    public function mount(Solicitud $Solicitud, $method){
        $Origenes = Origen::orderBy('id', 'asc')->cursor();
        $Dependencias = collect();
        $this->Solicitudes = $Solicitud;
        $this->method = $method;
        
    }

    public function updatedselectedOrigen($id){
        $this->dependencias = Dependencia::orderBy('id', 'asc')->where('origen_id','=',$id)->get();
        $this->selectedOrigen = $id;    
    }

    public function render()
    {
        $origenes = Origen::orderBy('id', 'asc')->cursor();
        $dependencias = Dependencia::orderBy('id', 'asc')->cursor();
        
        $this->emit('renderJs');
        return view('livewire.gestiondocumental.solicitud.form', compact('origenes','dependencias'));
    }


    public function store(){
        $this->validate();
        $this->Solicitudes->tiempo=0;
        $this->saveSolicitud();
        $this->Solicitudes->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('solicitud.show', $this->Solicitudes);
    }

    public function update(){
        $this->validate();
        $this->Solicitudes->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('solicitud.show', $this->Solicitudes);
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
