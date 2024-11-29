<?php

namespace App\Http\Livewire\Ticket;

use App\Models\Intranet\Ticket;
use App\Models\Intranet\Prioridad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Form extends Component
{

    use WithFileUploads;
    
    public $method;

    //Tools
    public $TicketTmp;
    public $Origenes;
    public $Tickets;
    public $Areas;


    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Tickets.titulo' => 'required|max:150',
            'Tickets.descripcion' => 'required|max:1250',           
        ];
    }

    public function mount(Ticket $Ticket, $method){
        $this->Tickets = $Ticket;
        $this->method = $method;
        
    }

    public function render()
    {
        $prioridades = Prioridad::orderBy('id', 'asc')->cursor();    
        $this->emit('renderJs');
        return view('livewire.intranet.ticket.form', compact('prioridades'));
    }


    public function store(){
        $this->validate();
        $this->validate([
            'TicketTmp' => 'sometimes',
        ]);
        $this->saveTicket();
        $this->Tickets->funcionario_id=Auth::user()->id;
        $this->Tickets->categoria_id=0;
        $this->Tickets->identificador_id=0;
        $this->Tickets->fechaapertura=date('Y-m-d H:i:s', time());
        $this->Tickets->estadoticket_id=1;
        $this->Tickets->prioridad_id=1;
        $this->Tickets->tecnico_id=1;
        $this->Tickets->estado='A';
        $this->Tickets->save();
        session()->flash('alert', 'Ticket agregado');
        session()->flash('alert-type', 'success');
        return redirect()->route('ticket.index');
        
    }

    public function update(){
        $this->validate();
        $this->saveTicket();
        $this->Tickets->update();
        session()->flash('alert', 'Ticket actualizado con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('ticket.index');
        
    }


    public function saveTicket(){
        if($this->TicketTmp){
            if(Storage::exists($this->Tickets->archivo)){
                Storage::delete($this->Tickets->archivo);
            }
            
            $path = $this->TicketTmp->store('public/tickets/inspi');
            $this->Tickets->archivo = $path;
        }
    }

    public function removeTicket(){
        if($this->Tickets->archivo){
            if(Storage::exists($this->Tickets->archivo)){
                Storage::delete($this->Tickets->archivo);
            }
            
            $this->Tickets->archivo = null;
            $this->Tickets->update();
        }
        $this->reset('TicketTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
