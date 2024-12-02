<?php

namespace App\Http\Livewire\Parasito;

use App\Models\Plataformas\Parasito;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Parasitos;

    protected function rules()
    {
        return [
            'Parasitos.nombre' => 'required|max:175',
            'Parasitos.fecha' => 'required|max:10',
            'Parasitos.descripcion' => 'required|max:250',
            'Parasitos.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Parasito $Parasitos, $method){
        $this->Parasitos = $Parasitos;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.parasito.form');
    }

    public function store(){
        $this->validate();
        $this->Parasitos->estado='A';
        $id = $this->Parasitos->especimen_id;
        $this->Parasitos->save();
        $this->Parasitos = new Parasito();
        $this->alert('success', 'Desparasitación agregada con exito');
        return redirect()->route('parasito.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Parasitos->save();
        $this->Parasitos = new Parasito();
        $this->alert('success', 'Desparasitación agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Parasitos->update();
        $this->alert('success', 'Parasito modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
    }
}
