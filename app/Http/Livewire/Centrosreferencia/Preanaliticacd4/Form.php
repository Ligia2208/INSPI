<?php

namespace App\Http\Livewire\Centrosreferencia\Preanaliticacd4;

use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Pacientetemp;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Sexo;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use App\Models\CentrosReferencia\Reporte;
use App\Models\CentrosReferencia\Tecnica;
use App\Models\CentrosReferencia\Muestra;
use App\Models\CentrosReferencia\Clase;
use App\Models\CentrosReferencia\Estadomuestra;
use App\Models\CentrosReferencia\Generacioncodigos;
use App\Models\CentrosReferencia\Responsable;
use App\Models\CoreBase\Nacionalidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Datetime;
use DB;

class Form extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $method;

    //Tools
    public $Preanaliticas;
    public $tecnicas;
    public $cantones;
    public $reportes;
    public $selectedProvincia = null;
    public $changedInstitucion = null;
    public $PreanaliticaTmp;


    protected $listeners = ['render'];

    protected function rules(){
        return [
            'Preanaliticas.instituciones_id' => 'required|numeric',
            'Preanaliticas.institucion_nombre' => 'sometimes|max:525',
            'Preanaliticas.institucion_clasificacion' => 'sometimes|max:75',
            'Preanaliticas.institucion_nivel' => 'sometimes|max:75',
            'Preanaliticas.institucion_tipologia' => 'sometimes|max:75',
            'Preanaliticas.institucion_ubicacion' => 'sometimes|max:150',

            'Preanaliticas.fecha_recepcion' => 'required|max:10',
            'Preanaliticas.quien_notifica' => 'required|max:80',
            'Preanaliticas.primera_id' => 'required|numeric',
            'Preanaliticas.estado_primera_id' => 'required|numeric',

            'Preanaliticas.sedes_id' => 'required|numeric',
            'Preanaliticas.crns_id' => 'required|numeric',
            'Preanaliticas.evento_id' => 'required|numeric',

        ];
    }

    public function mount(Preanalitica $Preanalitica, $method){
        $this->Preanaliticas = $Preanalitica;
        $this->method = $method;

        $this->Preanaliticas->primera_id = 159;
        $this->Preanaliticas->estado_primera_id = 1;
        $this->Preanaliticas->sedes_id = 1;
        $this->Preanaliticas->crns_id = 12;
        $this->Preanaliticas->evento_id = 141;

        if($method=="update"){
            $this->Preanaliticas->identidad=$this->Preanaliticas->paciente->identidad;
            $this->updatedchangedInstitucion($this->Preanaliticas->instituciones_id);
        }
        else{
            $this->Preanaliticas->fecha_recepcion = date('Y-m-d');
        }

    }

    public function updatedchangedInstitucion($institucion_id){
        $instSelected = Institucion::findOrFail($institucion_id);
        $this->Preanaliticas->institucion_nombre = $instSelected->descripcion;
        $this->Preanaliticas->institucion_clasificacion = $instSelected->clasificacion->descripcion;
        $this->Preanaliticas->institucion_nivel = $instSelected->nivel->descripcion;
        $this->Preanaliticas->institucion_tipologia = $instSelected->tipologia->descripcion;
        $this->Preanaliticas->institucion_ubicacion = $instSelected->provincia->descripcion.' - '.$instSelected->canton->descripcion;
        $this->emit('renderJs');
    }

    public function updatedselectedProvincia($provincia_id){
        $this->cantones = Canton::where('provincia_id','=',$provincia_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function render(){

        $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $crns = Crn::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $eventos = Evento::where('estado','=','A')->where('crns_id','=',12)->orderBy('id','asc')->cursor();
        $cantonprov = Canton::where('estado','=','A')->orderBy('id','asc')->cursor();
        $muestras = Muestra::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $estados = Estadomuestra::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $instituciones = Institucion::where('estado','=','A')->orderBy('id','asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.centrosreferencia.preanaliticacd4.form', compact('sedes','crns','eventos','muestras','instituciones','estados','cantonprov'));
    }

     public function guardarp(Preanalitica $pa, $ev){

        $absede = Sede::findOrFail($pa->sedes_id);
        $abcrn = Crn::findOrFail($pa->crns_id);
        $user = auth()->user()->id;
        $fecha_anio = date("Y");
        if($pa->paciente_id == 0){
            $newPac = new Paciente();
            $newPac->nombres = $pa->paciente_nombres;
            $newPac->apellidos = $pa->paciente_apellidos;
            $newPac->identidad = $pa->identidad;
            $newPac->hcu = $pa->identidad;
            $newPac->fechanacimiento = $pa->paciente_fechanac;
            $newPac->sexo_id = $pa->paciente_sexo;
            $newPac->direccion = $pa->paciente_direccion;
            $newPac->telefono = $pa->paciente_telefono;
            $newPac->canton_id = $pa->paciente_ubicacion;
            $prov = Canton::findOrFail($pa->paciente_ubicacion);
            $newPac->provincia_id = $prov->provincia_id;
            $newPac->nacionalidad_id = $pa->paciente_nacionalidad;
            $newPac->save();
        }
        else{
            $newPac = Paciente::findOrFail($pa->paciente_id);
            $newPac->nombres = $pa->paciente_nombres;
            $newPac->apellidos = $pa->paciente_apellidos;
            $newPac->identidad = $pa->identidad;
            $newPac->hcu = $pa->identidad;
            $newPac->fechanacimiento = $pa->paciente_fechanac;
            $newPac->sexo_id = $pa->paciente_sexo;
            $newPac->direccion = $pa->paciente_direccion;
            $newPac->telefono = $pa->paciente_telefono;
            $newPac->canton_id = $pa->paciente_ubicacion;
            $prov = Canton::findOrFail($pa->paciente_ubicacion);
            $newPac->provincia_id = $prov->provincia_id;
            $newPac->nacionalidad_id = $pa->paciente_nacionalidad;
            $newPac->update();
        }
        $newToma = new Preanalitica();
        $newToma->instituciones_id = $this->Preanaliticas->instituciones_id;
        $newToma->paciente_id = $newPac->id;

        $newToma->fecha_atencion = $pa->fecha_atencion;
        $newToma->quien_notifica = $pa->quien_notifica;
        $newToma->probable_infeccion = $pa->probable_infeccion;
        $newToma->fecha_sintomas = $pa->fecha_sintomas;
        $newToma->fecha_recepcion = $pa->fecha_recepcion;
        $newToma->embarazo = $pa->embarazo;

        $newToma->gestacion = $pa->gestacion;
        $newToma->laboratorio = $pa->laboratorio;

        $newToma->nombre_laboratorio = $pa->nombre_laboratorio;
        $newToma->sedes_id = $pa->sedes_id;
        $newToma->crns_id = $pa->crns_id;

        $newToma->evento_id = $ev;
        if($pa->primera_id>0){
            $newToma->clase_primera_id = $pa->clase_primera_id;
            $newToma->primera_id = $pa->primera_id;
            $newToma->fecha_toma_primera = $pa->fecha_toma_primera;
            $newToma->hora_toma_primera = $pa->hora_toma_primera;
        }
        else{
            $newToma->primera_id = 0;
        }
        if($pa->segunda_id>0){
            $newToma->clase_segunda_id = $pa->clase_segunda_id;
            $newToma->segunda_id = $pa->segunda_id;
            $newToma->fecha_toma_segunda = $pa->fecha_toma_segunda;
            $newToma->hora_toma_segunda = $pa->hora_toma_segunda;
        }
        else{
            $newToma->segunda_id = 0;
        }
        if($pa->tercera_id>0){
            $newToma->clase_tercera_id = $pa->clase_tercera_id;
            $newToma->tercera_id = $pa->tercera_id;
            $newToma->fecha_toma_tercera = $pa->fecha_toma_tercera;
            $newToma->hora_toma_tercera = $pa->hora_toma_tercera;
        }
        else{
            $newToma->tercera_id = 0;
        }
        if($pa->cuarta_id>0){
            $newToma->clase_cuarta_id = $pa->clase_cuarta_id;
            $newToma->cuarta_id = $pa->cuarta_id;
            $newToma->fecha_toma_cuarta = $pa->fecha_toma_cuarta;
            $newToma->hora_toma_cuarta = $pa->hora_toma_cuarta;
        }
        else{
            $newToma->cuarta_id = 0;
        }
        if($pa->quinta_id>0){
            $newToma->clase_quinta_id = $pa->clase_quinta_id;
            $newToma->quinta_id = $pa->quinta_id;
            $newToma->fecha_toma_quinta = $pa->fecha_toma_quinta;
            $newToma->hora_toma_quinta = $pa->hora_toma_quinta;
        }
        else{
            $newToma->quinta_id = 0;
        }
        $newToma->anio_registro = $fecha_anio;
        $newToma->usuariot_id =  $user;
        $this->savePreanalitica();
        $newToma->archivo = $pa->archivo;
        $newToma->save();

        $tipogenera = $this->tipo_generacion($pa->sedes_id,$pa->crns_id);
        if($tipogenera==1){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
        }
        if($pa->primera_id>0){
            if($tipogenera==2){
                $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
            }
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $pa->sedes_id;
            $newMuestra->crns_id = $pa->crns_id;
            $newMuestra->evento_id = $ev;
            $newMuestra->muestra_id = $pa->primera_id;
            $newMuestra->clase_id = $pa->clase_primera_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $pa->fecha_toma_primera;
            $newMuestra->estado_muestra_id = $pa->estado_primera_id;
            $newMuestra->observacion_muestra = $pa->observacion_primera;
            $newMuestra->codigo_muestra = $codigo;
            if($tipogenera==1){
                $newMuestra->codigo_secuencial = 1;
            }
            else{
                $newMuestra->codigo_secuencial = $codigo;
            }
            $fechacomoentero = strtotime($pa->fecha_toma_primera);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }

        if($pa->segunda_id>0){
            if($tipogenera==2){
                $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
            }
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $pa->sedes_id;
            $newMuestra->crns_id = $pa->crns_id;
            $newMuestra->evento_id = $ev;
            $newMuestra->muestra_id = $pa->segunda_id;
            $newMuestra->clase_id = $pa->clase_segunda_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $pa->fecha_toma_segunda;
            $newMuestra->estado_muestra_id = $pa->estado_segunda_id;
            $newMuestra->observacion_muestra = $pa->observacion_segunda;
            $newMuestra->codigo_muestra = $codigo;
            if($tipogenera==1){
                $newMuestra->codigo_secuencial = 2;
            }
            else{
                $newMuestra->codigo_secuencial = $codigo;
            }
            $fechacomoentero = strtotime($pa->fecha_toma_segunda);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->tercera_id>0){
            if($tipogenera==2){
                $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
            }
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $pa->sedes_id;
            $newMuestra->crns_id = $pa->crns_id;
            $newMuestra->evento_id = $ev;
            $newMuestra->muestra_id = $pa->tercera_id;
            $newMuestra->clase_id = $pa->clase_tercera_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $pa->fecha_toma_tercera;
            $newMuestra->estado_muestra_id = $pa->estado_tercera_id;
            $newMuestra->observacion_muestra = $pa->observacion_tercera;
            $newMuestra->codigo_muestra = $codigo;
            if($tipogenera==1){
                $newMuestra->codigo_secuencial = 3;
            }
            else{
                $newMuestra->codigo_secuencial = $codigo;
            }
            $fechacomoentero = strtotime($pa->fecha_toma_tercera);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->cuarta_id>0){
            if($tipogenera==2){
                $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
            }
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $pa->sedes_id;
            $newMuestra->crns_id = $pa->crns_id;
            $newMuestra->evento_id = $ev;
            $newMuestra->muestra_id = $pa->cuarta_id;
            $newMuestra->clase_id = $pa->clase_cuarta_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $pa->fecha_toma_cuarta;
            $newMuestra->estado_muestra_id = $pa->estado_cuarta_id;
            $newMuestra->observacion_muestra = $pa->observacion_cuarta;
            $newMuestra->codigo_muestra = $codigo;
            if($tipogenera==1){
                $newMuestra->codigo_secuencial = 4;
            }
            else{
                $newMuestra->codigo_secuencial = $codigo;
            }
            $fechacomoentero = strtotime($pa->fecha_toma_cuarta);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->quinta_id>0){
            if($tipogenera==2){
                $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
            }
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $pa->sedes_id;
            $newMuestra->crns_id = $pa->crns_id;
            $newMuestra->evento_id = $ev;
            $newMuestra->muestra_id = $pa->quinta_id;
            $newMuestra->clase_id = $pa->clase_quinta_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $pa->fecha_toma_quinta;
            $newMuestra->estado_muestra_id = $pa->estado_quinta_id;
            $newMuestra->observacion_muestra = $pa->observacion_quinta;
            $newMuestra->codigo_muestra = $codigo;
            if($tipogenera==1){
                $newMuestra->codigo_secuencial = 5;
            }
            else{
                $newMuestra->codigo_secuencial = $codigo;
            }
            $fechacomoentero = strtotime($pa->fecha_toma_quinta);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $user = auth()->user()->id;
            $sedeUser = Responsable::where('estado','=','A')->where('tipo_id','=',3)->where('usuario_id','=',$user)->where('vigente_hasta','=',null)->pluck('sedes_id');
            $total = $sedeUser->count();
            $fecha_anio = date("Y");
            $absede = Sede::findOrFail(1);
            $abcrn = Crn::findOrFail(12);
            $cargapac = Pacientetemp::where('estado','=','A')->orderBy('id','asc')->get();

            foreach($cargapac as $pac){
                if($pac->id_paciente==0){
                    $newPac = new Paciente();
                    $newPac->nombres = $pac->nombres;
                    $newPac->apellidos = $pac->apellidos;
                    $newPac->identidad = $pac->identidad;
                    $newPac->hcu = $pac->identidad;
                    $newPac->fechanacimiento = $pac->fechanacimiento;
                    $newPac->sexo_id = 1;
                    $newPac->direccion = '-';
                    $newPac->telefono = '0000000';
                    $newPac->canton_id = 75;
                    $newPac->provincia_id = 9;
                    $newPac->nacionalidad_id = 14;
                    $newPac->save();
                    $idpac = $newPac->id;
                }
                else{
                    $idpac = $pac->id_paciente;
                }
                $fechat = $pac->fecha_toma;
                $horat = $pac->hora_toma;

                $newToma = new Preanalitica();
                $newToma->instituciones_id = $this->Preanaliticas->instituciones_id;
                $newToma->paciente_id = $idpac;
                $newToma->fecha_atencion = $this->Preanaliticas->fecha_recepcion;
                $newToma->quien_notifica = $this->Preanaliticas->quien_notifica;
                $newToma->probable_infeccion = '';
                $newToma->fecha_sintomas = $this->Preanaliticas->fecha_recepcion;
                $newToma->fecha_recepcion = $this->Preanaliticas->fecha_recepcion;
                if($total>0){
                    $newToma->ingresa_por = $sedeUser[0];
                }
                else{
                    $newToma->ingresa_por = 0;
                }
                $newToma->embarazo = 'N';
                $newToma->gestacion = 0;
                $newToma->laboratorio = 'N';
                $newToma->nombre_laboratorio = '';
                $newToma->sedes_id = $this->Preanaliticas->sedes_id;
                $newToma->crns_id = $this->Preanaliticas->crns_id;
                $newToma->evento_id = $this->Preanaliticas->evento_id;
                $newToma->clase_primera_id = 1;
                $newToma->primera_id = 159;
                $newToma->estado_primera_id = 1;
                $newToma->fecha_toma_primera = $fechat;
                $newToma->hora_toma_primera = $horat;
                $newToma->anio_registro = $fecha_anio;
                $newToma->usuariot_id =  $user;
                $newToma->save();

                $tipogenera = $this->tipo_generacion($this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                if($tipogenera==1){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }
                if($tipogenera==2){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }

                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $newToma->id;
                $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                $newMuestra->muestra_id = $this->Preanaliticas->primera_id;
                $newMuestra->clase_id = 1;
                $newMuestra->anio_registro = $fecha_anio;
                $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_primera;
                $newMuestra->estado_muestra_id = 1;
                $newMuestra->observacion_muestra = '';
                $newMuestra->codigo_muestra = $codigo;
                if($tipogenera==1){
                    $newMuestra->codigo_secuencial = 1;
                }
                else{
                    $newMuestra->codigo_secuencial = $codigo;
                }
                $fechacomoentero = strtotime($fechat);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newMuestra->usuariot_id = $user;
                $newMuestra->fecha_toma = $fechat;
                $newMuestra->hora_toma = $horat;
                $newMuestra->save();
            }

            foreach($cargapac as $pac){
                $pac->delete();
            }

            DB::commit();
            $this->alert('success', 'Preanalitica agregado con éxito');
            $this->emit('renderJs');
            return redirect()->route('preanaliticacd4.index');
        }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al agregar la Preanalitica '.$e->getMessage());
            $this->emit('renderJs');
            return $e->getMessage();
        }

    }


    public function diferencia($fsintomas, $fregistro){
        $datetime1 = new Datetime($fsintomas);
        $datetime2 = new Datetime($fregistro);
        $diff = $datetime1->diff($datetime2);
        return $diff->days;
    }

    public function sgte_codigomuestra($anio, $sede, $crn){
        $max = Analitica::where('estado','=','A')->where('anio_registro','=',$anio)->where('sedes_id','=',$sede)->where('crns_id','=',$crn)->max('codigo_muestra');
        return $max+1;
    }

    public function tipo_generacion($sede, $crn){
        $tipog = Generacioncodigos::where('estado','=','A')->where('sedes_id','=',$sede)->where('crns_id','=',$crn)->max('tipo_id');
        return $tipog;
    }

    public function update(){
        DB::beginTransaction();
        try{
            $this->validate();
            $this->savePreanalitica();
            $updatePre = Preanalitica::findOrFail($this->Preanaliticas->id);
            $updatePre->instituciones_id=$this->Preanaliticas->instituciones_id;
            $updatePre->fecha_atencion=$this->Preanaliticas->fecha_atencion;
            $updatePre->quien_notifica=$this->Preanaliticas->quien_notifica;
            $updatePre->paciente_id=$this->Preanaliticas->paciente_id;

            $newPac = Paciente::findOrFail($this->Preanaliticas->paciente_id);
            $newPac->nombres = $this->Preanaliticas->paciente_nombres;
            $newPac->apellidos = $this->Preanaliticas->paciente_apellidos;
            $newPac->identidad = $this->Preanaliticas->identidad;
            $newPac->hcu = $this->Preanaliticas->identidad;
            $newPac->fechanacimiento = $this->Preanaliticas->paciente_fechanac;
            $newPac->sexo_id = $this->Preanaliticas->paciente_sexo;
            $newPac->direccion = $this->Preanaliticas->paciente_direccion;
            $newPac->telefono = $this->Preanaliticas->paciente_telefono;
            $newPac->canton_id = $this->Preanaliticas->paciente_ubicacion;
            $prov = Canton::findOrFail($this->Preanaliticas->paciente_ubicacion);
            $newPac->provincia_id = $prov->provincia_id;
            $newPac->nacionalidad_id = $this->Preanaliticas->paciente_nacionalidad;
            $newPac->update();

            $updatePre->probable_infeccion=$this->Preanaliticas->probable_infeccion;
            $updatePre->fecha_sintomas=$this->Preanaliticas->fecha_sintomas;
            $updatePre->fecha_recepcion=$this->Preanaliticas->fecha_recepcion;
            $updatePre->embarazo=$this->Preanaliticas->embarazo;
            $updatePre->gestacion=$this->Preanaliticas->gestacion;
            $updatePre->laboratorio=$this->Preanaliticas->laboratorio;
            $updatePre->nombre_laboratorio=$this->Preanaliticas->nombre_laboratorio;

            $updatePre->sedes_id=$this->Preanaliticas->sedes_id;
            $updatePre->crns_id=$this->Preanaliticas->crns_id;
            $updatePre->evento_id=$this->Preanaliticas->evento_id;
            $updatePre->anio_registro=$this->Preanaliticas->anio_registro;

            $updatePre->primera_id = $this->Preanaliticas->primera_id;
            $updatePre->clase_primera_id = $this->Preanaliticas->clase_primera_id;
            $updatePre->primera_id = $this->Preanaliticas->primera_id;
            $updatePre->fecha_toma_primera = $this->Preanaliticas->fecha_toma_primera;
            $updatePre->observacion_primera = $this->Preanaliticas->observacion_primera;

            $updatePre->segunda_id = $this->Preanaliticas->segunda_id;
            $updatePre->clase_segunda_id = $this->Preanaliticas->clase_segunda_id;
            $updatePre->segunda_id = $this->Preanaliticas->segunda_id;
            $updatePre->fecha_toma_segunda = $this->Preanaliticas->fecha_toma_segunda;
            $updatePre->observacion_segunda = $this->Preanaliticas->observacion_segunda;

            $updatePre->tercera_id = $this->Preanaliticas->tercera_id;
            $updatePre->clase_tercera_id = $this->Preanaliticas->clase_tercera_id;
            $updatePre->tercera_id = $this->Preanaliticas->tercera_id;
            $updatePre->fecha_toma_tercera = $this->Preanaliticas->fecha_toma_tercera;
            $updatePre->observacion_tercera = $this->Preanaliticas->observacion_tercera;

            $updatePre->cuarta_id = $this->Preanaliticas->cuarta_id;
            $updatePre->clase_cuarta_id = $this->Preanaliticas->clase_cuarta_id;
            $updatePre->cuarta_id = $this->Preanaliticas->cuarta_id;
            $updatePre->fecha_toma_cuarta = $this->Preanaliticas->fecha_toma_cuarta;
            $updatePre->observacion_cuarta = $this->Preanaliticas->observacion_cuarta;

            $updatePre->quinta_id = $this->Preanaliticas->quinta_id;
            $updatePre->clase_quinta_id = $this->Preanaliticas->clase_quinta_id;
            $updatePre->quinta_id = $this->Preanaliticas->quinta_id;
            $updatePre->fecha_toma_quinta = $this->Preanaliticas->fecha_toma_quinta;
            $updatePre->observacion_quinta = $this->Preanaliticas->observacion_quinta;
            $this->savePreanalitica();
            $updatePre->archivo = $this->Preanaliticas->archivo;
            $updatePre->update();

            $tipogenera = $this->tipo_generacion($this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            if($tipogenera==1){
                $codigo = $this->sgte_codigomuestra($this->Preanaliticas->anio_registro,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            }

            $muestra = 0;
            if($this->Preanaliticas->primera_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',1)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticas->id;
                    $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticas->primera_id;
                    $newMuestra->clase_id = $this->Preanaliticas->clase_primera_id;
                    $newMuestra->anio_registro = $this->Preanaliticas->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_primera;
                    $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_primera_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_primera;
                    $newMuestra->codigo_muestra = $codigo;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 1;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticas->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',1)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticas->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticas->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticas->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticas->primera_id;
                    $updateAnalitica->clase_id = $this->Preanaliticas->clase_primera_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticas->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticas->fecha_toma_primera;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticas->estado_primera_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticas->observacion_primera;
                    $muestra = $updateAnalitica->codigo_muestra;
                    $updateAnalitica->codigo_secuencial = 1;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticas->segunda_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',2)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticas->id;
                    $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticas->segunda_id;
                    $newMuestra->clase_id = $this->Preanaliticas->clase_segunda_id;
                    $newMuestra->anio_registro = $this->Preanaliticas->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_segunda;
                    $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_segunda_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_segunda;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 2;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticas->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',2)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticas->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticas->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticas->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticas->segunda_id;
                    $updateAnalitica->clase_id = $this->Preanaliticas->clase_segunda_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticas->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticas->fecha_toma_segunda;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticas->estado_segunda_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticas->observacion_segunda;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 2;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticas->tercera_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',3)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticas->id;
                    $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticas->tercera_id;
                    $newMuestra->clase_id = $this->Preanaliticas->clase_tercera_id;
                    $newMuestra->anio_registro = $this->Preanaliticas->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_tercera;
                    $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_tercera_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_tercera;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 3;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticas->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',3)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticas->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticas->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticas->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticas->tercera_id;
                    $updateAnalitica->clase_id = $this->Preanaliticas->clase_tercera_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticas->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticas->fecha_toma_tercera;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticas->estado_tercera_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticas->observacion_tercera;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 3;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticas->cuarta_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',4)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticas->id;
                    $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticas->cuarta_id;
                    $newMuestra->clase_id = $this->Preanaliticas->clase_cuarta_id;
                    $newMuestra->anio_registro = $this->Preanaliticas->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_cuarta;
                    $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_cuarta_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_cuarta;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 4;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticas->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',4)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticas->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticas->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticas->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticas->cuarta_id;
                    $updateAnalitica->clase_id = $this->Preanaliticas->clase_cuarta_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticas->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticas->fecha_toma_cuarta;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticas->estado_cuarta_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticas->observacion_cuarta;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 4;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticas->quinta_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',5)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticas->id;
                    $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticas->quinta_id;
                    $newMuestra->clase_id = $this->Preanaliticas->clase_quinta_id;
                    $newMuestra->anio_registro = $this->Preanaliticas->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_quinta;
                    $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_quinta_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_quinta;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 5;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticas->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticas->id)->where('anio_registro','=',$this->Preanaliticas->anio_registro)->where('codigo_secuencial','=',4)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticas->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticas->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticas->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticas->quinta_id;
                    $updateAnalitica->clase_id = $this->Preanaliticas->clase_quinta_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticas->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticas->fecha_toma_quinta;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticas->estado_quinta_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticas->observacion_quinta;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 5;
                    $updateAnalitica->update();
                }
            }

            DB::commit();
            $this->alert('success', 'Preanalitica actualizado con éxito');
            $this->emit('closeModal');
            return redirect()->route('preanalitica.index');
        }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al actualizar la Preanalitica '.$e->getMessage());
            $this->emit('renderJs');
            return $e->getMessage();
        }

    }

    public function savePreanalitica(){
        if($this->PreanaliticaTmp){
            if(Storage::exists($this->Preanaliticas->archivo)){
                Storage::delete($this->Preanaliticas->archivo);
            }

            $path = $this->PreanaliticaTmp->store('public/fichas/crns');
            $path = substr($path, 7);
            $this->Preanaliticas->archivo = $path;

        }
    }

    public function removePreanalitica(){
        if($this->Preanaliticas->archivo){
            if(Storage::exists($this->Preanaliticas->archivo)){
                Storage::delete($this->Preanaliticas->archivo);
            }

            $this->Preanaliticas->archivo = null;
            $this->Preanaliticas->update();
        }
        $this->reset('PreanaliticaTmp');
        $this->alert('success', 'Ficha digitalizada eliminada con exito');
    }
}
