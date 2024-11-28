<?php

namespace App\Http\Livewire\Solicitudenv;

use App\Models\User;
use App\Models\GestionDocumental\Solicitudenv;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
       
    //Tools
    public $perPage = 10;
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
        $count = Solicitudenv::where('procesado','=',0)->count();
        $Solicitudesenv = Solicitudenv::where('procesado','=',0)->orderBy('procesado','asc')->orderBy('id', 'desc');       
        if($this->search){
            $Solicitudesenv = $Solicitudesenv->where('numerodocumento', 'LIKE', "%{$this->search}%")->orwhere('referencia', 'LIKE', "%{$this->search}%");
            $count = $Solicitudesenv->where('numerodocumento', 'LIKE', "%{$this->search}%")->orwhere('referencia', 'LIKE', "%{$this->search}%")->count();
        }
        $Solicitudesenv = $Solicitudesenv->paginate($this->perPage);
        return view('livewire.gestiondocumental.solicitudenv.index', compact('count', 'Solicitudesenv'));
    }

    public function destroy($id)
    {
        try{
            $Solicitudesenv = Solicitudenv::findOrFail($id);
            if(Storage::exists($Solicitudesenv->archivo)){
                Storage::delete($Solicitudesenv->archivo);
            }
            $Solicitudesenv->delete();
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
