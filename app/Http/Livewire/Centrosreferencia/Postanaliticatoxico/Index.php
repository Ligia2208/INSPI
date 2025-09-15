<?php

namespace App\Http\Livewire\Centrosreferencia\Postanaliticatoxico;

use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Responsable;
use App\Models\CentrosReferencia\Crn;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Codedge\Fpdf\Fpdf\Fpdf;

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
        $sedes_users = Responsable::where('estado','=','A')->where('tipo_id','=',2)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('sedes_id')->pluck('sedes_id')->toArray();
        $crns_users = Responsable::where('estado','=','A')->where('tipo_id','=',2)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('crns_id')->pluck('crns_id')->toArray();
        $sedes = Sede::whereIn('id',$sedes_users)->orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];
        $sedes_up = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->count();
        $mresultados = Analitica::where('estado','=','A')->where('usuarior_id','>',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->pluck('preanalitica_id')->toArray();

        $contsedes = Sede::whereIn('id',$sedes_users)->count();
        if($contsedes==1)
        {
            $this->csedes=$sedes_users[0];
        }

        //$count = Analitica::where('estado','=','A')->where('usuarior_id','>',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->count();
        $analiticapac = Analitica::where('estado','=','A')->where('resultado_id','>',0)->where('tecnica_id','>',0)->where('usuarior_id','>',0)->where('usuariop_id','=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->distinct('preanalitica_id')->pluck('preanalitica_id')->toArray();
        $analiticas = Preanalitica::where('validado','=','N')->whereIn('id',$analiticapac);
        $count = $analiticas->count();

        if($this->searchm){
            $analiticapac = Analitica::where('estado','=','A')->where('codigo_muestra','LIKE',"%{$this->searchm}%")->distinct('preanalitica_id')->pluck('preanalitica_id')->toArray();
            $analiticas = $analiticas->whereIn('id', $analiticapac);
            $count = $analiticas->count();

        }
        if($this->searchc){
            $pacientes = Paciente::where(function ($query){
                $query->where('identidad', 'LIKE', "%{$this->searchc}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $preanaliticas = Preanalitica::whereIn('paciente_id',$pacientes)->pluck('id')->toArray();
            $analiticas = $analiticas->whereIn('id',$preanaliticas);
            $count = $analiticas->count();

        }
        if($this->searchp){
            $pacientes = Paciente::where(function ($query){
                $query->where('apellidos', 'LIKE', "%{$this->searchp}%")
                  ->orWhere('nombres', 'LIKE', "%{$this->searchp}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $preanaliticas = Preanalitica::whereIn('paciente_id',$pacientes)->pluck('id')->toArray();
            $analiticas = $analiticas->whereIn('id',$preanaliticas);
            $count = $analiticas->count();

        }
        if($this->csedes){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes);
            $count = $analiticas->count();
            $crns_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->distinct('crns_id')->pluck('crns_id')->toArray();
            $config = SedeCrn::where('sedes_id','=',$this->csedes)->whereIn('crns_id',$crns_users)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();

            $contcrns = Crn::whereIn('id',$config)->count();
            if($contcrns==1){
                $this->claboratorios = $crns_users[0];
            }
        }
        if($this->claboratorios){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $analiticas->count();
            $eventos = Evento::where('estado','=','A')->where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
        }

        if($this->ceventos){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $count = $analiticas->count();
        }

        if($this->fechainicio){
            if ($this->fechafin){
                if ($this->fechainicio <= $this->fechafin){
                    if($this->controlf==0){
                        $this->fechainicio='';
                        $this->fechafin='';
                    }
                    if($this->controlf==1){
                        $analiticas = $analiticas->where('fecha_toma_primera', '>=', $this->fechainicio)->where('fecha_toma_primera','<=',$this->fechafin);
                        $count = $analiticas->count();

                    }
                    if($this->controlf==2){
                        $analiticas = $analiticas->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $analiticas->count();
                    }
                    if($this->controlf==3){
                        $analiticas = $analiticas->where('created_at', '>=', $this->fechainicio)->where('created_at','<=',$this->fechafin);
                        $count = $analiticas->count();
                    }
                }
                else{
                    $this->alert('error', __('Fecha fin debe ser mayor o igual a Fecha inicio'));
                }
            }
            else{
                $this->alert('error', __('Fecha fin no puede ser nulo'));
            }
        }

        $analiticas = $analiticas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.postanaliticatoxico.index', compact('count', 'analiticas','sedes','crns','eventos'));
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

    public function sgte_codigomuestra($anio, $sede, $crn){
        $max = Analitica::where('estado','=','A')->where('anio_registro','=',$anio)->where('sedes_id','=',$sede)->where('crns_id','=',$crn)->max('codigo_muestra');
        return $max+1;
    }


}

