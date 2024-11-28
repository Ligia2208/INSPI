<?php

namespace App\Http\Livewire\Especimen;

use App\Models\Plataformas\Especie;
use App\Models\Plataformas\Sexo_especie;
use App\Models\Plataformas\Especimen;
use Livewire\Component;

class Form extends Component
{   
    public $method;
    public $Sexos;
    public $Nacionalidades;
    public $TiposDocumento;
    public $Especimenes;

    protected function rules()
    {
        return [
            'Especimenes.especie_id' => 'required|numeric',
            'Especimenes.ubicacion' => 'required|max:50',
            'Especimenes.procedencia' => 'required|max:150',
            'Especimenes.veterinario' => 'required|max:150',
            'Especimenes.sexo_id' => 'required|numeric',
            'Especimenes.edad' => 'required|numeric',
            'Especimenes.peso' => 'required|numeric',
            'Especimenes.color' => 'required|max:25',
            'Especimenes.codigo_nombre' => 'required|max:150',
            'Especimenes.marcas_particulares' => 'required|max:250',
            'Especimenes.nacimiento_admision' => 'required',
            'Especimenes.alergias' => 'sometimes',
            'Especimenes.intervenciones' => 'sometimes',
        ];
    }

    public function mount(Especimen $Especimenes, $method){
        $this->Especimenes = $Especimenes;
        $this->method = $method;
    }

    public function render()
    {
        $especies = Especie::orderBy('id', 'asc')->cursor();
        $sexos = Sexo_especie::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.plataformas.especimen.form',compact('especies','sexos'));
    }

    public function store(){
        $this->validate();
        $this->Especimenes->save();
        $this->Especimenes = new Especimen();
        $this->alert('success', 'Especimen agregada con exito');
        $this->emit('closeModal');
        $this->emit('render');
    }

    public function storeCustom(){
        $this->validate();
        $this->Especimenes->save();
        $this->Especimenes = new Especimen();
        $this->alert('success', 'Especimen agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Especimenes->update();
        $this->alert('success', 'Especimenes modificada con exito');
        $this->emit('closeModal');
        $this->emit('render');
    }
}
