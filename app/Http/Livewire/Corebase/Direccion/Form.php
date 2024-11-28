<?php

namespace App\Http\Livewire\Corebase\Direccion;

use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use Livewire\Component;

class Form extends Component
{
    public $method;
    public $Areas;
    public $Direcciones;

    protected function rules()
    {
        return [
            'Direcciones.nombre' => 'required|max:175',
            'Direcciones.descripcion' => 'required|max:250',
            'Direcciones.area_id' => 'required|numeric',
        ];
    }

    public function mount(Direccion $Direcciones, $method){
        $this->Direcciones = $Direcciones;
        $this->method = $method;
    }

    public function render()
    {
        $areas = Area::where('status','=','A')->orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.corebase.direccion.form',compact('areas'));
    }

    public function store(){
        $this->validate();
        $this->Direcciones->save();
        $this->Direcciones = new Direccion();
        $this->alert('success', 'Dirección Técnica agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Direcciones->save();
        $this->Direcciones = new Direccion();
        $this->alert('success', 'Dirección Técnica agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Direcciones->update();
        $this->alert('success', 'Dirección Técnica modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }
}
