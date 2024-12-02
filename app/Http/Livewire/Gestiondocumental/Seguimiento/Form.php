<?php

namespace App\Http\Livewire\Seguimiento;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Dependencia;
use App\Models\GestionDocumental\Seguimiento;
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
    public $Seguimientos;
    public $Asignaciones;
    public $Areas;
    public $userId;

    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Seguimientos.numerodocumento' => 'required|max:75',
            'Seguimientos.fechadocumento' => 'required',
            'Seguimientos.fecharecepcion' => 'required',
            'Seguimientos.descripcion' => 'required|max:500',
            'Seguimientos.sumillado' => 'sometimes|max:500',
            'Seguimientos.archivo' => 'sometimes|max:191',
            'Seguimientos.area_id' => 'sometimes',
            'Seguimientos.fechaasignacionde' => 'required',
            'Seguimientos.fechaasignaciondg' => 'sometimes',
            'Seguimientos.sumillado_dirgen' => 'required',
            'Seguimientos.usuario_dirid' => 'required',
            'Seguimientos.respuesta' => 'required',
            'Seguimientos.estado_id' => 'required',
        ];
    }

    public function mount(Seguimiento $Seguimiento, $method){
        $this->Seguimientos = $Seguimiento;
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
        $this->Seguimientos->save();
        session()->flash('alert', 'Solicitud agregada');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('seguimiento.show', $this->Seguimientos);
    }

    public function update(){
        $this->validate();
        $this->saveSolicitud();
        $this->Seguimientos->fecharespuesta=date('Y-m-d');
        $this->Seguimientos->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('seguimiento.show', $this->Seguimientos);
    }


    public function saveSolicitud(){
        if($this->SolicitudTmp){
            if(Storage::exists($this->Seguimientos->archivo)){
                Storage::delete($this->Seguimientos->archivo);
            }

            $path = $this->SolicitudTmp->store('public/solicitudes/inspi');
            $this->Seguimientos->archivo = $path;
        }
    }

    public function removeSolicitud(){
        if($this->Seguimientos->archivo){
            if(Storage::exists($this->Seguimientos->archivo)){
                Storage::delete($this->Seguimientos->archivo);
            }
            
            $this->Seguimientos->archivo = null;
            $this->Seguimientos->update();
        }
        $this->reset('SolicitudTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
