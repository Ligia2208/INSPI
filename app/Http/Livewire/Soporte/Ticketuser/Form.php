<?php

namespace App\Http\Livewire\Soporte\Ticketuser;

use App\Models\Soporte\Ticketsupport;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\Soporte\Tipoticket;
use App\Models\Soporte\Detallesticket;
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
    public $EvidenciaTmp;

    protected function rules()
    {
        return [
            'Tickets.tipo_id' => 'required|numeric',
            'Tickets.titulo' => 'required|max:150',
            'Tickets.descripcion' => 'required|max:1250',
        ];
    }

    public function mount(Ticketsupport $Tickets, $method){
        $this->Tickets = $Tickets;
        $this->method = $method;
    }

    public function render()
    {
        $idusuario = Auth::user()->id;
        $usuario = Auth::user()->name;
        $correo = Auth::user()->email;
        $tipos = Tipoticket::where('status','=','A')->orderBy('id','ASC')->cursor();
        $this->emit('renderJs');

        return view('livewire.soporte.ticketuser.form',compact('idusuario','usuario','correo','tipos'));
    }

    public function store(){
        $this->validate();
        $idUser = auth()->user()->id;
        $filiacion = Filiacion::where('status','=','A')->where('user_id','=',$idUser)->get();
        if($filiacion->count()>0){
            $idDireccion = $filiacion[0]->direccion_id;
            $idArea = $filiacion[0]->area_id;
        }
        else{
            $idDireccion = 1;
            $idArea = 1;
        }
        $this->Tickets->area_id = $idArea;
        $this->Tickets->direccion_id = $idDireccion;
        $this->Tickets->usuario_id = $idUser;
        $this->saveEvidencia();
        $this->Tickets->save();

        $detalle = new Detallesticket();
        $detalle->ticket_id = $this->Tickets->id;
        $detalle->titulo = $this->Tickets->titulo;
        $detalle->descripcion = $this->Tickets->descripcion;
        $detalle->usuario_id = $idUser;
        $detalle->funcion = 'Usuario';
        $detalle->archivo = $this->Tickets->archivo;
        $detalle->save();



        $this->Tickets = new Ticketsupport();
        $this->alert('success', 'Ticket agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->saveEvidencia();
        $this->Tickets->save();
        $this->Tickets = new Ticketsupport();
        $this->alert('success', 'Ticket agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->saveEvidencia();
        $this->Tickets->update();
        $this->alert('success', 'Ticket modificado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function saveEvidencia(){
        if($this->EvidenciaTmp){
            if(Storage::exists($this->Tickets->archivo)){
                Storage::delete($this->Tickets->archivo);
            }

            $path = $this->EvidenciaTmp->store('public/tickets/evidencia');
            $path = substr($path, 7);
            $this->Tickets->archivo = $path;
        }
    }

    public function removeEvidencia(){
        if($this->Tickets->archivo){
            if(Storage::exists($this->Tickets->archivo)){
                Storage::delete($this->Tickets->archivo);
            }

            $this->Tickets->archivo = null;
            $this->Tickets->update();
        }
        $this->reset('EvidenciaTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
