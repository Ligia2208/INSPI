<?php

namespace App\Http\Livewire\Soporte\Ticketseguimiento;

use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Direcciontecnica;
use App\Models\Soporte\Ticketsupport;
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
        $count = Ticketsupport::where('status','=','A')->where('tecnico_id','>',1)->count();
        $tickets = Ticketsupport::where('status','=','A')->where('tecnico_id','>',1)->orderBy('id', 'DESC');

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

        return view('livewire.soporte.ticketseguimiento.index', compact('count', 'tickets'));
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
