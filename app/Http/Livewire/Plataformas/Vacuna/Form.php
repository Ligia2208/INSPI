<?php

namespace App\Http\Livewire\Vacuna;

use App\Models\Plataformas\Vacuna;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Vacunas;

    protected function rules()
    {
        return [
            'Vacunas.nombre' => 'required|max:175',
            'Vacunas.fecha' => 'required|max:10',
            'Vacunas.descripcion' => 'required|max:250',
            'Vacunas.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Vacuna $Vacunas, $method){
        $this->Vacunas = $Vacunas;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.vacuna.form');
    }

    public function store(){
        $this->validate();
        $this->Vacunas->estado='A';
        $id = $this->Vacunas->especimen_id;
        $this->Vacunas->save();
        $this->Vacunas = new Vacuna();
        $this->alert('success', 'Vacuna agregada con exito');
        return redirect()->route('vacunas.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Vacunas->save();
        $this->Vacunas = new Vacuna();
        $this->alert('success', 'Vacuna agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Vacunas->update();
        $this->alert('success', 'Vacuna modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
    }
}
