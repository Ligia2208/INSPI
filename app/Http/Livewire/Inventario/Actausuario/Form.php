<?php

namespace App\Http\Livewire\Inventario\Actausuario;

use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\Inventario\Articulo;
use App\Models\RecursosHumanos\Sede;
use App\Models\RecursosHumanos\Persona;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Cargo;
use App\Models\RecursosHumanos\Escala;
use App\Models\RecursosHumanos\Modalidad;
use App\Models\CoreBase\TipoDiscapacidad;
use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Areas;
    public $direcciones;
    public $Sedes;
    public $Personas;
    public $Cargos;
    public $Modalidades;
    public $TiposDiscapacidad;
    public $Users;
    public $Filiaciones;
    public $selectedArea = null;

    protected function rules()
    {
        return [
            'Filiaciones.persona_id' => 'required|numeric',
            'Filiaciones.fechaingreso' => 'required|max:10',
            'Filiaciones.area_id' => 'required|numeric',
            'Filiaciones.direccion_id' => 'required|numeric',
            'Filiaciones.sede_id' => 'required|numeric',
            'Filiaciones.cargo_id' => 'required|numeric',
            'Filiaciones.escala_id' => 'required|numeric',
            'Filiaciones.modalidad_id' => 'required|numeric',
            'Filiaciones.tipodiscapacidad_id' => 'required|numeric',
            'Filiaciones.user_id' => 'required|numeric',
            'Filiaciones.porcentaje' => 'numeric',
            'Filiaciones.carnet' => 'max:15',
            'Filiaciones.mailinstitucional' => 'required|email',
        ];
    }

    public function mount(Filiacion $Filiaciones, $method){
        $this->Filiaciones = $Filiaciones;
        $this->method = $method;
    }

    public function render()
    {
        $personas = Persona::orderBy('id', 'asc')->cursor();
        $areas = Area::orderBy('id', 'asc')->cursor();
        $direcciones = Direccion::orderBy('id', 'asc')->cursor();
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $cargos = Cargo::orderBy('id', 'asc')->cursor();
        $escalas = Escala::orderBy('id', 'asc')->cursor();
        $modalidades = Modalidad::orderBy('id', 'asc')->cursor();
        $tiposdiscapacidad = TipoDiscapacidad::orderBy('id', 'asc')->cursor();
        $users = User::orderBy('id', 'asc')->cursor();
        $articulos = Articulo::where('usuario_id','=',$this->Filiaciones->user_id)->orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.inventario.actausuario.form',compact('personas','areas','sedes','cargos','escalas','modalidades','tiposdiscapacidad','users','articulos'));
    }

    public function store(){
        $this->validate();
        $this->Filiaciones->save();
        $this->Filiaciones = new Filiacion();
        $this->alert('success', 'Filiación agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Filiaciones->save();
        $this->Filiaciones = new Filiacion();
        $this->alert('success', 'Filiación agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Filiaciones->update();
        $this->alert('success', 'Filiación modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }
}
