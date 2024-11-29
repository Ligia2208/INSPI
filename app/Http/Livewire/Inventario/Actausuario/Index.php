<?php

namespace App\Http\Livewire\Inventario\Actausuario;

use App\Models\RecursosHumanos\Persona;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\Inventario\Articulo;
use App\Models\Inventario\Acta;
use App\Models\Inventario\Participante;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
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
        $count = Filiacion::count();
        $Filiaciones = Filiacion::orderBy('id', 'asc');

        if($this->search){
            $Filiaciones = $Filiaciones->where('mailinstitucional', 'LIKE', "%{$this->search}%");
        }

        $Filiaciones = $Filiaciones->paginate($this->perPage);

        return view('livewire.inventario.actausuario.index', compact('count', 'Filiaciones'));
    }

    public function destroy(Filiacion $Filiaciones)
    {
        $filiacion = Filiacion::findOrFail($Filiaciones->id);
        $count = Articulo::where('usuario_id','=',$filiacion->user_id)->count();


        if ($count>0){
            $acta = DB::table('inspi_inventario.actas')->select(DB::raw('max(numero) as nacta'))->where('estadoregistro', '=', 'A')->get();
            $participantes = Participante::where('estado','=','A')->first();
            $custodio = Articulo::where('usuario_id','=',$filiacion->user_id)->first();
            $actausuario = new Acta();
            $actausuario->fechaemision = date('Y-m-d');
            $actausuario->numero = $acta[0]->nacta+1;
            $actausuario->anio = date('Y');
            $actausuario->funcionario_id = $Filiaciones->user_id;
            $actausuario->participantes_id = $participantes->id;
            $actausuario->custodio_id = $custodio->custodio_id;
            $actausuario->estadoregistro = 'A';
            $actausuario->save();
            $filiacion->acta_funcionario=$acta[0]->nacta+1;
            $filiacion->update();
            $this->alert('success', 'Acta No.'.strval($acta[0]->nacta+1).' fue generada');
        }
        else{
            $this->alert('error', 'No exiten items cargados al funcionario');
        }
    }
}
