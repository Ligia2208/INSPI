<?php

namespace App\Http\Livewire\Corebase\Dirtecnica;

use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Direcciontecnica;
use Livewire\Component;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Areas;
    public $Direcciones;

    protected function rules()
    {
        return [
            'Direcciones.nombre' => 'required|max:175',
            'Direcciones.descripcion' => 'required|max:250',
            'Direcciones.direccion_id' => 'required|numeric',
        ];
    }

    public function mount(Direcciontecnica $Direcciones, $method){
        $this->Direcciones = $Direcciones;
        $this->method = $method;
    }

    public function render()
    {
        $direcciong = Direccion::where('status','=','A')->where('tipo_id','=',2)->orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.corebase.dirtecnica.form',compact('direcciong'));
    }

    public function store(){
        $this->validate();
        $this->Direcciones->save();
        $this->Direcciones = new Direcciontecnica();
        $this->alert('success', 'Dirección Técnica agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Direcciones->save();
        $this->Direcciones = new Direcciontecnica();
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
