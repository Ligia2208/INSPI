<?php

namespace App\Http\Livewire\Centrosreferencia\Analiticacd4;

use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Responsable;
use App\Models\CentrosReferencia\Crn;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DB;
use Datetime;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $userPresent;

    //Tools
    public $perPage = 25;
    public $searchm;
    public $searchc;
    public $searchp;
    public $csedes;
    public $claboratorios;
    public $ceventos;
    public $fechainicio;
    public $fechafin;
    public $controlf;

    protected $queryString = ['searchm' => ['except' => ''], 'searchc' => ['except' => ''], 'searchp' => ['except' => ''], 'csedes' => ['except' => ''], 'claboratorios' => ['except' => ''], 'ceventos' => ['except' => ''], 'fechainicio' => ['except' => ''], 'fechafin' => ['except' => ''], 'controlf' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $iduser = auth()->user()->id;
        $sedes_users = Responsable::where('estado','=','A')->where('tipo_id','=',1)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('sedes_id')->pluck('sedes_id')->toArray();
        $crns_users = Responsable::where('estado','=','A')->where('tipo_id','=',1)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('crns_id')->pluck('crns_id')->toArray();
        $sedes = Sede::whereIn('id',$sedes_users)->orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];
        $sedes_up = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->count();

        $count = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('evento_id','=',141)->where('resultado_id','=',0)->count();
        $analiticas = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('evento_id','=',141)->where('resultado_id','=',0)->orderBy('codigo_calidad', 'asc');

        $analiticas = $analiticas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.analiticacd4.index', compact('count', 'analiticas'));
    }

    public function destroy($id)
    {
        try{
            $Analiticas = Analitica::findOrFail($id);
            $Analiticas->estado = 'I';
            $Analiticas->update();
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
