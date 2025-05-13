<?php

namespace App\Http\Livewire\Centrosreferencia\Analitica;

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
        //dd($sedes_users);
        $crns_users = Responsable::where('estado','=','A')->where('tipo_id','=',1)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('crns_id')->pluck('crns_id')->toArray();
        $sedes = Sede::whereIn('id',$sedes_users)->orderBy('id', 'asc')->cursor();
        //dd($sedes);
        $crns = [];
        $eventos = [];
        $sedes_up = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->count();

        $contsedes = Sede::whereIn('id',$sedes_users)->count();
        if($contsedes==1)
        {
            $this->csedes=$sedes_users[0];
        }
        $count = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('resultado_id','=',0)->count();
        $analiticas = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('resultado_id','=',0)->orderBy('codigo_calidad', 'desc');

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
            //dd($iduser);
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
                        $pre = Preanalitica::where('fecha_recepcion','>=',$this->fechainicio)->where('fecha_recepcion','<=',$this->fechafin)->pluck('id')->toArray();
                        $analiticas = $analiticas->whereIn('preanalitica_id',$pre);
                        $count = $analiticas->count();

                    }
                    if($this->controlf==2){
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

        return view('livewire.centrosreferencia.analitica.index', compact('count', 'analiticas','sedes','crns','eventos'));
    }

    public function destroy($id)
    {
        try{
            $Analiticas = Analitica::findOrFail($id);
            $Analiticas->estado = 'I';
            $Analiticas->update();

            $control = $Analiticas->codigo_secuencial;
            if($control>10 && $control<=20){
                $control = $control-10;
                //dd($control); die();
                $secuencial = 1;
                $AnaliticaId = Analitica::where('sedes_id','=',$Analiticas->sedes_id)->where('crns_id','=',$Analiticas->crns_id)->where('evento_id','=',$Analiticas->evento_id)->where('codigo_muestra','=',$Analiticas->codigo_muestra)->where('codigo_secuencial','=',$secuencial)->where('estado','=','A')->pluck('id');
                //dd($AnaliticaId); die();
                if($control==1){
                    $AnaliticaOriginal = Analitica::findOrFail($AnaliticaId[0]);
                    $AnaliticaOriginal->tecnica_segunda_id=0;
                    $AnaliticaOriginal->resultado_segunda_id=0;
                    $AnaliticaOriginal->identificado_segunda=null;
                    $AnaliticaOriginal->update();
                }
                if($control==2){
                    $AnaliticaOriginal = Analitica::findOrFail($AnaliticaId[0]);
                    $AnaliticaOriginal->tecnica_tercera_id=0;
                    $AnaliticaOriginal->resultado_tercera_id=0;
                    $AnaliticaOriginal->identificado_tercera=null;
                    $AnaliticaOriginal->update();
                }
                if($control==3){
                    $AnaliticaOriginal = Analitica::findOrFail($AnaliticaId[0]);
                    $AnaliticaOriginal->tecnica_cuarta_id=0;
                    $AnaliticaOriginal->resultado_cuarta_id=0;
                    $AnaliticaOriginal->identificado_cuarta=null;
                    $AnaliticaOriginal->update();
                }
                if($control==4){
                    $AnaliticaOriginal = Analitica::findOrFail($AnaliticaId[0]);
                    $AnaliticaOriginal->tecnica_quinta_id=0;
                    $AnaliticaOriginal->resultado_quinta_id=0;
                    $AnaliticaOriginal->identificado_quinta=null;
                    $AnaliticaOriginal->update();
                }
                if($control==5){
                    $AnaliticaOriginal = Analitica::findOrFail($AnaliticaId[0]);
                    $AnaliticaOriginal->tecnica_sexta_id=0;
                    $AnaliticaOriginal->resultado_sexta_id=0;
                    $AnaliticaOriginal->identificado_sexta=null;
                    $AnaliticaOriginal->update();
                }

            }
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

            $newToma->fecha_recepcion = $Preanaliticas->fecha_recepcion;
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

    public function descargarExcel(){
        try{

         $excel = new Spreadsheet();

         $hoja = $excel->getActiveSheet();
         $hoja->setCellValue('A1','Institución Salud');
         $hoja->setCellValue('B1','Periodo');
         $hoja->setCellValue('C1','Id. Paciente');
         $hoja->setCellValue('D1','Identidad');
         $hoja->setCellValue('E1','Nombres');
         $hoja->setCellValue('F1','Apellidos');
         $hoja->setCellValue('G1','Nombres Completos');
         $hoja->setCellValue('H1','Dirección');
         $hoja->setCellValue('I1','F.Nacimiento');
         $hoja->setCellValue('J1','Anios');
         $hoja->setCellValue('K1','Meses');
         $hoja->setCellValue('L1','Dias');
         $hoja->setCellValue('M1','Edad1');
         $hoja->setCellValue('N1','Sexo');
         $hoja->setCellValue('O1','Sexo1');
         $hoja->setCellValue('P1','Cantón');
         $hoja->setCellValue('Q1','Provincia');
         $hoja->setCellValue('R1','Sede');
         $hoja->setCellValue('S1','CRN');
         $hoja->setCellValue('T1','Evento');
         $hoja->setCellValue('U1','Clase');
         $hoja->setCellValue('V1','Tipo');
         $hoja->setCellValue('W1','No. Muestra');
         $hoja->setCellValue('X1','Código Muestra');
         $hoja->setCellValue('Y1','Observación');
         $hoja->setCellValue('Z1','Secuencia');
         $hoja->setCellValue('AA1','Fecha inicio sintomas');
         $hoja->setCellValue('AB1','Fecha toma muestra');
         $hoja->setCellValue('AC1','Dias evolución');
         $hoja->setCellValue('AD1','Estado');
         $hoja->setCellValue('AE1','Ingresa por');
         $hoja->setCellValue('AF1','F. Recepción');
         $hoja->setCellValue('AG1','F. Registro');
         $hoja->setCellValue('AH1','Usuario Registro');
         $hoja->setCellValue('AI1','Técnica aplicada');
         $hoja->setCellValue('AJ1','Resultado');
         $hoja->setCellValue('AK1','Validado');
         $hoja->setCellValue('AL1','Fecha validación');
         $hoja->setCellValue('AM1','Agente Identificado');

         $fila = 2;
         $i = 0;
         if ($this->csedes>0){
             $sid = $this->csedes;
         }
         else{
             $sid = 0;
         }

         if ($this->claboratorios>0){
             $cid = $this->claboratorios;
         }
         else{
             $cid = 0;
         }

         if ($this->ceventos>0){
             $eid = $this->ceventos;
         }
         else{
             $eid = 0;
         }

         if ($this->controlf>0){
             $tf = $this->controlf;
         }
         else{
             $tf = 0;
         }

         if ($this->fechainicio != null){
             $f1 = $this->fechainicio;
         }
         else{
             $f1 = null;
         }

         if ($this->fechafin != null){
             $f2 = $this->fechafin;
         }
         else{
             $f2 = null;
         }

         if($sid==0){
             if($tf==1){
                 $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro','fecha_recepcion','usuario_recepcion','agente_identificado')->whereDate('fecha_recepcion','>=',$f1)->whereDate('fecha_recepcion','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
             }
             else{
                 if($tf==2){
                     $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro','fecha_recepcion','usuario_recepcion','agente_identificado')->whereDate('fecha_sintomas','>=',$f1)->whereDate('fecha_sintomas','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                 }
                 else{
                     if($tf==3){
                         $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro','fecha_recepcion','usuario_recepcion','agente_identificado')->whereDate('fecha_registro','>=',$f1)->whereDate('fecha_registro','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                     }
                     else{
                         $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro','fecha_recepcion','usuario_recepcion','agente_identificado')->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                     }
                 }
             }
         }
         else{
             if($cid==0){
                 if($tf==1){
                     $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->whereDate('fecha_recepcion','>=',$f1)->whereDate('fecha_recepcion','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                 }
                 else{
                     if($tf==2){
                         $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->whereDate('fecha_sintomas','>=',$f1)->whereDate('fecha_sintomas','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                     }
                     else{
                         if($tf==3){
                             $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->whereDate('fecha_registro','>=',$f1)->whereDate('fecha_registro','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                         }
                         else{
                             $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                         }
                     }
                 }
             }
             else{
                 if($eid==0){
                     if($tf==1){
                         $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->whereDate('fecha_recepcion','>=',$f1)->whereDate('fecha_recepcion','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                     }
                     else{
                         if($tf==2){
                             $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->whereDate('fecha_sintomas','>=',$f1)->whereDate('fecha_sintomas','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                         }
                         else{
                             if($tf==3){
                                 $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->whereDate('fecha_registro','>=',$f1)->whereDate('fecha_registro','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                             }
                             else{
                                 $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                             }
                         }
                     }
                 }
                 else{
                     $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','periodo','paciente','identidad','nombres','apellidos','nombres_completos','direccion','fechanacimiento','anios','meses','dias','edad1','sexo','sexo1','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_muestra','observacion','codigo_secuencial','inicio_sintomas','toma_muestra','evolucion','estado_muestra','ingresa_por','fecha_registro','fecha_recepcion','usuario_recepcion','tecnica','resultado','validado','fecha_validacion','agente_identificado')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->where('evento_id','=',$eid)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                 }
             }
         }

         $total = $data->count();

         while($i < $total){
             $hoja->setCellValue('A'.$fila,$data[$i]->institucion);
             $hoja->setCellValue('B'.$fila,$data[$i]->periodo);
             $hoja->setCellValue('C'.$fila,$data[$i]->paciente);
             $hoja->setCellValue('D'.$fila,$data[$i]->identidad);
             $hoja->setCellValue('E'.$fila,$data[$i]->nombres);
             $hoja->setCellValue('F'.$fila,$data[$i]->apellidos);
             $hoja->setCellValue('G'.$fila,$data[$i]->nombres_completos);
             $hoja->setCellValue('H'.$fila,$data[$i]->direccion);
             $hoja->setCellValue('I'.$fila,$data[$i]->fechanacimiento);
             $hoja->setCellValue('J'.$fila,$data[$i]->anios);
             $hoja->setCellValue('K'.$fila,$data[$i]->meses);
             $hoja->setCellValue('L'.$fila,$data[$i]->dias);
             $hoja->setCellValue('M'.$fila,$data[$i]->edad1);
             $hoja->setCellValue('N'.$fila,$data[$i]->sexo);
             $hoja->setCellValue('O'.$fila,$data[$i]->sexo1);
             $hoja->setCellValue('P'.$fila,$data[$i]->canton);
             $hoja->setCellValue('Q'.$fila,$data[$i]->provincia);
             $hoja->setCellValue('R'.$fila,$data[$i]->sede);
             $hoja->setCellValue('S'.$fila,$data[$i]->crn);
             $hoja->setCellValue('T'.$fila,$data[$i]->evento);
             $hoja->setCellValue('U'.$fila,$data[$i]->clase_muestra);
             $hoja->setCellValue('V'.$fila,$data[$i]->tipo_muestra);
             $hoja->setCellValue('W'.$fila,$data[$i]->muestra);
             $hoja->setCellValue('X'.$fila,$data[$i]->codigo_muestra);
             $hoja->setCellValue('Y'.$fila,$data[$i]->observacion);
             $hoja->setCellValue('Z'.$fila,$data[$i]->codigo_secuencial);
             $hoja->setCellValue('AA'.$fila,$data[$i]->inicio_sintomas);
             $hoja->setCellValue('AB'.$fila,$data[$i]->toma_muestra);
             $hoja->setCellValue('AC'.$fila,$data[$i]->evolucion);
             $hoja->setCellValue('AD'.$fila,$data[$i]->estado_muestra);
             $hoja->setCellValue('AE'.$fila,$data[$i]->ingresa_por);
             $hoja->setCellValue('AF'.$fila,$data[$i]->fecha_recepcion);
             $hoja->setCellValue('AG'.$fila,$data[$i]->fecha_registro);
             $hoja->setCellValue('AH'.$fila,$data[$i]->usuario_recepcion);
             $hoja->setCellValue('AI'.$fila,$data[$i]->tecnica);
             $hoja->setCellValue('AJ'.$fila,$data[$i]->resultado);
             $hoja->setCellValue('AK'.$fila,$data[$i]->validado);
             $hoja->setCellValue('AL'.$fila,$data[$i]->fecha_validacion);
             $hoja->setCellValue('AM'.$fila,$data[$i]->agente_identificado);

             $fila = $fila + 1;
             $i = $i + 1;
         }

         $this->alert('success', 'Archivo generado con exito');

         ob_end_clean();
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="descarga_muestras.xlsx"');
         header('Cache-Control: max-age=0');

         $writer = IOFactory::createWriter($excel,'Xlsx');
         $writer->save(storage_path('app/public/descargas/'.$sid.'/'.$cid.'/')."descarga_muestras.xlsx");

        }
        catch(IOException $e){
         }
         $this->emit('renderJs');
         return redirect()->back();
    }
}
