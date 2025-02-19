<?php

namespace App\Http\Livewire\Centrosreferencia\Analiticap;

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

        $count = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('resultado_id','>',0)->count();
        $analiticas = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('resultado_id','>',0)->orderBy('codigo_calidad', 'desc');

        if($this->searchm){
            $analiticas = $analiticas->where('codigo_muestra', 'LIKE', "%{$this->searchm}%");
            $count = $analiticas->count();

        }
        if($this->searchc){
            $pacientes = Paciente::where(function ($query){
                $query->where('identidad', 'LIKE', "%{$this->searchc}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $preanaliticas = Preanalitica::whereIn('paciente_id',$pacientes)->pluck('id')->toArray();
            $analiticas = $analiticas->whereIn('preanalitica_id',$preanaliticas);
            $count = $analiticas->count();

        }
        if($this->searchp){
            $pacientes = Paciente::where(function ($query){
                $query->where('apellidos', 'LIKE', "%{$this->searchp}%")
                  ->orWhere('nombres', 'LIKE', "%{$this->searchp}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $preanaliticas = Preanalitica::whereIn('paciente_id',$pacientes)->pluck('id')->toArray();
            $analiticas = $analiticas->whereIn('preanalitica_id',$preanaliticas);
            $count = $analiticas->count();

        }
        if($this->csedes){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes);
            $count = $analiticas->count();
            $crns_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->distinct('crns_id')->pluck('crns_id')->toArray();
            $config = SedeCrn::where('sedes_id','=',$this->csedes)->whereIn('crns_id',$crns_users)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        }
        if($this->claboratorios){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $analiticas->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
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
                        $analiticas = $analiticas->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin);
                        $count = $analiticas->count();

                    }
                    if($this->controlf==2){
                        $analiticas = $analiticas->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $analiticas->count();
                    }
                    if($this->controlf==3){
                        $analiticas = $analiticas->where('fecha_procesamiento', '>=', $this->fechainicio)->where('fecha_procesamiento','<=',$this->fechafin);
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

        return view('livewire.centrosreferencia.analiticap.index', compact('count', 'analiticas','sedes','crns','eventos'));
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
    public function duplicate($id)
    {
        DB::beginTransaction();
        try{
            $iduser = auth()->user()->id;

            $Analiticas = Analitica::findOrFail($id);
            $Preanaliticas = Preanalitica::findOrFail($Analiticas->preanalitica_id);
            $absede = Sede::findOrFail($Analiticas->sedes_id);
            $abcrn = Crn::findOrFail($Analiticas->crns_id);

            $newToma = new Preanalitica();
            $newToma->instituciones_id = $Preanaliticas->instituciones_id;
            $newToma->paciente_id = $Preanaliticas->paciente_id;

            $newToma->fecha_atencion = $Preanaliticas->fecha_atencion;
            $newToma->quien_notifica = $Preanaliticas->quien_notifica;
            $newToma->probable_infeccion = $Preanaliticas->probable_infeccion;
            $newToma->fecha_sintomas = $Preanaliticas->fecha_sintomas;
            $newToma->embarazo = $Preanaliticas->embarazo;

            $newToma->gestacion = $Preanaliticas->gestacion;
            $newToma->laboratorio = $Preanaliticas->laboratorio;

            $newToma->nombre_laboratorio = $Preanaliticas->nombre_laboratorio;
            $newToma->sedes_id = $Preanaliticas->sedes_id;
            $newToma->crns_id = $Preanaliticas->crns_id;
            $newToma->evento_id = $Preanaliticas->evento_id;

            $newToma->clase_primera_id = $Preanaliticas->clase_primera_id;
            $newToma->primera_id = $Preanaliticas->primera_id;
            $newToma->fecha_toma_primera = $Preanaliticas->fecha_toma_primera;
            $newToma->anio_registro = $Preanaliticas->anio_registro;
            $newToma->usuariot_id =  $iduser;
            $newToma->archivo = $Preanaliticas->archivo;
            $newToma->save();

            $newAnalitica = new Analitica();
            $newAnalitica->preanalitica_id = $newToma->id;
            $newAnalitica->sedes_id = $Analiticas->sedes_id;
            $newAnalitica->crns_id = $Analiticas->crns_id;
            $newAnalitica->evento_id = $Analiticas->evento_id;
            $newAnalitica->muestra_id = $Analiticas->muestra_id;
            $newAnalitica->anio_registro = $Analiticas->anio_registro;
            $newAnalitica->codigo_muestra = $Analiticas->codigo_muestra;
            $newAnalitica->codigo_secuencial = 11;
            $newAnalitica->codigo_externo = str_pad($Analiticas->codigo_muestra, 5, "0", STR_PAD_LEFT).'-'.str_pad($Analiticas->codigo_secuencial, 2, "0", STR_PAD_LEFT).'-11';
            $fechacomoentero = strtotime($Analiticas->fecha_toma);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newAnalitica->codigo_calidad = str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-11';
            $newAnalitica->tecnica_id = $Analiticas->tecnica_id;
            $newAnalitica->resultado_id = $Analiticas->resultado_id;
            $newAnalitica->descripcion = $Analiticas->descripcion;
            $newAnalitica->descripcion_responsable = $Analiticas->descripcion_responsable;
            $newAnalitica->usuariot_id = $iduser;
            $newAnalitica->fecha_toma = $Analiticas->fecha_toma;
            $newAnalitica->fecha_llegada_lab = $Analiticas->fecha_llegada_lab;
            $newAnalitica->usuarior_id = $Analiticas->usuarior_id;
            $newAnalitica->fecha_resultado = $Analiticas->fecha_resultado;
            $newAnalitica->usuariop_id = $Analiticas->usuariop_id;
            $newAnalitica->fecha_publicacion = $Analiticas->fecha_publicacion;
            $newAnalitica->adicional = 2;
            $newAnalitica->save();

            DB::commit();
            $this->alert('success', 'Registro duplicado con exito');
            $this->emit('renderJs');

        }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al duplicar la Pre - Analitica'.$e->getMessage());
            return $e->getMessage();
        }
    }
}
