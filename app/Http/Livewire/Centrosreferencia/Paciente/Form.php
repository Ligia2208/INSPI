<?php

namespace App\Http\Livewire\Centrosreferencia\Paciente;

use App\Models\CoreBase\TipoDocumento;
use App\Models\CoreBase\Nacionalidad;
use App\Models\CoreBase\Sexo;
use App\Models\CoreBase\TipoSangre;
use App\Models\CoreBase\EstadoCivil;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $method;
    public $Sexos;
    public $Nacionalidades;
    public $TiposDocumento;
    public $Pacientes;

    protected $listeners = ['render'];

    protected function rules()
    {
        return [
            'Pacientes.tipodocumento_id' => 'required|numeric',
            'Pacientes.identidad' => 'required|max:13',
            'Pacientes.nombres' => 'required|max:75',
            'Pacientes.apellidos' => 'required|max:75',
            'Pacientes.sexo_id' => 'required|numeric',
            'Pacientes.nacionalidad_id' => 'required|numeric',
            'Pacientes.tiposangre_id' => 'required|numeric',
            'Pacientes.estadocivil_id' => 'required|numeric',
            'Pacientes.provincia_id' => 'required|numeric',
            'Pacientes.canton_id' => 'required|numeric',
            'Pacientes.fechanacimiento' => 'required',
            'Pacientes.direccion' => 'required|max:175',
            'Pacientes.telefono' => 'required|max:15',
            'Pacientes.correo' => 'required|email|max:175',
        ];
    }

    public function mount(Paciente $Pacientes, $method){
        $this->Pacientes = $Pacientes;
        $this->method = $method;
        $this->Pacientes->tipodocumento_id = 1;
        $this->Pacientes->estadocivil_id = 1;
        $this->Pacientes->tiposangre_id = 1;
    }

    public function render()
    {
        $tiposdocumento = TipoDocumento::orderBy('id', 'asc')->cursor();
        $nacionalidades = Nacionalidad::orderBy('id', 'asc')->cursor();
        $tipossangre = TipoSangre::orderBy('id', 'asc')->cursor();
        $estadoscivil = EstadoCivil::orderBy('id', 'asc')->cursor();
        $sexos = Sexo::orderBy('id', 'asc')->cursor();
        $provincias = Provincia::orderBy('id','asc')->cursor();
        $cantones = Canton::orderBy('id','asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.centrosreferencia.paciente.form',compact('estadoscivil','tipossangre','tiposdocumento','nacionalidades','sexos','provincias','cantones'));
    }

    public function store(){
        $this->validate();
        $this->Pacientes->save();
        $this->Pacientes = new Paciente();
        $this->alert('success', 'Paciente agregada con exito');
        $this->emit('closeModal');
        $this->emit('render');
    }

    public function storeCustom(){
        $this->validate();
        $this->Pacientes->save();
        $this->Pacientes = new Paciente();
        $this->alert('success', 'Paciente agregada con exito');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Pacientes->update();
        $this->emit('render');
        $this->alert('success', 'Pacientes modificada con exito');
        $this->emit('closeModal');

    }

}
