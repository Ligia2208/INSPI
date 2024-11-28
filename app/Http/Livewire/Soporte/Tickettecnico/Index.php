<?php

namespace App\Http\Livewire\Soporte\Tickettecnico;

use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Direcciontecnica;
use App\Models\Soporte\Ticketsupport;
use App\Models\Soporte\Tecnico;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
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
        $idUser = auth()->user()->id;
        $existe = Tecnico::where('status','=','A')->where('usuario_id','=',$idUser)->count();

        if($existe>0){
            $idTecnico = Tecnico::where('status','=','A')->where('usuario_id','=',$idUser)->orderBy('id','ASC')->get();
            //dd($idTecnico); die();
            $count = Ticketsupport::where('status','=','A')->where('tecnico_id','=',$idTecnico[0]->id)->count();
            $tickets = Ticketsupport::where('status','=','A')->where('tecnico_id','=',$idTecnico[0]->id)->orderBy('prioridad_id', 'DESC')->orderBy('id', 'DESC');
        }
        else{
            $count = 0;
            $tickets = Ticketsupport::where('status','=','N')->orderBy('prioridad_id', 'DESC')->orderBy('id', 'DESC');
        }



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

        return view('livewire.soporte.tickettecnico.index', compact('count', 'tickets'));
    }

    public function destroy(Ticketsupport $tickets)
    {
        try{
            $tickets->status='I';
            $tickets->update();
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
