<?php

namespace App\Http\Livewire\Soporte\Ticketurgente;

use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Direcciontecnica;
use App\Models\Soporte\Ticketsupport;
use App\Models\Soporte\Detallesticket;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $searchi;
    public $searchd;
    public $searcht;
    protected $queryString = ['searchi' => ['except' => ''], 'searchd' => ['except' => ''], 'searcht' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    //Listeners
    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Ticketsupport::where('status','=','A')->where('tecnico_id','>',1)->whereIn('estadoticket_id',[1,2,3,5,6])->where('prioridad_id','=',4)->count();
        $tickets = Ticketsupport::where('status','=','A')->where('tecnico_id','>',1)->whereIn('estadoticket_id',[1,2,3,5,6])->where('prioridad_id','=',4)->orderBy('id', 'DESC');

        if($this->searchi){
            $tickets = $tickets->where('id','=', $this->searchi);
            $count = $tickets->count();
        }

        if($this->searchd){
            $tickets = $tickets->where('descripcion', 'LIKE' ,"%{$this->searchd}%");
            $count = $tickets->count();
        }

        if($this->searcht){
            $tickets = $tickets->where('titulo', 'LIKE' ,"%{$this->searcht}%");
            $count = $tickets->count();
        }

        $tickets = $tickets->paginate($this->perPage);

        return view('livewire.soporte.ticketurgente.index', compact('count', 'tickets'));
    }

    public function destroy(Ticketsupport $tickets)
    {
        try{
            $tickets->estadoticket_id=7;
            $tickets->update();

            $idUser = auth()->user()->id;
            $detalle = new Detallesticket();
            $detalle->ticket_id = $tickets->id;
            $detalle->titulo = "Cierre de Ticket por Administrador";
            $detalle->descripcion = "Cerrado por decisión del Administrador";
            $detalle->usuario_id = $idUser;
            $detalle->funcion = 'Gestor';
            $detalle->save();

            $this->alert('success', 'Eliminación con exito');
        }catch(Exception $e){
            $this->alert('error',
                'Ocurrio un error en la eliminación: '.$e->getMessage(),
                [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entiendo',
                    'timer' => null,
                ]);
        }
    }
}
