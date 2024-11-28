<?php

namespace App\Http\Livewire\Centrosreferencia\Responsable;

use App\Models\CentrosReferencia\Responsable;
use App\Models\CentrosReferencia\Tiporesponsable;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\User;
use Livewire\Component;

class Form extends Component
{
    public $method;
    public $Responsables;
    public $selectedSede = null;

    protected function rules()
    {
        return [
            'Responsables.sedes_id' => 'required|numeric',
            'Responsables.crns_id' => 'required|numeric',
            'Responsables.descripcion' => 'required|max:500',
            'Responsables.usuario_id' => 'required|numeric',
            'Responsables.tipo_id' => 'required|numeric',
        ];
    }

    public function mount(Responsable $Responsables, $method){
        $this->Responsables = $Responsables;
        $this->method = $method;
    }


    public function render()
    {
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $usuarios = User::where('status','=','A')->orderBy('id','ASC')->cursor();
        $tipos = Tiporesponsable::where('estado','=','A')->orderBy('id','ASC')->cursor();
        $crns = Crn::orderBy('id', 'asc')->cursor();
        $this->emit('render');
        $this->emit('renderJs');
        return view('livewire.centrosreferencia.responsable.form',compact('usuarios','sedes','crns','tipos'));
    }

    public function store(){
        $this->validate();
        $this->Responsables->save();
        $this->Responsables = new Responsable();
        $this->alert('success', 'Responsable agregado con exito');
        $this->emit('closeModal');
        $this->emit('renderJs');
        $this->emit('render');
    }

    public function storeCustom(){
        $this->validate();
        $this->Responsables->save();
        $this->Responsables = new Responsable();
        $this->alert('success', 'Responsable agregado con exito');
        $this->emit('closeModal');
        $this->emit('renderJs');
        $this->emit('render');

    }

    public function update(){
        $this->validate();
        $this->Responsables->update();
        $this->alert('success', 'Responsable modificado con exito');
        $this->emit('closeModal');
        $this->emit('renderJs');
        $this->emit('render');
    }
}
