<?php
namespace App\Http\Livewire\Centrosreferencia\Resultadomspindividual;

use App\Models\CentrosReferencia\Resultado;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Crn;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use DB;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $userPresent;

    //Tools
    public $perPage = 25;
    public $searchc;
    public $searchna;
    public $csedes;
    public $claboratorios;
    public $ceventos;
    public $fechainicio;
    public $fechafin;
    public $controlf;

    protected $queryString = ['searchc' => ['except' => ''], 'searchna' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $resultados = DB::table('inspi_crns.busqueda_paciente')->select('codigo','identidad','nombres','apellidos','fecha_recepcion','unidad_salud','sede','crn','evento','fecha_atencion','ingresa_por','usuario_registro');
        $count = $resultados->count();

        if($this->searchc){
            $resultados = DB::table('inspi_crns.busqueda_paciente')->select('codigo','identidad','nombres','apellidos','fecha_recepcion','unidad_salud','sede','crn','evento','fecha_atencion','ingresa_por','usuario_registro')->where('identidad', 'LIKE', "%{$this->searchc}%");
            $count = $resultados->count();

        }

        if($this->searchna){
            $resultados = DB::table('inspi_crns.busqueda_paciente')->select('codigo','identidad','nombres','apellidos','fecha_recepcion','unidad_salud','sede','crn','evento','fecha_atencion','ingresa_por','usuario_registro')->where('apellidos', 'LIKE', "%{$this->searchna}%")->orWhere('nombres', 'LIKE', "%{$this->searchna}%");
            $count =  $resultados->count();

        }

        $resultados = $resultados->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.resultadomspindividual.index', compact('count', 'resultados'));
    }

    public function destroy($id)
    {
        try{
            $Resultados = Resultado::findOrFail($id);
            if(Storage::exists($Resultados->archivo)){
                Storage::delete($Resultados->archivo);
            }
            $Resultados->delete();
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
