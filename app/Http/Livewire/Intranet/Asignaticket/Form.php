<?php

namespace App\Http\Livewire\Asignaticket;

use App\Models\Intranet\Ticket;
use App\Models\CoreBase\Area;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;
    public $method;
    public $Areas;
    public $Tickets;

    protected function rules()
    {
        return [
            'Tickets.nombre' => 'required|max:175',
            'Tickets.descripcion' => 'required|max:250',
            'Tickets.area_id' => 'required|numeric',
        ];
    }

    public function mount(Ticket $Tickets, $method){
        $this->Tickets = $Tickets;
        $this->method = $method;
    }

    public function render()
    {
        $areas = Area::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.intranet.asignaticket.form',compact('areas'));
    }

    public function store(){
        $this->validate();
        $this->Tickets->save();
        $this->Tickets = new Ticket();
        $this->alert('success', 'Dirección Técnica agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Tickets->save();
        $this->Tickets = new Ticket();
        $this->alert('success', 'Dirección Técnica agregada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Tickets->update();
        $this->alert('success', 'Dirección Técnica modificada con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }
}
