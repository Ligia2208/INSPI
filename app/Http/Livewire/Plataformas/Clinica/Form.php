<?php

namespace App\Http\Livewire\Clinica;

use App\Models\Plataformas\Clinica;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Clinicas;

    protected function rules()
    {
        return [
            'Clinicas.fecha' => 'required|max:10',
            'Clinicas.descripcion' => 'required|max:1250',
            'Clinicas.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Clinica $Clinicas, $method){
        $this->Clinicas = $Clinicas;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.clinica.form');
    }

    public function store(){
        $this->validate();
        $this->Clinicas->estado='A';
        $id = $this->Clinicas->especimen_id;
        $this->Clinicas->save();
        $this->Clinicas = new Clinica();
        $this->alert('success', 'Manifestaciones Clínicas agregada con exito');
        return redirect()->route('clinica.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Clinicas->save();
        $this->Clinicas = new Clinica();
        $this->emit('render');
        $this->alert('success', 'Manifestaciones Clínicas agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Clinicas->update();
        $this->alert('success', 'Manifestaciones Clínicas modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
    }
}
