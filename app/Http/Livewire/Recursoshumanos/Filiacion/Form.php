<?php

namespace App\Http\Livewire\Recursoshumanos\Filiacion;

use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Direcciontecnica;
use App\Models\RecursosHumanos\Sede;
use App\Models\RecursosHumanos\Persona;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Cargo;
use App\Models\RecursosHumanos\Escala;
use App\Models\RecursosHumanos\Modalidad;
use App\Models\CoreBase\TipoDiscapacidad;
use App\Models\User;
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

    public $method;
    public $Areas;
    public $direcciones;
    public $direccionestecnicas;
    public $Sedes;
    public $Personas;
    public $Cargos;
    public $Modalidades;
    public $TiposDiscapacidad = 0;
    public $Users;
    public $Filiaciones;
    public $selectedArea = null;
    public $selectedDireccion = null;
    public $FiliacionTmp;

    protected function rules()
    {
        return [
            'Filiaciones.persona_id' => 'required|numeric',
            'Filiaciones.fechaingreso' => 'required|max:10',
            'Filiaciones.area_id' => 'required|numeric',
            'Filiaciones.direccion_id' => 'required|numeric',
            'Filiaciones.direcciontecnica_id' => 'sometimes',
            'Filiaciones.sede_id' => 'required|numeric',
            'Filiaciones.cargo_id' => 'required|numeric',
            'Filiaciones.escala_id' => 'required|numeric',
            'Filiaciones.modalidad_id' => 'required|numeric',
            'Filiaciones.tipodiscapacidad_id' => 'required|numeric',
            'Filiaciones.user_id' => 'required|numeric',
            'Filiaciones.porcentaje' => 'numeric',
            'Filiaciones.carnet' => 'max:15',
            'Filiaciones.mailinstitucional' => 'email',
            'Filiaciones.fechasalida' => 'max:10',
        ];
    }

    public function mount(Filiacion $Filiaciones, $method){
        $this->Filiaciones = $Filiaciones;
        $this->method = $method;
        $this->Filiaciones->user_id = 1;
        if($method=='update'){
            $this->direcciones = Direccion::where('area_id','=',$this->Filiaciones->area_id)->orderBy('id', 'asc')->get();
            $this->direccionestecnicas = Direcciontecnica::where('direccion_id','=',$this->Filiaciones->direccion_id)->orderBy('id', 'asc')->get();
        }
    }

    public function render()
    {
        $personas = Persona::orderBy('id', 'asc')->cursor();
        $areas = Area::orderBy('id', 'asc')->where('status','=','A')->cursor();
        //$direcciones = Direccion::orderBy('id', 'asc')->cursor();
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $cargos = Cargo::orderBy('id', 'asc')->cursor();
        $escalas = Escala::orderBy('id', 'asc')->cursor();
        $modalidades = Modalidad::orderBy('id', 'asc')->cursor();
        $tiposdiscapacidad = TipoDiscapacidad::orderBy('id', 'asc')->cursor();
        $users = User::orderBy('id', 'asc')->cursor();
        $this->emit('render');
        $this->emit('renderJs');
        return view('livewire.recursoshumanos.filiacion.form',compact('personas','areas','sedes','cargos','escalas','modalidades','tiposdiscapacidad','users'));
    }

    public function updatedselectedArea($area_id){
        $this->direcciones = Direccion::where('area_id','=',$area_id)->orderBy('id', 'asc')->get();
    }

    public function updatedselectedDireccion($direc_id){
        $this->direccionestecnicas = Direcciontecnica::where('direccion_id','=',$direc_id)->orderBy('id', 'asc')->get();
    }

    public function store(){
        $this->validate();
        $this->saveFiliacion();
        $this->Filiaciones->save();
        $this->Filiaciones = new Filiacion();
        $this->alert('success', 'Filiación agregada con exito');
        $this->emit('closeModal');
        $this->emit('render');
        $this->emit('renderJs');

    }

    public function storeCustom(){
        $this->validate();
        $this->saveFiliacion();
        $this->Filiaciones->save();
        $this->Filiaciones = new Filiacion();
        $this->alert('success', 'Filiación agregada con exito');
        $this->emit('closeModal');
        $this->emit('render');
        $this->emit('renderJs');
    }

    public function update(){
        $this->validate();
        $this->saveFiliacion();
        $this->Filiaciones->update();
        $this->alert('success', 'Filiación modificada con exito');
        $this->emit('closeModal');
        $this->emit('render');
        $this->emit('renderJs');
    }

    public function saveFiliacion(){
        if($this->FiliacionTmp){
            if(Storage::exists($this->Filiaciones->archivo)){
                Storage::delete($this->Filiaciones->archivo);
            }

            $path = $this->FiliacionTmp->store('public/contrato/inspi');
            $path = substr($path, 7);
            $this->Filiaciones->archivo = $path;

        }
    }

    public function removeFiliacion(){
        if($this->Filiaciones->archivo){
            if(Storage::exists($this->Filiaciones->archivo)){
                Storage::delete($this->Filiaciones->archivo);
            }

            $this->Filiaciones->archivo = null;
            $this->Filiaciones->update();
        }
        $this->reset('FiliacionTmp');
        $this->alert('success', 'Archivo digitalizado eliminado con exito');
    }
}
