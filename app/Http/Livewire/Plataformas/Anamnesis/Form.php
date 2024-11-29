<?php

namespace App\Http\Livewire\Anamnesis;

use App\Models\Plataformas\Anamnesis;
use Livewire\Component;

class Form extends Component
{   
    public $method;
    public $Anamnesiss;

    protected function rules()
    {
        return [
            'Anamnesiss.fecha' => 'required|max:10',
            'Anamnesiss.descripcion' => 'required|max:1250',
            'Anamnesiss.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Anamnesis $Anamnesiss, $method){
        $this->Anamnesiss = $Anamnesiss;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.anamnesis.form');
    }

    public function store(){
        $this->validate();
        $this->Anamnesiss->estado='A';
        $id = $this->Anamnesiss->especimen_id;
        $this->Anamnesiss->save();
        $this->Anamnesiss = new Anamnesis();
        $this->alert('success', 'Anamnesis agregada con exito');
        return redirect()->route('anamnesis.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Anamnesiss->save();
        $this->Anamnesiss = new Anamnesis();
        $this->alert('success', 'Anamnesis agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Anamnesiss->update();
        $this->alert('success', 'Anamnesis modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
    }
}
