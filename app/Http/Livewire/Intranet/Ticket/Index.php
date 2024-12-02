<?php

namespace App\Http\Livewire\Ticket;

use App\Models\Intranet\Ticket;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $userPresent;

    //Tools
    public $perPage = 12;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Ticket::where('estado','=','A')->where('funcionario_id','=',Auth::user()->id)->count();
        $Tickets = Ticket::where('estado','=','A')->where('funcionario_id','=',Auth::user()->id)->orderBy('id', 'asc');
        if($this->search){
            $Tickets = $Tickets->whereDate('fechaapertura', '>', "%{$this->search}%");
            $count = Ticket::where('estado','=','A')->whereDate('fechaapertura', '>','%{$this->search}%')->count();

        }
        $Tickets = $Tickets->paginate($this->perPage);
        return view('livewire.intranet.ticket.index', compact('count', 'Tickets'));
    }

    public function destroy($id)
    {
        try{
            $Tickets = Ticket::findOrFail($id);
            if(Storage::exists($Tickets->archivo)){
                Storage::delete($Tickets->archivo);
            }
            $Tickets->estado='I';
            $Tickets->update();
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
