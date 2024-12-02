<?php

namespace App\Http\Livewire\Inventario\Participante;

use App\Models\Inventario\Participante;
use Livewire\Component;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Form extends Component
{
    use LivewireAlert;
    
    public $method;
    public $Participantes;
    public $Anteriores;
    public $Users;

    protected function rules()
    {
        return [
            'Participantes.principal_id' => 'required|numeric',
            'Participantes.guardaalmacen_id' => 'required|numeric',
            'Participantes.analista_id' => 'required|numeric',
            'Participantes.administrativo_id' => 'required|numeric',
        ];
    }

    public function mount(Participante $Participantes, $method){
        $this->Participantes = $Participantes;
        $this->method = $method;
    }

    public function render()
    {
        $users = User::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.inventario.participante.form',compact('users'));
    }

    public function store(){

        $Anteriores = Participante::where('estado','=','A')->orderBy('id', 'asc')->firstOrFail();
        $Anteriores->estado='I';
        $Anteriores->update();

        $this->validate();
        $this->Participantes->fecharegistro=date('Y-m-d');
        $this->Participantes->estado='A';
        $this->Participantes->save();
        $this->Participantes = new Participante();
        $this->alert('success', 'Combinación Participantes agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Participantes->save();
        $this->Participantes = new Participante();
        $this->emit('render');
        $this->alert('success', 'Combinación Participantes agregada con exito');
    }

    public function update(){
        $this->validate();
        $this->Participantes->update();
        $this->emit('render');
        $this->alert('success', 'Combinación Participantes modificada con exito');
        $this->emit('closeModal');
    }
}
