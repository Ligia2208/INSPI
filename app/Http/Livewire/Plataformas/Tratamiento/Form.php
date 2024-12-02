<?php

namespace App\Http\Livewire\Tratamiento;

use App\Models\Plataformas\Tratamiento;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Tratamientos;

    protected function rules()
    {
        return [
            'Tratamientos.fecha' => 'required|max:10',
            'Tratamientos.descripcion' => 'required|max:1250',
            'Tratamientos.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Tratamiento $Tratamientos, $method){
        $this->Tratamientos = $Tratamientos;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.tratamiento.form');
    }

    public function store(){
        $this->validate();
        $this->Tratamientos->estado='A';
        $id = $this->Tratamientos->especimen_id;
        $this->Tratamientos->save();
        $this->Tratamientos = new Tratamiento();
        $this->alert('success', 'Tratamiento agregado con exito');
        return redirect()->route('tratamiento.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Tratamientos->save();
        $this->Tratamientos = new Tratamiento();
        $this->alert('success', 'Tratamiento agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Tratamientos->update();
        $this->alert('success', 'Tratamiento modificado con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
    }
}
