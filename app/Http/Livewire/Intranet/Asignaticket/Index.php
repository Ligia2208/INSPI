<?php

namespace App\Http\Livewire\Asignaticket;

use App\Models\Intranet\Ticket;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

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
        $count = DB::table('inspi_intranet.intic_tickets')->join('users','users.id','=','inspi_intranet.intic_tickets.funcionario_id')->count();
        $Tickets = DB::table('inspi_intranet.intic_tickets')->join('users','users.id','=','inspi_intranet.intic_tickets.funcionario_id')->select('inspi_intranet.intic_tickets.id as id','inspi_intranet.intic_tickets.titulo as titulo','inspi_intranet.intic_tickets.descripcion as descripcion','users.name as usuario')->orderBy('id', 'asc');

        if($this->search){
            $Tickets = $Tickets->where('descripcion', 'LIKE', "%{$this->search}%");
            $count = $Tickets->count();
        }

        $Tickets = $Tickets->paginate($this->perPage);

        return view('livewire.intranet.asignaticket.index', compact('count', 'Tickets'));
    }

    public function destroy(Ticket $Tickets)
    {
        try{
            $Tickets->delete();
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
