<?php

namespace App\Http\Livewire\Corebase\Cargo;

use App\Models\CoreBase\Cargo;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use Livewire\Component;

class Form extends Component
{
    public $method;
    public $Cargos;
    //public $direcciones;
    public $selectedArea = null;

    protected function rules()
    {
        return [
            'Cargos.nombre' => 'required|max:175',
            'Cargos.descripcion' => 'required|max:250',
            'Cargos.area_id' => 'required|numeric',
            'Cargos.direccion_id' => 'required|numeric',
        ];
    }

    public function mount(Cargo $Cargos, $method){
        $this->Cargos = $Cargos;
        $this->method = $method;
    }

    public function updatedselectedArea($area_id){
        $this->direcciones = Direccion::where('area_id','=',$area_id)->orderBy('id', 'asc')->get();
    }

    public function render()
    {
        $areas = Area::where('status','=','A')->orderBy('id','ASC')->cursor();
        $direcciones = Direccion::where('status','=','A')->orderBy('id','ASC')->cursor();
        $this->emit('render');
        $this->emit('renderJs');
        return view('livewire.corebase.cargo.form',compact('areas','direcciones'));
    }

    public function store(){
        $this->validate();
        $this->Cargos->save();
        $this->Cargos = new Cargo();
        $this->alert('success', 'Cargo agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Cargos->save();
        $this->Cargos = new Cargo();
        $this->emit('render');
        $this->alert('success', 'Cargo agregado con exito');
    }

    public function update(){
        $this->validate();
        $this->Cargos->update();
        $this->emit('render');
        $this->alert('success', 'Cargo modificado con exito');
        $this->emit('closeModal');
    }
}
