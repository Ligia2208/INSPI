<?php

namespace App\Http\Livewire\Revision;

use App\Models\Intranet\Revision;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Form extends Component
{
    use LivewireAlert;
    
    public $method;
    public $Revisiones;

    protected function rules()
    {
        return [
            'Revisiones.nombreactividad' => 'required|max:175',
            'Revisiones.resumen' => 'required|max:250',
            'Revisiones.whatsapp' => 'sometimes',
            'Revisiones.facebook' => 'sometimes',
            'Revisiones.instagram' => 'sometimes',
            'Revisiones.twitter' => 'sometimes',
            'Revisiones.correo' => 'sometimes',
            'Revisiones.web' => 'sometimes',
            'Revisiones.cerrado' => 'sometimes',
        ];
    }

    public function mount(Revision $Revisiones, $method){
        $this->Revisiones = $Revisiones;
        $this->method = $method;
    }

    public function render()
    {
        return view('livewire.intranet.revision.form');
    }

    public function store(){
        $this->validate();

        $this->Revisiones->save();
        $this->Revisiones = new Revision();
        $this->alert('success', 'Evento 1 agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();

        $this->Revisiones->save();
        $this->Revisiones = new Revision();
        $this->emit('render');
        $this->alert('success', 'Evento 2 agregado con exito');
    }

    public function update(){
        $this->validate();
        $this->Revisiones->update();
        $this->emit('render');
        $this->alert('success', 'Evento modificado con exito');
        $this->emit('closeModal');
    }
}
