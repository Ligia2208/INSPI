<?php

namespace App\Http\Livewire\Soporte\Ticketseguimiento;

use App\Models\Soporte\Ticketsupport;
use App\Models\Soporte\Tipoticket;
use App\Models\Soporte\Categoria;
use App\Models\Soporte\Identificador;
use App\Models\Soporte\Prioridad;
use App\Models\Soporte\Tecnico;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    public $method;

    protected function rules()
    {
        return [
            'Tickets.titulo' => 'required|max:150',
            'Tickets.descripcion' => 'required|max:1250',
            'Tickets.tipo_id' => 'required|numeric',
            'Tickets.area_id' => 'required|numeric',
            'Tickets.direccion_id' => 'required|numeric',
            'Tickets.categoria_id' => 'required|numeric',
            'Tickets.identificador_id' => 'required|numeric',
            'Tickets.tecnico_id' => 'required|numeric',
            'Tickets.prioridad_id' => 'required|numeric',
        ];
    }

    public function mount(Ticketsupport $Tickets, $method){
        $this->Tickets = $Tickets;
        $this->method = $method;
    }

    public function render()
    {
        $userf = User::where('status','=','A')->where('id','=',$this->Tickets->usuario_id)->get();
        if ($userf->count()>0){
            $idusuario = $userf[0]->id;
            $usuario = $userf[0]->name;
            $correo = $userf[0]->email;
        }
        else{
            $idusuario = 1;
            $usuario = "Sin asignación";
            $correo = "info@inspi.gob.ec";
        }

        $areas = Area::where('status','=','A')->orderBy('id','ASC')->cursor();
        $direcciones = Direccion::where('status','=','A')->orderBy('id','ASC')->cursor();
        $tipos = Tipoticket::where('status','=','A')->orderBy('id','ASC')->cursor();
        $prioridades = Prioridad::where('status','=','A')->orderBy('id','ASC')->cursor();
        $tecnicos = Tecnico::where('status','=','A')->orderBy('id','ASC')->cursor();
        $categorias = Categoria::where('status','=','A')->orderBy('id','ASC')->cursor();
        $identificadores = Identificador::where('status','=','A')->orderBy('id','ASC')->cursor();
        $this->emit('renderJs');

        return view('livewire.soporte.ticketseguimiento.form',compact('idusuario','usuario','correo','tipos','areas','direcciones','tecnicos','categorias','identificadores','prioridades'));
    }

    public function store(){

        $this->validate();
        $this->Tickets->save();
        $this->Tickets = new Ticketsupport();
        $this->alert('success', 'Ticket agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Tickets->save();
        $this->Tickets = new Ticketsupport();
        $this->alert('success', 'Ticket agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Tickets->update();
        $this->alert('success', 'Ticket actualizado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

}
