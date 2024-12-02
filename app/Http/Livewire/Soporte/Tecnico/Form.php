<?php

namespace App\Http\Livewire\Soporte\Tecnico;

use App\Models\Soporte\Tecnico;
use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;
    
    public $method;
    public $Tecnicos;

    protected function rules()
    {
        return [
            'Tecnicos.nombre' => 'required|max:175',
            'Tecnicos.descripcion_actividades' => 'required|max:500',
            'Tecnicos.usuario_id' => 'required|numeric',
        ];
    }

    public function mount(Tecnico $Tecnicos, $method){
        $this->Tecnicos = $Tecnicos;
        $this->method = $method;

    }

    public function render()
    {
        $usuarios = User::where('status','=','A')->orderBy('id','ASC')->cursor();
        return view('livewire.soporte.tecnico.form',compact('usuarios'));
    }

    public function store(){
        $this->validate();
        $this->Tecnicos->save();
        $this->Tecnicos = new Tecnico();
        $this->alert('success', 'Técnico agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Tecnicos->save();
        $this->Tecnicos = new Tecnico();
        $this->emit('render');
        $this->alert('success', 'Técnico agregado con exito');
    }

    public function update(){
        $this->validate();
        $this->Tecnicos->update();
        $this->emit('render');
        $this->alert('success', 'Técnico modificado con exito');
        $this->emit('closeModal');
    }
}
