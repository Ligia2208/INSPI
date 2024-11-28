<?php

namespace App\Http\Livewire\Constante;

use App\Models\Plataformas\Constante;
use Livewire\Component;

class Form extends Component
{   
    public $method;
    public $Constantes;

    protected function rules()
    {
        return [
            'Constantes.fecha' => 'required|max:10',
            'Constantes.frecuencia_fc' => 'required|max:30',
            'Constantes.frecuencia_fr' => 'required|max:30',
            'Constantes.temperatura' => 'required|max:30',
            'Constantes.tlc' => 'required|max:30',
            'Constantes.pulso' => 'required|max:30',
            'Constantes.mucosas' => 'required|max:30',
            'Constantes.turgencia' => 'required|max:120',
            'Constantes.proposito' => 'required|max:750',
            'Constantes.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Constante $Constantes, $method){
        $this->Constantes = $Constantes;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.constante.form');
    }

    public function store(){
        $this->validate();
        $this->Constantes->estado='A';
        $id = $this->Constantes->especimen_id;
        $this->Constantes->save();
        $this->Constantes = new Constante();
        $this->alert('success', 'Constante agregada con exito');
        return redirect()->route('constantes.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Constantes->save();
        $this->Constantes = new Constante();
        $this->alert('success', 'Constante agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Constantes->update();
        $this->alert('success', 'Constante modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
    }
}
