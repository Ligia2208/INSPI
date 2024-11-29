<?php

namespace App\Http\Livewire\Corebase\Area;

use App\Models\CoreBase\Area;
use Livewire\Component;
//use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    public $method;
    public $Areas;
    //use LivewireAlert;

    protected function rules()
    {
        return [
            'Areas.nombre' => 'required|max:175',
            'Areas.descripcion' => 'required|max:250',
        ];
    }

    public function mount(Area $Areas, $method){
        $this->Areas = $Areas;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.corebase.area.form');
    }

    public function store(){
        $this->validate();
        $this->Areas->estado='A';
        $this->Areas->save();
        $this->Areas = new Area();
        $this->alert('success', 'Área/Dirección agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Areas->save();
        $this->Areas = new Area();
        $this->emit('render');
        $this->alert('success', 'Área/Dirección agregado con exito');
    }

    public function update(){
        $this->validate();
        $this->Areas->update();
        $this->emit('render');
        $this->alert('success', 'Área/Dirección modificado con exito');
        $this->emit('closeModal');
    }
}
