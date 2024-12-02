<?php

namespace App\Http\Livewire\Solicitudpro;

use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\Solicitudpro;
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
        
       
        $count = Asignacion::where('usuario_dirid','=',Auth::user()->id)->orWhere('usuario_tecid','=',Auth::user()->id);
        $count = $count->where('area_id','=',$this->area)->whereIn('estado_id',[1,2])->where('procesado','=',2)->count();
        $Solicitudespro = Asignacion::where('usuario_dirid','=',Auth::user()->id)->orWhere('usuario_tecid','=',Auth::user()->id);
        $Solicitudespro = $Solicitudespro->where('procesado','=',2)->where('area_id','=',$this->area)->orderBy('id','asc');       
        
        if($this->search){
            $Solicitudespro = $Solicitudespro->where('numerodocumento', 'LIKE', "%{$this->search}%");
        }
        $Solicitudespro = $Solicitudespro->paginate($this->perPage);
        return view('livewire.gestiondocumental.solicitudpro.index', compact('count', 'Solicitudespro'));
    }

    public function destroy($id)
    {
        try{
            $Solicitudespro = Solicitudpro::findOrFail($id);
            if(Storage::exists($Solicitudespro->archivo)){
                Storage::delete($Solicitudespro->archivo);
            }
            $Solicitudespro->delete();
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
