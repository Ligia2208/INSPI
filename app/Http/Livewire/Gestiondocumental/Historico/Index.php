<?php

namespace App\Http\Livewire\Historico;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\Historico;
use App\Models\CoreBase\Area;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $userPresent;
    public $filiacion;
    public $area;
            
    //Tools
    public $perPage = 10;
    public $search;
    protected $queryString = ['search' => ['except' => '']];   

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->userPresent = User::find(Auth::user()->id);
        $this->filiacion = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $this->filiacion->area_id;
        $this->cargo = $this->filiacion->cargo_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {           
        $count = Asignacion::where('procesado','>',0)->count();
        $Historicos = Asignacion::where('procesado','>',0)->orderBy('id','asc');       
        
        if($this->search){
            $Historicos = $Historicos->where('numerodocumento', 'LIKE', "%{$this->search}%")->orwhere('referencia', 'LIKE', "%{$this->search}%");
        }
        $Historicos = $Historicos->paginate($this->perPage);
        return view('livewire.gestiondocumental.historico.index', compact('count', 'Historicos'));
    }

    public function destroy($id)
    {
        try{
            $Historicos = Historico::findOrFail($id);
            if(Storage::exists($Historicos->archivo)){
                Storage::delete($Historicos->archivo);
            }
            $Historicos->delete();
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
