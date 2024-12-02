<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\GestionDocumental\Solicitud;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $userPresent;
        
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
        $count = Solicitud::where('procesado','=',0)->count();
        $Solicitudes = Solicitud::where('procesado','=',0)->orderBy('id', 'asc');       
        if($this->search){
            $Solicitudes = $Solicitudes->where('numerodocumento', 'LIKE', "%{$this->search}%");
        }
        $Solicitudes = $Solicitudes->paginate($this->perPage);
        return view('livewire.gestiondocumental.solicitud.index', compact('count', 'Solicitudes'));
    }

    public function destroy($id)
    {
        try{
            $Solicitudes = Solicitud::findOrFail($id);
            if(Storage::exists($Solicitudes->archivo)){
                Storage::delete($Solicitudes->archivo);
            }
            $Solicitudes->delete();
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
