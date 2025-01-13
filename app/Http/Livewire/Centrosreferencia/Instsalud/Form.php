<?php

namespace App\Http\Livewire\Centrosreferencia\Instsalud;

use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use App\Models\CentrosReferencia\Clasificacion;
use App\Models\CentrosReferencia\Nivel;
use App\Models\CentrosReferencia\Tipologia;
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
    public $Instituciones;

    protected $listeners = ['render'];

    protected function rules()
    {
        return [
            'Instituciones.clasificacion_id' => 'required|numeric',
            'Instituciones.nivel_id' => 'required|numeric',
            'Instituciones.tipologia_id' => 'required|numeric',
            'Instituciones.provincia_id' => 'required|numeric',
            'Instituciones.canton_id' => 'required|numeric',
            'Instituciones.unicodigo' => 'required|max:8',
            'Instituciones.descripcion' => 'required|max:525',
        ];
    }

    public function mount(Institucion $Instituciones, $method){
        $this->Instituciones = $Instituciones;
        $this->method = $method;
        $this->Instituciones->clasificacion_id = 1;
        $this->Instituciones->nivel_id = 1;
        $this->Instituciones->tipologia_id = 1;
        $this->Instituciones->provincia_id = 9;
        $this->Instituciones->canton_id = 75;
    }

    public function render()
    {
        $clasificaciones = Clasificacion::orderBy('id', 'asc')->cursor();
        $tipologias = Tipologia::orderBy('id', 'asc')->cursor();
        $niveles = Nivel::orderBy('id', 'asc')->cursor();
        $provincias = Provincia::orderBy('id','asc')->cursor();
        $cantones = Canton::orderBy('id','asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.centrosreferencia.instsalud.form',compact('clasificaciones','tipologias','niveles','provincias','cantones'));
    }

    public function store(){
        $this->validate();
        $this->Instituciones->save();
        $this->Instituciones = new Institucion();
        $this->alert('success', 'Institucion agregada con exito');
        $this->emit('closeModal');
        $this->emit('render');
    }

    public function storeCustom(){
        $this->validate();
        $this->Instituciones->save();
        $this->Instituciones = new Institucion();
        $this->alert('success', 'Institucion agregada con exito');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Instituciones->update();
        $this->emit('render');
        $this->alert('success', 'Instituciones modificada con exito');
        $this->emit('closeModal');

    }

}
