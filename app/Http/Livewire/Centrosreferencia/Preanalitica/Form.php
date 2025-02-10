<?php

namespace App\Http\Livewire\Centrosreferencia\Preanalitica;

use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Analitica;
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
    public $eventos;
    public $tecnicas;
    public $cantones;
    public $reportes;
    public $crns;
    public $selectedSedep = null;
    public $selectedCrnp = null;
    public $selectedProvincia = null;
    public $changedInstitucion = null;
    public $changedIdentidad = null;
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
            'Preanaliticas.paciente_id' => 'sometimes|max:10',
            'Preanaliticas.identidad' => 'sometimes|max:10',
            'Preanaliticas.paciente_fechanac' => 'required|max:10',
            'Preanaliticas.paciente_sexo' => 'required|numeric',
            'Preanaliticas.paciente_nombres' => 'sometimes|max:75',
            'Preanaliticas.paciente_apellidos' => 'sometimes|max:75',
            'Preanaliticas.paciente_direccion' => 'sometimes|max:175',
            'Preanaliticas.paciente_telefono' => 'sometimes|max:15',
            'Preanaliticas.paciente_ubicacion' => 'sometimes|max:150',
            'Preanaliticas.paciente_nacionalidad' => 'sometimes|max:150',
            'Preanaliticas.fecha_atencion' => 'required|max:10',
            'Preanaliticas.quien_notifica' => 'required|max:80',
            'Preanaliticas.probable_infeccion' => 'sometimes|max:200',
            'Preanaliticas.fecha_sintomas' => 'required|max:10',

            'Preanaliticas.embarazo' => 'sometimes|max:1',
            'Preanaliticas.gestacion' => 'sometimes|numeric',
            'Preanaliticas.evolucion' => 'sometimes',
            'Preanaliticas.laboratorio' => 'sometimes|max:1',
            'Preanaliticas.nombre_laboratorio' => 'sometimes|max:100',

            'Preanaliticas.sedes_id' => 'required|numeric',
            'Preanaliticas.crns_id' => 'required|numeric',
            'Preanaliticas.evento_id' => 'required|numeric',

            'Preanaliticas.primera_id' => 'required|numeric',
            'Preanaliticas.clase_primera_id' => 'required|numeric',
            'Preanaliticas.fecha_toma_primera' => 'required|max:10',
            'Preanaliticas.estado_primera_id' => 'required|numeric',
            'Preanaliticas.observacion_primera' => 'sometimes|max:200',
            'Preanaliticas.segunda_id' => 'sometimes|numeric',
            'Preanaliticas.clase_segunda_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_segunda' => 'sometimes|max:10',
            'Preanaliticas.estado_segunda_id' => 'sometimes|numeric',
            'Preanaliticas.observacion_segunda' => 'sometimes|max:200',
            'Preanaliticas.tercera_id' => 'sometimes|numeric',
            'Preanaliticas.clase_tercera_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_tercera' => 'sometimes|max:10',
            'Preanaliticas.estado_tercera_id' => 'sometimes|numeric',
            'Preanaliticas.observacion_tercera' => 'sometimes|max:200',
            'Preanaliticas.cuarta_id' => 'sometimes|numeric',
            'Preanaliticas.clase_cuarta_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_cuarta' => 'sometimes|max:10',
            'Preanaliticas.estado_cuarta_id' => 'sometimes|numeric',
            'Preanaliticas.observacion_cuarta' => 'sometimes|max:200',
            'Preanaliticas.quinta_id' => 'sometimes|numeric',
            'Preanaliticas.clase_quinta_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_quinta' => 'sometimes|max:10',
            'Preanaliticas.estado_quinta_id' => 'sometimes|numeric',
            'Preanaliticas.observacion_quinta' => 'sometimes|max:200',
        ];
    }

    public function mount(Preanalitica $Preanalitica, $method){
        $this->Preanaliticas = $Preanalitica;
        $this->method = $method;
        if($this->Preanaliticas->segunda_id == 0){
            $this->Preanaliticas->clase_segunda_id = 0;
            $this->Preanaliticas->segunda_id = 0;
            $this->Preanaliticas->estado_segunda_id = 0;
        }
        if($this->Preanaliticas->tercera_id == 0){
            $this->Preanaliticas->clase_tercera_id = 0;
            $this->Preanaliticas->tercera_id = 0;
            $this->Preanaliticas->estado_tercera_id = 0;
        }
        if($this->Preanaliticas->cuarta_id == 0){
            $this->Preanaliticas->clase_cuarta_id = 0;
            $this->Preanaliticas->cuarta_id = 0;
            $this->Preanaliticas->estado_cuarta_id = 0;
        }
        if($this->Preanaliticas->quinta_id == 0){
            $this->Preanaliticas->clase_quinta_id = 0;
            $this->Preanaliticas->quinta_id = 0;
            $this->Preanaliticas->estado_quinta_id = 0;
        }
        $this->Preanaliticas->evolucion = $this->diferencia($this->Preanaliticas->fecha_sintomas,$this->Preanaliticas->created_at);

        if($method=="update"){
            $this->Preanaliticas->identidad=$this->Preanaliticas->paciente->identidad;
            $this->updatedchangedInstitucion($this->Preanaliticas->instituciones_id);
            $this->updatedchangedIdentidad($this->Preanaliticas->paciente->identidad);
            $this->updatedselectedSedep($this->Preanaliticas->sedes_id);
            $this->updatedselectedCrnp($this->Preanaliticas->crns_id);
        }
        else{
            $this->Preanaliticas->embarazo='N';
            $this->Preanaliticas->laboratorio='N';
            $this->Preanaliticas->gestacion=0;
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

    public function updatedselectedSedep($sede_id){
        $config = SedeCrn::where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrnp($crns_id){
        $this->eventos = Evento::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedProvincia($provincia_id){
        $this->cantones = Canton::where('provincia_id','=',$provincia_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedchangedIdentidad($identidad){
        $existe = Paciente::where('estado','=','A')->where('identidad','=',$identidad)->count();
        if ($existe>0){
            $pacSelected = Paciente::where('estado','=','A')->where('identidad','=',$identidad)->first();
            //dd($pacSelected); die();
            $this->Preanaliticas->paciente_id = $pacSelected->id;
            $this->Preanaliticas->paciente_sexo = $pacSelected->sexo_id;
            $this->Preanaliticas->paciente_nombres = $pacSelected->nombres;
            $this->Preanaliticas->paciente_apellidos = $pacSelected->apellidos;
            $this->Preanaliticas->paciente_fechanac = $pacSelected->fechanacimiento;
            $this->Preanaliticas->paciente_direccion = $pacSelected->direccion;
            $this->Preanaliticas->paciente_telefono = $pacSelected->telefono;
            $this->Preanaliticas->paciente_ubicacion = $pacSelected->canton_id;
            $this->Preanaliticas->paciente_nacionalidad = $pacSelected->nacionalidad_id;
        }
        else{
            $this->Preanaliticas->paciente_id = 0;
            $this->Preanaliticas->paciente_nombres = '';
            $this->Preanaliticas->paciente_apellidos = '';
            $this->Preanaliticas->paciente_direccion = '';
            $this->Preanaliticas->paciente_telefono = '';
            $this->Preanaliticas->paciente_ubicacion = '';
            $this->Preanaliticas->paciente_nacionalidad = 0;
        }
        $this->emit('renderJs');
    }

    public function render(){

        $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $sexos = Sexo::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $cantonprov = Canton::where('estado','=','A')->orderBy('id','asc')->cursor();
        $muestras = Muestra::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $estados = Estadomuestra::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $instituciones = Institucion::where('estado','=','A')->orderBy('id','asc')->cursor();
        $nacionalidades = Nacionalidad::where('estado','=',1)->orderBy('id','asc')->cursor();
        $clases = Clase::where('estado','=','A')->orderBy('id','asc')->cursor();
        $pacientes = Paciente::where('estado','=','A')->orderBy('id','asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.centrosreferencia.preanalitica.form', compact('sedes','sexos','pacientes','muestras','instituciones','estados','nacionalidades','cantonprov','clases'));
    }

    public function updatedselectedSede($sede_id){
        $config = SedeCrn::where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrn($crns_id){
        $this->eventos = Evento::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $user = auth()->user()->id;
            $fecha_anio = date("Y");
            $absede = Sede::findOrFail($this->Preanaliticas->sedes_id);
            $abcrn = Crn::findOrFail($this->Preanaliticas->crns_id);
            if($this->Preanaliticas->paciente_id == 0){
                $newPac = new Paciente();
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
                $newPac->save();
            }
            $newToma = new Preanalitica();
            $newToma->instituciones_id = $this->Preanaliticas->instituciones_id;
            if($this->Preanaliticas->paciente_id == 0){
                $newToma->paciente_id = $newPac->id;
            }
            else{
                $newToma->paciente_id = $this->Preanaliticas->paciente_id;
            }

            $newToma->fecha_atencion = $this->Preanaliticas->fecha_atencion;
            $newToma->quien_notifica = $this->Preanaliticas->quien_notifica;
            $newToma->probable_infeccion = $this->Preanaliticas->probable_infeccion;
            $newToma->fecha_sintomas = $this->Preanaliticas->fecha_sintomas;
            $newToma->embarazo = $this->Preanaliticas->embarazo;

            $newToma->gestacion = $this->Preanaliticas->gestacion;
            $newToma->laboratorio = $this->Preanaliticas->laboratorio;

            $newToma->nombre_laboratorio = $this->Preanaliticas->nombre_laboratorio;
            $newToma->sedes_id = $this->Preanaliticas->sedes_id;
            $newToma->crns_id = $this->Preanaliticas->crns_id;
            $newToma->evento_id = $this->Preanaliticas->evento_id;
            if($this->Preanaliticas->primera_id>0){
                $newToma->clase_primera_id = $this->Preanaliticas->clase_primera_id;
                $newToma->primera_id = $this->Preanaliticas->primera_id;
                $newToma->fecha_toma_primera = $this->Preanaliticas->fecha_toma_primera;
            }
            else{
                $newToma->primera_id = 0;
            }
            if($this->Preanaliticas->segunda_id>0){
                $newToma->clase_segunda_id = $this->Preanaliticas->clase_segunda_id;
                $newToma->segunda_id = $this->Preanaliticas->segunda_id;
                $newToma->fecha_toma_segunda = $this->Preanaliticas->fecha_toma_segunda;
            }
            else{
                $newToma->segunda_id = 0;
            }
            if($this->Preanaliticas->tercera_id>0){
                $newToma->clase_tercera_id = $this->Preanaliticas->clase_tercera_id;
                $newToma->tercera_id = $this->Preanaliticas->tercera_id;
                $newToma->fecha_toma_tercera = $this->Preanaliticas->fecha_toma_tercera;
            }
            else{
                $newToma->tercera_id = 0;
            }
            if($this->Preanaliticas->cuarta_id>0){
                $newToma->clase_cuarta_id = $this->Preanaliticas->clase_cuarta_id;
                $newToma->cuarta_id = $this->Preanaliticas->cuarta_id;
                $newToma->fecha_toma_cuarta = $this->Preanaliticas->fecha_toma_cuarta;
            }
            else{
                $newToma->cuarta_id = 0;
            }
            if($this->Preanaliticas->quinta_id>0){
                $newToma->clase_quinta_id = $this->Preanaliticas->clase_quinta_id;
                $newToma->quinta_id = $this->Preanaliticas->quinta_id;
                $newToma->fecha_toma_quinta = $this->Preanaliticas->fecha_toma_quinta;
            }
            else{
                $newToma->quinta_id = 0;
            }
            $newToma->anio_registro = $fecha_anio;
            $newToma->usuariot_id =  $user;
            $this->savePreanalitica();
            $newToma->archivo = $this->Preanaliticas->archivo;
            $newToma->save();

            $tipogenera = $this->tipo_generacion($this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            if($tipogenera==1){
                $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            }
            if($this->Preanaliticas->primera_id>0){
                if($tipogenera==2){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $newToma->id;
                $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                $newMuestra->muestra_id = $this->Preanaliticas->primera_id;
                $newMuestra->clase_id = $this->Preanaliticas->clase_primera_id;
                $newMuestra->anio_registro = $fecha_anio;
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
                $fechacomoentero = strtotime($this->Preanaliticas->fecha_toma_primera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newMuestra->usuariot_id = $user;
                $newMuestra->save();
            }
            if($this->Preanaliticas->segunda_id>0){
                if($tipogenera==2){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $newToma->id;
                $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                $newMuestra->muestra_id = $this->Preanaliticas->segunda_id;
                $newMuestra->clase_id = $this->Preanaliticas->clase_segunda_id;
                $newMuestra->anio_registro = $fecha_anio;
                $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_segunda;
                $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_segunda_id;
                $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_segunda;
                $newMuestra->codigo_muestra = $codigo;
                if($tipogenera==1){
                    $newMuestra->codigo_secuencial = 2;
                }
                else{
                    $newMuestra->codigo_secuencial = $codigo;
                }
                $fechacomoentero = strtotime($this->Preanaliticas->fecha_toma_segunda);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newMuestra->usuariot_id = $user;
                $newMuestra->save();
            }
            if($this->Preanaliticas->tercera_id>0){
                if($tipogenera==2){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $newToma->id;
                $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                $newMuestra->muestra_id = $this->Preanaliticas->tercera_id;
                $newMuestra->clase_id = $this->Preanaliticas->clase_tercera_id;
                $newMuestra->anio_registro = $fecha_anio;
                $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_tercera;
                $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_tercera_id;
                $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_tercera;
                $newMuestra->codigo_muestra = $codigo;
                if($tipogenera==1){
                    $newMuestra->codigo_secuencial = 3;
                }
                else{
                    $newMuestra->codigo_secuencial = $codigo;
                }
                $fechacomoentero = strtotime($this->Preanaliticas->fecha_toma_tercera);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newMuestra->usuariot_id = $user;
                $newMuestra->save();
            }
            if($this->Preanaliticas->cuarta_id>0){
                if($tipogenera==2){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $newToma->id;
                $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                $newMuestra->muestra_id = $this->Preanaliticas->cuarta_id;
                $newMuestra->clase_id = $this->Preanaliticas->clase_cuarta_id;
                $newMuestra->anio_registro = $fecha_anio;
                $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_cuarta;
                $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_cuarta_id;
                $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_cuarta;
                $newMuestra->codigo_muestra = $codigo;
                if($tipogenera==1){
                    $newMuestra->codigo_secuencial = 4;
                }
                else{
                    $newMuestra->codigo_secuencial = $codigo;
                }
                $fechacomoentero = strtotime($this->Preanaliticas->fecha_toma_cuarta);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newMuestra->usuariot_id = $user;
                $newMuestra->save();
            }
            if($this->Preanaliticas->quinta_id>0){
                if($tipogenera==2){
                    $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
                }
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $newToma->id;
                $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
                $newMuestra->crns_id = $this->Preanaliticas->crns_id;
                $newMuestra->evento_id = $this->Preanaliticas->evento_id;
                $newMuestra->muestra_id = $this->Preanaliticas->quinta_id;
                $newMuestra->clase_id = $this->Preanaliticas->clase_quinta_id;
                $newMuestra->anio_registro = $fecha_anio;
                $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_quinta;
                $newMuestra->estado_muestra_id = $this->Preanaliticas->estado_quinta_id;
                $newMuestra->observacion_muestra = $this->Preanaliticas->observacion_quinta;
                $newMuestra->codigo_muestra = $codigo;
                if($tipogenera==1){
                    $newMuestra->codigo_secuencial = 5;
                }
                else{
                    $newMuestra->codigo_secuencial = $codigo;
                }
                $fechacomoentero = strtotime($this->Preanaliticas->fecha_toma_quinta);
                $anio = date("Y", $fechacomoentero)-2000;
                $mes = date("m", $fechacomoentero);
                $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                $newMuestra->usuariot_id = $user;
                $newMuestra->save();
            }
            DB::commit();
            $this->alert('success', 'Preanalitica agregado con éxito');
            $this->emit('renderJs');
            return redirect()->route('preanalitica.index');
        }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al agregar la Preanalitica');
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
        $this->validate();
        $this->savePreanalitica();
        $updatePre = Preanalitica::findOrFail($this->Preanaliticas->id);
        $updatePre->instituciones_id=$this->Preanaliticas->instituciones_id;
        $updatePre->fecha_atencion=$this->Preanaliticas->fecha_atencion;
        $updatePre->quien_notifica=$this->Preanaliticas->quien_notifica;
        $updatePre->paciente_id=$this->Preanaliticas->paciente_id;
        $updatePre->probable_infeccion=$this->Preanaliticas->probable_infeccion;
        $updatePre->fecha_sintomas=$this->Preanaliticas->fecha_sintomas;
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

        $this->alert('success', 'Preanalitica actualizado con éxito');
        $this->emit('closeModal');
        return redirect()->route('preanalitica.index');

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
            $this->Preanaliticass->update();
        }
        $this->reset('PreanaliticaTmp');
        $this->alert('success', 'Ficha digitalizada eliminada con exito');
    }
}
