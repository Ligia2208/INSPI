<?php

namespace App\Http\Livewire\Dieta;

use App\Models\Plataformas\Dieta;
use Livewire\Component;

class Form extends Component
{   
    public $method;
    public $Dietas;

    protected function rules()
    {
        return [
            'Dietas.fecha' => 'required|max:10',
            'Dietas.descripcion' => 'required|max:750',
            'Dietas.especimen_id' => 'required|numeric',
        ];
    }

    public function mount(Dieta $Dietas, $method){
        $this->Dietas = $Dietas;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.plataformas.dieta.form');
    }

    public function store(){
        $this->validate();
        $this->Dietas->estado='A';
        $id = $this->Dietas->especimen_id;
        $this->Dietas->save();
        $this->Dietas = new Dieta();
        $this->alert('success', 'Dieta agregada con exito');
        return redirect()->route('dieta.show', $id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Dietas->save();
        $this->Dietas = new Dieta();
        $this->alert('success', 'Dieta agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Dietas->update();
        $this->alert('success', 'Dieta modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
        return redirect()->route('especimen.index');
        
    }
}
