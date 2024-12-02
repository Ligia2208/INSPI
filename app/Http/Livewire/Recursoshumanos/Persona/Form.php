<?php

namespace App\Http\Livewire\Recursoshumanos\Persona;

use App\Models\CoreBase\TipoDocumento;
use App\Models\CoreBase\Nacionalidad;
use App\Models\CoreBase\Sexo;
use App\Models\CoreBase\TipoSangre;
use App\Models\CoreBase\EstadoCivil;
use App\Models\RecursosHumanos\Persona;
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
    public $Sexos;
    public $Nacionalidades;
    public $TiposDocumento;
    public $Personas;
    public $PersonaTmp;

    protected function rules()
    {
        return [
            'Personas.tipodocumento_id' => 'required|numeric',
            'Personas.identidad' => 'required|max:13',
            'Personas.nombres' => 'required|max:75',
            'Personas.apellidos' => 'required|max:75',
            'Personas.sexo_id' => 'required|numeric',
            'Personas.nacionalidad_id' => 'required|numeric',
            'Personas.tiposangre_id' => 'required|numeric',
            'Personas.estadocivil_id' => 'required|numeric',
            'Personas.fechanacimiento' => 'required',
            'Personas.direccion' => 'required|max:175',
            'Personas.telefono' => 'required|max:15',
            'Personas.correo' => 'required|email|max:175',
        ];
    }

    public function mount(Persona $Personas, $method){
        $this->Personas = $Personas;
        $this->method = $method;
    }

    public function render()
    {
        $tiposdocumento = TipoDocumento::orderBy('id', 'asc')->cursor();
        $nacionalidades = Nacionalidad::orderBy('id', 'asc')->cursor();
        $tipossangre = TipoSangre::orderBy('id', 'asc')->cursor();
        $estadoscivil = EstadoCivil::orderBy('id', 'asc')->cursor();
        $sexos = Sexo::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.recursoshumanos.persona.form',compact('estadoscivil','tipossangre','tiposdocumento','nacionalidades','sexos'));
    }

    public function store(){
        $this->validate();
        $this->savePersona();
        $this->Personas->save();
        $this->reset('PersonaTmp');
        $this->Personas = new Persona();
        $this->alert('success', 'Persona agregada con exito');
        $this->emit('closeModal');
        $this->emit('render');
    }

    public function storeCustom(){
        $this->validate();
        $this->savePersona();
        $this->Personas->save();
        $this->reset('PersonaTmp');
        $this->Personas = new Persona();
        $this->alert('success', 'Persona agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->savePersona();
        $this->Personas->update();
        $this->reset('PersonaTmp');
        $this->alert('success', 'Personas modificada con exito');
        $this->emit('closeModal');
        $this->emit('render');
    }

    public function savePersona(){
        if($this->PersonaTmp){
            if(Storage::exists($this->Personas->archivo)){
                Storage::delete($this->Personas->archivo);
            }

            $path = $this->PersonaTmp->store('public/curriculo/inspi');
            $path = substr($path, 7);
            $this->Personas->archivo = $path;
        }
    }

    public function removePersona(){
        if($this->Personas->archivo){
            if(Storage::exists($this->Personas->archivo)){
                Storage::delete($this->Personas->archivo);
            }

            $this->Personas->archivo = null;
            $this->Personas->update();
        }
        $this->reset('PersonaTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
