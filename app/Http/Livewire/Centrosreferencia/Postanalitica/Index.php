<?php

namespace App\Http\Livewire\Centrosreferencia\Postanalitica;

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


        //$count = Analitica::where('estado','=','A')->where('usuarior_id','>',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->count();
        $analiticapac = Analitica::where('estado','=','A')->where('usuarior_id','>',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->distinct('preanalitica_id')->pluck('preanalitica_id')->toArray();
        $analiticas = Preanalitica::whereIn('id',$analiticapac);
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
                        $analiticas = $analiticas->where('fecha_toma_muestra', '>=', $this->fechainicio)->where('fecha_toma_muestra','<=',$this->fechafin);
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

        return view('livewire.centrosreferencia.postanalitica.index', compact('count', 'analiticas','sedes','crns','eventos'));
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

    public function diferencial01($id)
    {   //ELISA RUBEOLA-SARAMPION (POSITIVO O INDETERMINADO)
        try{
                $objPreanalitica = Preanalitica::findOrFail($id);
                $absede = Sede::findOrFail($objPreanalitica->sedes_id);
                $abcrn = Crn::findOrFail(12);
                $newPreanalitica = new Preanalitica();
                $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
	            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                $newPreanalitica->crns_id = 12;
                $newPreanalitica->evento_id = 149;
                $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
	            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newPreanalitica->save();

                $Analiticas = Analitica::where('preanalitica_id','=',$id)->first();
                $newAnalitica = new Analitica();
                $newAnalitica->preanalitica_id = $newPreanalitica->id;
                $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                $newAnalitica->crns_id = 12;
                $newAnalitica->evento_id = 149;
                $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                $cmuestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                $newAnalitica->codigo_muestra = $cmuestra;
                $newAnalitica->codigo_secuencial = 1;
                $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newAnalitica->codigo_calidad = str_pad($cmuestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad(1, 2, '0', STR_PAD_LEFT);
                $newAnalitica->codigo_externo = 'EXANT-DIF-'.str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT);
                $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                $newAnalitica->save();

                $newPreanalitica->cdiferencial=$Analiticas->codigo_muestra;
                $newPreanalitica->update();

                $objPreanalitica->cdiferencial=$newPreanalitica->id;
                $objPreanalitica->update();

                $newPreanalitica = new Preanalitica();
                $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
	            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                $newPreanalitica->crns_id = 12;
                $newPreanalitica->evento_id = 150;
                $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
	            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newPreanalitica->save();

                $newAnalitica = new Analitica();
                $newAnalitica->preanalitica_id = $newPreanalitica->id;
                $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                $newAnalitica->crns_id = 12;
                $newAnalitica->evento_id = 150;
                $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                $cmuestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                $newAnalitica->codigo_muestra = $cmuestra;
                $newAnalitica->codigo_secuencial = 1;
                $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newAnalitica->codigo_calidad = str_pad($cmuestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad(1, 2, '0', STR_PAD_LEFT);
                $newAnalitica->codigo_externo = 'EXANT-DIF-'.str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT);
                $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                $newAnalitica->save();

                $newPreanalitica->cdiferencial=$Analiticas->codigo_muestra;
                $newPreanalitica->update();

                $newPreanalitica = new Preanalitica();
                $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
	            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                $newPreanalitica->crns_id = 12;
                $newPreanalitica->evento_id = 151;
                $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
	            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newPreanalitica->save();

                $Analiticas = Analitica::where('preanalitica_id','=',$id)->first();
                $newAnalitica = new Analitica();
                $newAnalitica->preanalitica_id = $newPreanalitica->id;
                $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                $newAnalitica->crns_id = 12;
                $newAnalitica->evento_id = 151;
                $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                $newAnalitica->codigo_muestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                $newAnalitica->codigo_secuencial = 1;
                $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newAnalitica->codigo_calidad = str_pad($newAnalitica->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($$newAnalitica->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newAnalitica->codigo_externo = 'EXANT-DIF-'.str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT);
                $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                $newAnalitica->save();

                $newPreanalitica->cdiferencial=$Analiticas->codigo_muestra;
                $newPreanalitica->update();

            $this->alert('success', 'Solicitud de pruebas diferenciales generada con exito');
        }catch(Exception $e){
            $this->alert('error',
                'Ocurrio un error en la generación: '.$e->getMessage(),
                [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entiendo',
                    'timer' => null,
                ]);
        }
    }

    public function diferencial02($id)
    {   //ELISA VIRUELA DEL MONO (NEGATIVO)
        try{
                $objPreanalitica = Preanalitica::findOrFail($id);
                $absede = Sede::findOrFail($objPreanalitica->sedes_id);
                $abcrn = Crn::findOrFail(12);
                $newPreanalitica = new Preanalitica();
                $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
	            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                $newPreanalitica->crns_id = 12;
                $newPreanalitica->evento_id = 146;
                $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
	            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newPreanalitica->save();

                $Analiticas = Analitica::where('preanalitica_id','=',$id)->first();
                $newAnalitica = new Analitica();
                $newAnalitica->preanalitica_id = $newPreanalitica->id;
                $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                $newAnalitica->crns_id = 12;
                $newAnalitica->evento_id = 146;
                $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                $cmuestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                $newAnalitica->codigo_muestra = $cmuestra;
                $newAnalitica->codigo_secuencial = 1;
                $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newAnalitica->codigo_calidad = str_pad($cmuestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad(1, 2, '0', STR_PAD_LEFT);
                $newAnalitica->codigo_externo = 'EXANT-DIF-'.str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT);
                $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                $newAnalitica->save();

                $newPreanalitica->cdiferencial=$Analiticas->codigo_muestra;
                $newPreanalitica->update();

                $objPreanalitica->cdiferencial=$newPreanalitica->id;
                $objPreanalitica->update();

                $newPreanalitica = new Preanalitica();
                $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
	            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                $newPreanalitica->crns_id = 12;
                $newPreanalitica->evento_id = 147;
                $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
	            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newPreanalitica->save();

                $newAnalitica = new Analitica();
                $newAnalitica->preanalitica_id = $newPreanalitica->id;
                $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                $newAnalitica->crns_id = 12;
                $newAnalitica->evento_id = 147;
                $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                $cmuestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                $newAnalitica->codigo_muestra = $cmuestra;
                $newAnalitica->codigo_secuencial = 1;
                $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newAnalitica->codigo_calidad = str_pad($cmuestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad(1, 2, '0', STR_PAD_LEFT);
                $newAnalitica->codigo_externo = 'EXANT-DIF-'.str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT);
                $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                $newAnalitica->save();

                $newPreanalitica->cdiferencial=$Analiticas->codigo_muestra;
                $newPreanalitica->update();

                $newPreanalitica = new Preanalitica();
                $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
	            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                $newPreanalitica->crns_id = 12;
                $newPreanalitica->evento_id = 148;
                $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
	            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newPreanalitica->save();

                $Analiticas = Analitica::where('preanalitica_id','=',$id)->first();
                $newAnalitica = new Analitica();
                $newAnalitica->preanalitica_id = $newPreanalitica->id;
                $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                $newAnalitica->crns_id = 12;
                $newAnalitica->evento_id = 148;
                $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                $cmuestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                $newAnalitica->codigo_muestra = $cmuestra;
                $newAnalitica->codigo_secuencial = 1;
                $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newAnalitica->codigo_calidad = str_pad($cmuestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad(1, 2, '0', STR_PAD_LEFT);
                $newAnalitica->codigo_externo = 'EXANT-DIF-'.str_pad($Analiticas->codigo_muestra, 5, '0', STR_PAD_LEFT);
                $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                $newAnalitica->save();

                $newPreanalitica->cdiferencial=$Analiticas->codigo_muestra;
                $newPreanalitica->update();

            $this->alert('success', 'Solicitud de pruebas diferenciales generada con exito');
        }catch(Exception $e){
            $this->alert('error',
                'Ocurrio un error en la generación: '.$e->getMessage(),
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

