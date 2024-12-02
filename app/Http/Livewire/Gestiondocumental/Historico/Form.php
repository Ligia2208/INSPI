<?php

namespace App\Http\Livewire\Historico;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Historico;
use App\Models\GestionDocumental\EstadoSolicitud;
use App\Models\GestionDocumental\Asignacion;
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
 
    //Tools
    public $SolicitudTmp;
    public $area;
    public $Historicos;
    public $Asignaciones;
    public $Areas;
    public $userId;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Historicos.numerodocumento' => 'required|max:75',
            'Historicos.fechadocumento' => 'required',
            'Historicos.fecharecepcion' => 'required',
            'Historicos.descripcion' => 'required|max:500',
            'Historicos.sumillado' => 'sometimes|max:500',
            'Historicos.archivo' => 'sometimes|max:191',
            'Historicos.area_id' => 'sometimes',
            'Historicos.fechaasignacionde' => 'required',
            'Historicos.fechaasignaciondg' => 'sometimes',
            'Historicos.sumillado_dirgen' => 'required',
            'Historicos.usuario_dirid' => 'required',
            'Historicos.respuesta' => 'required',
            'Historicos.estado_id' => 'required',
        ];
    }

    public function mount(Historico $Historico, $method){
        $this->Historicos = $Historico;
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
        return view('livewire.gestiondocumental.seguimiento.form', compact('areas','filiaciones','estados'));
    }

    public function store(){
        $this->validate();
        $this->validate([
            'SolicitudTmp' => 'required',
        ]);
        $this->saveSolicitud();
        $this->Historicos->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('seguimiento.show', $this->Historicos);
    }

    public function update(){
        $this->validate();
        $this->saveSolicitud();
        $this->Historicos->fecharespuesta=date('Y-m-d');
        $this->Historicos->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('seguimiento.show', $this->Historicos);
    }


    public function saveSolicitud(){
        if($this->SolicitudTmp){
            if(Storage::exists($this->Historicos->archivo)){
                Storage::delete($this->Historicos->archivo);
            }

            $path = $this->SolicitudTmp->store('public/solicitudes/inspi');
            $this->Historicos->archivo = $path;
        }
    }

    public function removeSolicitud(){
        if($this->Historicos->archivo){
            if(Storage::exists($this->Historicos->archivo)){
                Storage::delete($this->Historicos->archivo);
            }
            
            $this->Historicos->archivo = null;
            $this->Historicos->update();
        }
        $this->reset('SolicitudTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
