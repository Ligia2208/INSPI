<?php

namespace App\Http\Livewire\Centrosreferencia\Preanaliticamico;

use App\Models\CentrosReferencia\Preanaliticamico;
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
use App\Models\CentrosReferencia\Responsable;

use App\Models\CentrosReferencia\Micobacteria;

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
    public $Preanaliticastoxico;
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
    public $IdPreanalitica;


    protected $listeners = ['render'];

    protected function rules(){
        $rules = [
            'Preanaliticastoxico.instituciones_id' => 'required|numeric',
            'Preanaliticastoxico.institucion_nombre' => 'sometimes|max:525',
            'Preanaliticastoxico.institucion_clasificacion' => 'sometimes|max:75',
            'Preanaliticastoxico.institucion_nivel' => 'sometimes|max:75',
            'Preanaliticastoxico.institucion_tipologia' => 'sometimes|max:75',
            'Preanaliticastoxico.institucion_ubicacion' => 'sometimes|max:150',
            'Preanaliticastoxico.paciente_id' => 'sometimes|max:10',
            'Preanaliticastoxico.identidad' => 'sometimes|max:13',
            'Preanaliticastoxico.paciente_fechanac' => 'required|max:10',
            'Preanaliticastoxico.paciente_sexo' => 'required|numeric',
            'Preanaliticastoxico.paciente_nombres' => 'sometimes|max:75',
            'Preanaliticastoxico.paciente_apellidos' => 'sometimes|max:75',
            'Preanaliticastoxico.paciente_direccion' => 'sometimes|max:175',
            'Preanaliticastoxico.paciente_telefono' => 'sometimes|max:15',
            'Preanaliticastoxico.paciente_ubicacion' => 'sometimes|max:150',
            'Preanaliticastoxico.paciente_nacionalidad' => 'sometimes|max:150',
            'Preanaliticastoxico.fecha_recepcion' => 'required|max:10',
            'Preanaliticastoxico.fecha_atencion' => 'required|max:10',
            'Preanaliticastoxico.quien_notifica' => 'required|max:80',
            'Preanaliticastoxico.probable_infeccion' => 'sometimes|max:200',

            'Preanaliticastoxico.nombre_lote'         => 'sometimes|max:200',
            'Preanaliticastoxico.n_tubos'             => 'sometimes|max:200',
            'Preanaliticastoxico.responsable_recep'   => 'sometimes|max:200',

            'Preanaliticastoxico.triple_empaque'      => 'sometimes|max:200',
            'Preanaliticastoxico.columnas'            => 'sometimes|max:200',
            'Preanaliticastoxico.cultivos_puros'      => 'sometimes|max:200',
            'Preanaliticastoxico.crecimiento'         => 'sometimes|max:200',
            'Preanaliticastoxico.cultivo_sin_liquido' => 'sometimes|max:200',
            'Preanaliticastoxico.cultivo_crecimiento' => 'sometimes|max:200',
            'Preanaliticastoxico.cod_muestra_hosp'    => 'sometimes|max:200',
            
            'Preanaliticastoxico.prueba_sensibilidad' => 'sometimes|max:200',
            'Preanaliticastoxico.tipificacion'        => 'sometimes|max:200',
            'Preanaliticastoxico.evento_id'           => 'required|numeric',

            'Preanaliticastoxico.sedes_id' => 'required|numeric',
            'Preanaliticastoxico.crns_id' => 'required|numeric',
            'Preanaliticastoxico.evento_id' => 'required|numeric',

            'Preanaliticastoxico.primera_id' => 'required|numeric',
            'Preanaliticastoxico.clase_primera_id' => 'required|numeric',
            'Preanaliticastoxico.fecha_toma_primera' => 'required|max:10',
            'Preanaliticastoxico.estado_primera_id' => 'required|numeric',
            'Preanaliticastoxico.observacion_primera' => 'sometimes|max:200',
            'Preanaliticastoxico.segunda_id' => 'sometimes|numeric',
            'Preanaliticastoxico.clase_segunda_id' => 'sometimes|numeric',
            'Preanaliticastoxico.fecha_toma_segunda' => 'sometimes|max:10',
            'Preanaliticastoxico.estado_segunda_id' => 'sometimes|numeric',
            'Preanaliticastoxico.observacion_segunda' => 'sometimes|max:200',
            'Preanaliticastoxico.tercera_id' => 'sometimes|numeric',
            'Preanaliticastoxico.clase_tercera_id' => 'sometimes|numeric',
            'Preanaliticastoxico.fecha_toma_tercera' => 'sometimes|max:10',
            'Preanaliticastoxico.estado_tercera_id' => 'sometimes|numeric',
            'Preanaliticastoxico.observacion_tercera' => 'sometimes|max:200',
            'Preanaliticastoxico.cuarta_id' => 'sometimes|numeric',
            'Preanaliticastoxico.clase_cuarta_id' => 'sometimes|numeric',
            'Preanaliticastoxico.fecha_toma_cuarta' => 'sometimes|max:10',
            'Preanaliticastoxico.estado_cuarta_id' => 'sometimes|numeric',
            'Preanaliticastoxico.observacion_cuarta' => 'sometimes|max:200',
            'Preanaliticastoxico.quinta_id' => 'sometimes|numeric',
            'Preanaliticastoxico.clase_quinta_id' => 'sometimes|numeric',
            'Preanaliticastoxico.fecha_toma_quinta' => 'sometimes|max:10',
            'Preanaliticastoxico.estado_quinta_id' => 'sometimes|numeric',
            'Preanaliticastoxico.observacion_quinta' => 'sometimes|max:200',
        ];

        if ($this->Preanaliticastoxico->crns_id == 1) {
            // Hacer los datos del paciente no obligatorios
            $rules['Preanaliticastoxico.paciente_id'] = 'nullable|max:10';
            $rules['Preanaliticastoxico.identidad'] = 'nullable|max:13';
            $rules['Preanaliticastoxico.paciente_fechanac'] = 'nullable|max:10';
            $rules['Preanaliticastoxico.paciente_sexo'] = 'nullable|numeric';
            $rules['Preanaliticastoxico.paciente_nombres'] = 'nullable|max:75';
            $rules['Preanaliticastoxico.paciente_apellidos'] = 'nullable|max:75';
            $rules['Preanaliticastoxico.paciente_direccion'] = 'nullable|max:175';
            $rules['Preanaliticastoxico.paciente_telefono'] = 'nullable|max:15';
            $rules['Preanaliticastoxico.paciente_ubicacion'] = 'nullable|max:150';
            $rules['Preanaliticastoxico.paciente_nacionalidad'] = 'nullable|max:150';
        }

        return $rules;

    }

    public function mount(Preanaliticamico $Preanaliticastoxico, $method){
        $this->Preanaliticastoxico = $Preanaliticastoxico;
        $this->method = $method;

        $analiticaUpdate = Analitica::where('estado','=','A')
            ->where('preanalitica_id','=',$this->Preanaliticastoxico->id)
            ->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',1)->first();
        
        if ($analiticaUpdate) {
            $this->Preanaliticastoxico->cod_muestra_hosp = $analiticaUpdate->codigo_externo;
        } else {
            $this->Preanaliticastoxico->cod_muestra_hosp = null; // O algún valor por defecto
        }

        if($this->Preanaliticastoxico->segunda_id == 0){
            $this->Preanaliticastoxico->clase_segunda_id = 0;
            $this->Preanaliticastoxico->segunda_id = 0;
            $this->Preanaliticastoxico->estado_segunda_id = 0;
        }
        if($this->Preanaliticastoxico->tercera_id == 0){
            $this->Preanaliticastoxico->clase_tercera_id = 0;
            $this->Preanaliticastoxico->tercera_id = 0;
            $this->Preanaliticastoxico->estado_tercera_id = 0;
        }
        if($this->Preanaliticastoxico->cuarta_id == 0){
            $this->Preanaliticastoxico->clase_cuarta_id = 0;
            $this->Preanaliticastoxico->cuarta_id = 0;
            $this->Preanaliticastoxico->estado_cuarta_id = 0;
        }
        if($this->Preanaliticastoxico->quinta_id == 0){
            $this->Preanaliticastoxico->clase_quinta_id = 0;
            $this->Preanaliticastoxico->quinta_id = 0;
            $this->Preanaliticastoxico->estado_quinta_id = 0;
        }
        $this->Preanaliticastoxico->evolucion = $this->diferencia($this->Preanaliticastoxico->fecha_sintomas,$this->Preanaliticastoxico->created_at);

        if($method=="update"){
            $this->Preanaliticastoxico->identidad=$this->Preanaliticastoxico->paciente->identidad;
            $this->updatedchangedInstitucion($this->Preanaliticastoxico->instituciones_id);
            $this->updatedchangedIdentidad(2869);
            $this->updatedselectedSedep($this->Preanaliticastoxico->sedes_id);
            $this->updatedselectedCrnp($this->Preanaliticastoxico->crns_id);

            if($this->Preanaliticastoxico->crns_id == 1){
                $this->updatedchangedMicobacterias($this->Preanaliticastoxico->id);
            }

        }
        else{
            $this->Preanaliticastoxico->fecha_recepcion = date('Y-m-d');
            $this->Preanaliticastoxico->embarazo='N';
            $this->Preanaliticastoxico->laboratorio='N';
            $this->Preanaliticastoxico->gestacion=0;
        }

    }


    public function updatedchangedMicobacterias($id_pre_analitica){
        $datosMico = Micobacteria::where('pre_analitica_id', $id_pre_analitica)->first();

        $this->Preanaliticastoxico->nombre_lote = $datosMico->nombre_lote;
        $this->Preanaliticastoxico->n_tubos = $datosMico->n_tubos;

        $this->Preanaliticastoxico->triple_empaque      = $datosMico->triple_empaque;
        $this->Preanaliticastoxico->columnas            = $datosMico->columnas;
        $this->Preanaliticastoxico->cultivos_puros      = $datosMico->cultivos_puros;
        $this->Preanaliticastoxico->crecimiento         = $datosMico->crecimiento;
        $this->Preanaliticastoxico->cultivo_sin_liquido = $datosMico->cultivo_sin_liquido;
        $this->Preanaliticastoxico->cultivo_crecimiento = $datosMico->cultivo_crecimiento;
        $this->Preanaliticastoxico->responsable_recep   = $datosMico->responsable_recep;

        //$this->Preanaliticastoxico->prueba_sensibilidad = $datosMico->prueba_sensibilidad;
        //$this->Preanaliticastoxico->tipificacion        = $datosMico->tipificacion;
    }


    public function updatedchangedInstitucion($institucion_id){
        $instSelected = Institucion::findOrFail($institucion_id);
        $this->Preanaliticastoxico->institucion_nombre = $instSelected->descripcion;
        $this->Preanaliticastoxico->institucion_clasificacion = $instSelected->clasificacion->descripcion;
        $this->Preanaliticastoxico->institucion_nivel = $instSelected->nivel->descripcion;
        $this->Preanaliticastoxico->institucion_tipologia = $instSelected->tipologia->descripcion;
        $this->Preanaliticastoxico->institucion_ubicacion = $instSelected->provincia->descripcion.' - '.$instSelected->canton->descripcion;
        $this->emit('renderJs');
    }

    public function updatedselectedSedep($sede_id){
        /*
        $config = SedeCrn::where('sedes_id','=',$sede_id)->where('crns_id','=',1)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
        */
        $config = SedeCrn::where('sedes_id', $sede_id)
                            ->where('crns_id', 1)
                            ->pluck('crns_id');
    
        $this->crns = Crn::whereIn('id', $config)->select('id', 'descripcion')->get();
        
        $this->emit('renderJs');

    }

    public function updatedselectedCrnp($crns_id){
        $this->eventos = Evento::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
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
            $this->Preanaliticastoxico->paciente_id = $pacSelected->id;
            $this->Preanaliticastoxico->paciente_sexo = $pacSelected->sexo_id;
            $this->Preanaliticastoxico->paciente_nombres = $pacSelected->nombres;
            $this->Preanaliticastoxico->paciente_apellidos = $pacSelected->apellidos;
            $this->Preanaliticastoxico->paciente_fechanac = $pacSelected->fechanacimiento;
            $this->Preanaliticastoxico->paciente_direccion = $pacSelected->direccion;
            $this->Preanaliticastoxico->paciente_telefono = $pacSelected->telefono;
            $this->Preanaliticastoxico->paciente_ubicacion = $pacSelected->canton_id;
            $this->Preanaliticastoxico->paciente_nacionalidad = $pacSelected->nacionalidad_id;
        }
        else{
            $this->Preanaliticastoxico->paciente_id = 0;
            $this->Preanaliticastoxico->paciente_nombres = '';
            $this->Preanaliticastoxico->paciente_apellidos = '';
            $this->Preanaliticastoxico->paciente_direccion = '';
            $this->Preanaliticastoxico->paciente_telefono = '';
            $this->Preanaliticastoxico->paciente_ubicacion = '';
            $this->Preanaliticastoxico->paciente_nacionalidad = 0;
        }
        $this->emit('renderJs');
    }

    public function render(){

        $sedes = Sede::where('estado','=','A')->whereIn('id',[1,2,3])->orderBy('id', 'asc')->cursor();
        $sexos = Sexo::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $cantonprov = Canton::where('estado','=','A')->orderBy('id','asc')->cursor();
        $muestras = Muestra::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $estados = Estadomuestra::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $instituciones = Institucion::whereIn('estado',['A','T'])->orderBy('id','asc')->cursor();
        $nacionalidades = Nacionalidad::where('estado','=',1)->orderBy('id','asc')->cursor();
        $clases = Clase::where('estado','=','A')->orderBy('id','asc')->cursor();
        $pacientes = Paciente::where('estado','=','A')->orderBy('id','asc')->cursor();

        $usuarios = Responsable::select('user.name', 'user.id')
            ->join('bdcoreinspi.users as user', 'user.id', '=', 'responsables.usuario_id')
            ->where('responsables.estado', 'A')
            ->where('responsables.crns_id', $this->Preanaliticastoxico->crns_id)->get();

        $this->emit('renderJs');
        return view('livewire.centrosreferencia.preanaliticamico.form', compact('sedes','sexos','pacientes','muestras','instituciones','estados','nacionalidades',
            'cantonprov','clases', 'usuarios'));
    }

    public function updatedselectedSede($sede_id){
        $config = SedeCrn::where('estado','=','A')->where('crns_id','=',1)->where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::where('estado','=','A')->whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrn($crns_id){
        $this->eventos = Evento::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function guardart(Preanaliticamico $pa, $ev){

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

        $newToma = new Preanaliticamico();
        $newToma->instituciones_id = $pa->instituciones_id;
        if($pa->paciente_id == 0){
            $newToma->paciente_id = $newPac->id;
        }
        else{
            $newToma->paciente_id = $pa->paciente_id;
        }

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
        }
        else{
            $newToma->primera_id = 0;
        }
        if($pa->segunda_id>0){
            $newToma->clase_segunda_id = $pa->clase_segunda_id;
            $newToma->segunda_id = $pa->segunda_id;
            $newToma->fecha_toma_segunda = $pa->fecha_toma_segunda;
        }
        else{
            $newToma->segunda_id = 0;
        }
        if($pa->tercera_id>0){
            $newToma->clase_tercera_id = $pa->clase_tercera_id;
            $newToma->tercera_id = $pa->tercera_id;
            $newToma->fecha_toma_tercera = $pa->fecha_toma_tercera;
        }
        else{
            $newToma->tercera_id = 0;
        }
        if($pa->cuarta_id>0){
            $newToma->clase_cuarta_id = $pa->clase_cuarta_id;
            $newToma->cuarta_id = $pa->cuarta_id;
            $newToma->fecha_toma_cuarta = $pa->fecha_toma_cuarta;
        }
        else{
            $newToma->cuarta_id = 0;
        }
        if($pa->quinta_id>0){
            $newToma->clase_quinta_id = $pa->clase_quinta_id;
            $newToma->quinta_id = $pa->quinta_id;
            $newToma->fecha_toma_quinta = $pa->fecha_toma_quinta;
        }
        else{
            $newToma->quinta_id = 0;
        }

        $newToma->embarazo='N';
        $newToma->laboratorio='N';
        $newToma->gestacion=0;
        $newToma->anio_registro = $fecha_anio;
        $newToma->usuariot_id =  $user;
        $this->savePreanalitica();
        $newToma->archivo = $pa->archivo;
        $newToma->save();
        $this->IdPreanalitica = $newToma->id;
        $tipogenera = $this->tipo_generacion($pa->sedes_id,$pa->crns_id);
        if($tipogenera==1){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$pa->sedes_id,$pa->crns_id);
        }
        return $codigo;
    }

    public function guardardetallet(Preanaliticamico $pa, $pre, $codigo, $ev){
        $absede = Sede::findOrFail($pa->sedes_id);
        $abcrn = Crn::findOrFail($pa->crns_id);
        $user = auth()->user()->id;
        $fecha_anio = date("Y");
        if($pa->primera_id>0){
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $pre;
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
            $newMuestra->codigo_secuencial = 1;
            $fechacomoentero = strtotime($pa->fecha_toma_primera);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->segunda_id>0){
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $pre;
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
            $newMuestra->codigo_secuencial = 2;
            $fechacomoentero = strtotime($pa->fecha_toma_segunda);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->tercera_id>0){
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $pre;
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
            $newMuestra->codigo_secuencial = 3;
            $fechacomoentero = strtotime($pa->fecha_toma_tercera);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->cuarta_id>0){
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $pre;
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
            $newMuestra->codigo_secuencial = 4;
            $fechacomoentero = strtotime($pa->fecha_toma_cuarta);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->quinta_id>0){
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $pre;
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
            $newMuestra->codigo_secuencial = 5;
            $fechacomoentero = strtotime($pa->fecha_toma_quinta);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
    }

    public function guardarp(Preanaliticamico $pa, $ev){

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
        $newToma = new Preanaliticamico();
        $newToma->instituciones_id = $pa->instituciones_id;
        if($pa->paciente_id == 0){
            $newToma->paciente_id = $newPac->id;
        }
        else{
            $newToma->paciente_id = $pa->paciente_id;
        }

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
        }
        else{
            $newToma->primera_id = 0;
        }
        if($pa->segunda_id>0){
            $newToma->clase_segunda_id = $pa->clase_segunda_id;
            $newToma->segunda_id = $pa->segunda_id;
            $newToma->fecha_toma_segunda = $pa->fecha_toma_segunda;
        }
        else{
            $newToma->segunda_id = 0;
        }
        if($pa->tercera_id>0){
            $newToma->clase_tercera_id = $pa->clase_tercera_id;
            $newToma->tercera_id = $pa->tercera_id;
            $newToma->fecha_toma_tercera = $pa->fecha_toma_tercera;
        }
        else{
            $newToma->tercera_id = 0;
        }
        if($pa->cuarta_id>0){
            $newToma->clase_cuarta_id = $pa->clase_cuarta_id;
            $newToma->cuarta_id = $pa->cuarta_id;
            $newToma->fecha_toma_cuarta = $pa->fecha_toma_cuarta;
        }
        else{
            $newToma->cuarta_id = 0;
        }
        if($pa->quinta_id>0){
            $newToma->clase_quinta_id = $pa->clase_quinta_id;
            $newToma->quinta_id = $pa->quinta_id;
            $newToma->fecha_toma_quinta = $pa->fecha_toma_quinta;
        }
        else{
            $newToma->quinta_id = 0;
        }

        $newToma->embarazo='N';
        $newToma->laboratorio='N';
        $newToma->gestacion=0;
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
        return $codigo;
    }

    public function guardarpigual(Preanaliticamico $pa, $ev, $codm){

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
        $newToma = new Preanaliticamico();
        $newToma->instituciones_id = $pa->instituciones_id;
        if($pa->paciente_id == 0){
            $newToma->paciente_id = $newPac->id;
        }
        else{
            $newToma->paciente_id = $pa->paciente_id;
        }

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
        }
        else{
            $newToma->primera_id = 0;
        }
        if($pa->segunda_id>0){
            $newToma->clase_segunda_id = $pa->clase_segunda_id;
            $newToma->segunda_id = $pa->segunda_id;
            $newToma->fecha_toma_segunda = $pa->fecha_toma_segunda;
        }
        else{
            $newToma->segunda_id = 0;
        }
        if($pa->tercera_id>0){
            $newToma->clase_tercera_id = $pa->clase_tercera_id;
            $newToma->tercera_id = $pa->tercera_id;
            $newToma->fecha_toma_tercera = $pa->fecha_toma_tercera;
        }
        else{
            $newToma->tercera_id = 0;
        }
        if($pa->cuarta_id>0){
            $newToma->clase_cuarta_id = $pa->clase_cuarta_id;
            $newToma->cuarta_id = $pa->cuarta_id;
            $newToma->fecha_toma_cuarta = $pa->fecha_toma_cuarta;
        }
        else{
            $newToma->cuarta_id = 0;
        }
        if($pa->quinta_id>0){
            $newToma->clase_quinta_id = $pa->clase_quinta_id;
            $newToma->quinta_id = $pa->quinta_id;
            $newToma->fecha_toma_quinta = $pa->fecha_toma_quinta;
        }
        else{
            $newToma->quinta_id = 0;
        }

        $newToma->embarazo='N';
        $newToma->laboratorio='N';
        $newToma->gestacion=0;
        $newToma->anio_registro = $fecha_anio;
        $newToma->usuariot_id =  $user;
        $this->savePreanalitica();
        $newToma->archivo = $pa->archivo;
        $newToma->save();

        if($pa->primera_id>0){
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
            $newMuestra->codigo_muestra = $codm;
            $newMuestra->codigo_secuencial = 1;
            $fechacomoentero = strtotime($pa->fecha_toma_primera);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }

        if($pa->segunda_id>0){
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
            $newMuestra->codigo_muestra = $codm;
            $newMuestra->codigo_secuencial = 2;
            $fechacomoentero = strtotime($pa->fecha_toma_segunda);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->tercera_id>0){
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
            $newMuestra->codigo_muestra = $codm;
            $newMuestra->codigo_secuencial = 3;
            $fechacomoentero = strtotime($pa->fecha_toma_tercera);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->cuarta_id>0){
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
            $newMuestra->codigo_muestra = $codm;
            $newMuestra->codigo_secuencial = 4;
            $fechacomoentero = strtotime($pa->fecha_toma_cuarta);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($pa->quinta_id>0){
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
            $newMuestra->codigo_muestra = $codm;
            $newMuestra->codigo_secuencial = 5;
            $fechacomoentero = strtotime($pa->fecha_toma_quinta);
            $anio = date("Y", $fechacomoentero)-2000;
            $mes = date("m", $fechacomoentero);
            $newMuestra->codigo_calidad = str_pad($newMuestra->codigo_muestra, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newMuestra->codigo_secuencial, 2, '0', STR_PAD_LEFT);
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        return $codm;
    }

    public function guardarmicolo(Preanaliticamico $pa, $ev){

        $absede = Sede::findOrFail($pa->sedes_id);
        $abcrn = Crn::findOrFail($pa->crns_id);
        $user = auth()->user()->id;
        $fecha_anio = date("Y");

        if($pa->paciente_id == null){ // si no se guardo un paciente, se agrega uno xxxxxx
            $newPac = Paciente::findOrFail(2869);

        }else if($pa->paciente_id == 0){
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
        $newToma = new Preanaliticamico();
        $newToma->instituciones_id = $pa->instituciones_id;
        if($pa->paciente_id == 0 || $pa->paciente_id == null ){
            $newToma->paciente_id = $newPac->id;
        }
        else{
            $newToma->paciente_id = $pa->paciente_id;
        }

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
        }
        else{
            $newToma->primera_id = 0;
        }
        if($pa->segunda_id>0){
            $newToma->clase_segunda_id = $pa->clase_segunda_id;
            $newToma->segunda_id = $pa->segunda_id;
            $newToma->fecha_toma_segunda = $pa->fecha_toma_segunda;
        }
        else{
            $newToma->segunda_id = 0;
        }
        if($pa->tercera_id>0){
            $newToma->clase_tercera_id = $pa->clase_tercera_id;
            $newToma->tercera_id = $pa->tercera_id;
            $newToma->fecha_toma_tercera = $pa->fecha_toma_tercera;
        }
        else{
            $newToma->tercera_id = 0;
        }
        if($pa->cuarta_id>0){
            $newToma->clase_cuarta_id = $pa->clase_cuarta_id;
            $newToma->cuarta_id = $pa->cuarta_id;
            $newToma->fecha_toma_cuarta = $pa->fecha_toma_cuarta;
        }
        else{
            $newToma->cuarta_id = 0;
        }
        if($pa->quinta_id>0){
            $newToma->clase_quinta_id = $pa->clase_quinta_id;
            $newToma->quinta_id = $pa->quinta_id;
            $newToma->fecha_toma_quinta = $pa->fecha_toma_quinta;
        }
        else{
            $newToma->quinta_id = 0;
        }

        $newToma->embarazo='N';
        $newToma->laboratorio='N';
        $newToma->gestacion=0;
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
            $newMuestra->preanalitica_id     = $newToma->id;
            $newMuestra->sedes_id            = $pa->sedes_id;
            $newMuestra->crns_id             = $pa->crns_id;
            $newMuestra->evento_id           = $ev;
            $newMuestra->muestra_id          = $pa->primera_id;
            $newMuestra->clase_id            = $pa->clase_primera_id;
            $newMuestra->anio_registro       = $fecha_anio;
            $newMuestra->fecha_toma          = $pa->fecha_toma_primera;
            $newMuestra->estado_muestra_id   = $pa->estado_primera_id;
            $newMuestra->observacion_muestra = $pa->observacion_primera;
            $newMuestra->codigo_externo      = $pa->cod_muestra_hosp;
            $newMuestra->codigo_muestra      = $codigo;
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

        //se agrega los datos de mico 
        $newMico = new Micobacteria();
        $newMico->pre_analitica_id = $newToma->id;

        $newMico->nombre_lote         = $pa->nombre_lote;
        $newMico->n_tubos             = $pa->n_tubos;
        $newMico->triple_empaque      = $pa->triple_empaque;
        $newMico->columnas            = $pa->columnas;
        $newMico->cultivos_puros      = $pa->cultivos_puros;
        $newMico->crecimiento         = $pa->crecimiento;
        $newMico->cultivo_sin_liquido = $pa->cultivo_sin_liquido;
        $newMico->cultivo_crecimiento = $pa->cultivo_crecimiento;
        $newMico->prueba_sensibilidad = $pa->prueba_sensibilidad;
        $newMico->tipificacion        = $pa->tipificacion;
        $newMico->responsable_recep   = $pa->responsable_recep;

        $newMico->save();

        return $codigo;
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $user = auth()->user()->id;
            $fecha_anio = date("Y");
            if($this->Preanaliticastoxico->evento_id==95){
                $codgen = $this->guardart($this->Preanaliticastoxico,95);
                $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,168);
                $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,169);
                $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,170);
                $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,171);
                $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,172);
                $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,96);
            }
            else{
                if($this->Preanaliticastoxico->evento_id==97){
                    $codgen = $this->guardart($this->Preanaliticastoxico,97);
                    
                    $this->guardardetallet($this->Preanaliticastoxico,$this->IdPreanalitica,$codgen,98);
                }
                else{

                    if($this->Preanaliticastoxico->crns_id == 1){
                        $this->guardarmicolo($this->Preanaliticastoxico,$this->Preanaliticastoxico->evento_id);
                    }else{
                        $this->guardarp($this->Preanaliticastoxico,$this->Preanaliticastoxico->evento_id);
                    }
                    
                }
            }

            DB::commit();
            $this->alert('success', 'Preanalitica agregado con éxito');
            $this->emit('renderJs');
            return redirect()->route('preanaliticamico.index');
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
            $updatePre = Preanaliticamico::findOrFail($this->Preanaliticastoxico->id);
            $updatePre->instituciones_id=$this->Preanaliticastoxico->instituciones_id;
            $updatePre->fecha_atencion=$this->Preanaliticastoxico->fecha_atencion;
            $updatePre->quien_notifica=$this->Preanaliticastoxico->quien_notifica;
            $updatePre->paciente_id=2869;

            $updatePre->observacion_primera=$this->Preanaliticastoxico->observacion_primera;

            /*
            $newPac = Paciente::findOrFail(2869);
            dd($newPac);
            $newPac->nombres = $this->Preanaliticastoxico->paciente_nombres;
            $newPac->apellidos = $this->Preanaliticastoxico->paciente_apellidos;
            $newPac->identidad = $this->Preanaliticastoxico->identidad;
            $newPac->hcu = $this->Preanaliticastoxico->identidad;
            $newPac->fechanacimiento = $this->Preanaliticastoxico->paciente_fechanac;
            $newPac->sexo_id = $this->Preanaliticastoxico->paciente_sexo;
            $newPac->direccion = $this->Preanaliticastoxico->paciente_direccion;
            $newPac->telefono = $this->Preanaliticastoxico->paciente_telefono;
            $newPac->canton_id = $this->Preanaliticastoxico->paciente_ubicacion;
            $prov = Canton::findOrFail(75);
            $newPac->provincia_id = $prov->provincia_id;
            $newPac->nacionalidad_id = $this->Preanaliticastoxico->paciente_nacionalidad;
            $newPac->update();
            */

            //se agrega los datos de mico 
            $newMico = Micobacteria::where('pre_analitica_id', $this->Preanaliticastoxico->id)->first();
            //$newMico->pre_analitica_id = $newToma->id;

            $newMico->nombre_lote         = $this->Preanaliticastoxico->nombre_lote;
            $newMico->n_tubos             = $this->Preanaliticastoxico->n_tubos;
            $newMico->triple_empaque      = $this->Preanaliticastoxico->triple_empaque;
            $newMico->columnas            = $this->Preanaliticastoxico->columnas;
            $newMico->cultivos_puros      = $this->Preanaliticastoxico->cultivos_puros;
            $newMico->crecimiento         = $this->Preanaliticastoxico->crecimiento;
            $newMico->cultivo_sin_liquido = $this->Preanaliticastoxico->cultivo_sin_liquido;
            $newMico->cultivo_crecimiento = $this->Preanaliticastoxico->cultivo_crecimiento;
            $newMico->prueba_sensibilidad = $this->Preanaliticastoxico->prueba_sensibilidad;
            $newMico->tipificacion        = $this->Preanaliticastoxico->tipificacion;
            $newMico->responsable_recep   = $this->Preanaliticastoxico->responsable_recep;

            $newMico->save();

            $updatePre->probable_infeccion=$this->Preanaliticastoxico->probable_infeccion;
            $updatePre->fecha_sintomas=$this->Preanaliticastoxico->fecha_sintomas;
            $updatePre->fecha_recepcion=$this->Preanaliticastoxico->fecha_recepcion;
            $updatePre->embarazo=$this->Preanaliticastoxico->embarazo;
            $updatePre->gestacion=$this->Preanaliticastoxico->gestacion;
            $updatePre->laboratorio=$this->Preanaliticastoxico->laboratorio;
            $updatePre->nombre_laboratorio=$this->Preanaliticastoxico->nombre_laboratorio;

            $updatePre->sedes_id=$this->Preanaliticastoxico->sedes_id;
            $updatePre->crns_id=$this->Preanaliticastoxico->crns_id;
            $updatePre->evento_id=$this->Preanaliticastoxico->evento_id;
            $updatePre->anio_registro=$this->Preanaliticastoxico->anio_registro;

            $updatePre->primera_id = $this->Preanaliticastoxico->primera_id;
            $updatePre->clase_primera_id = $this->Preanaliticastoxico->clase_primera_id;
            $updatePre->primera_id = $this->Preanaliticastoxico->primera_id;
            $updatePre->fecha_toma_primera = $this->Preanaliticastoxico->fecha_toma_primera;
            $updatePre->observacion_primera = $this->Preanaliticastoxico->observacion_primera;

            $updatePre->segunda_id = $this->Preanaliticastoxico->segunda_id;
            $updatePre->clase_segunda_id = $this->Preanaliticastoxico->clase_segunda_id;
            $updatePre->segunda_id = $this->Preanaliticastoxico->segunda_id;
            $updatePre->fecha_toma_segunda = $this->Preanaliticastoxico->fecha_toma_segunda;
            $updatePre->observacion_segunda = $this->Preanaliticastoxico->observacion_segunda;

            $updatePre->tercera_id = $this->Preanaliticastoxico->tercera_id;
            $updatePre->clase_tercera_id = $this->Preanaliticastoxico->clase_tercera_id;
            $updatePre->tercera_id = $this->Preanaliticastoxico->tercera_id;
            $updatePre->fecha_toma_tercera = $this->Preanaliticastoxico->fecha_toma_tercera;
            $updatePre->observacion_tercera = $this->Preanaliticastoxico->observacion_tercera;

            $updatePre->cuarta_id = $this->Preanaliticastoxico->cuarta_id;
            $updatePre->clase_cuarta_id = $this->Preanaliticastoxico->clase_cuarta_id;
            $updatePre->cuarta_id = $this->Preanaliticastoxico->cuarta_id;
            $updatePre->fecha_toma_cuarta = $this->Preanaliticastoxico->fecha_toma_cuarta;
            $updatePre->observacion_cuarta = $this->Preanaliticastoxico->observacion_cuarta;

            $updatePre->quinta_id = $this->Preanaliticastoxico->quinta_id;
            $updatePre->clase_quinta_id = $this->Preanaliticastoxico->clase_quinta_id;
            $updatePre->quinta_id = $this->Preanaliticastoxico->quinta_id;
            $updatePre->fecha_toma_quinta = $this->Preanaliticastoxico->fecha_toma_quinta;
            $updatePre->observacion_quinta = $this->Preanaliticastoxico->observacion_quinta;
            $this->savePreanalitica();
            $updatePre->archivo = $this->Preanaliticastoxico->archivo;
            $updatePre->update();

            /*
            $analiticaUpdate = Analitica::where('estado','=','A')
                ->where('preanalitica_id','=',$this->Preanaliticastoxico->id)
                ->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',1)->first();
            
            $analiticaUpdate->codigo_externo = $this->Preanaliticastoxico->cod_muestra_hosp;
            $analiticaUpdate->save();
            */

            $tipogenera = $this->tipo_generacion($this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
            if($tipogenera==1){
                $codigo = $this->sgte_codigomuestra($this->Preanaliticastoxico->anio_registro,$this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
            }

            $muestra = 0;
            if($this->Preanaliticastoxico->primera_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',1)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticastoxico->id;
                    $newMuestra->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticastoxico->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticastoxico->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticastoxico->primera_id;
                    $newMuestra->clase_id = $this->Preanaliticastoxico->clase_primera_id;
                    $newMuestra->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticastoxico->fecha_toma_primera;
                    $newMuestra->estado_muestra_id = $this->Preanaliticastoxico->estado_primera_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticastoxico->observacion_primera;
                    $newMuestra->codigo_muestra = $codigo;
                    $newMuestra->codigo_externo = $this->Preanaliticastoxico->cod_muestra_hosp;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 1;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticastoxico->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',1)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticastoxico->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticastoxico->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticastoxico->primera_id;
                    $updateAnalitica->clase_id = $this->Preanaliticastoxico->clase_primera_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticastoxico->fecha_toma_primera;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticastoxico->estado_primera_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticastoxico->observacion_primera;
                    $updateAnalitica->codigo_externo = $this->Preanaliticastoxico->cod_muestra_hosp;
                    $muestra = $updateAnalitica->codigo_muestra;
                    $updateAnalitica->codigo_secuencial = 1;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticastoxico->segunda_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',2)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticastoxico->id;
                    $newMuestra->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticastoxico->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticastoxico->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticastoxico->segunda_id;
                    $newMuestra->clase_id = $this->Preanaliticastoxico->clase_segunda_id;
                    $newMuestra->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticastoxico->fecha_toma_segunda;
                    $newMuestra->estado_muestra_id = $this->Preanaliticastoxico->estado_segunda_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticastoxico->observacion_segunda;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 2;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticastoxico->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',2)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticastoxico->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticastoxico->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticastoxico->segunda_id;
                    $updateAnalitica->clase_id = $this->Preanaliticastoxico->clase_segunda_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticastoxico->fecha_toma_segunda;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticastoxico->estado_segunda_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticastoxico->observacion_segunda;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 2;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticastoxico->tercera_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',3)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticastoxico->id;
                    $newMuestra->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticastoxico->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticastoxico->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticastoxico->tercera_id;
                    $newMuestra->clase_id = $this->Preanaliticastoxico->clase_tercera_id;
                    $newMuestra->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticastoxico->fecha_toma_tercera;
                    $newMuestra->estado_muestra_id = $this->Preanaliticastoxico->estado_tercera_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticastoxico->observacion_tercera;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 3;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticastoxico->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',3)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticastoxico->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticastoxico->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticastoxico->tercera_id;
                    $updateAnalitica->clase_id = $this->Preanaliticastoxico->clase_tercera_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticastoxico->fecha_toma_tercera;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticastoxico->estado_tercera_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticastoxico->observacion_tercera;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 3;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticastoxico->cuarta_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',4)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticastoxico->id;
                    $newMuestra->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticastoxico->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticastoxico->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticastoxico->cuarta_id;
                    $newMuestra->clase_id = $this->Preanaliticastoxico->clase_cuarta_id;
                    $newMuestra->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticastoxico->fecha_toma_cuarta;
                    $newMuestra->estado_muestra_id = $this->Preanaliticastoxico->estado_cuarta_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticastoxico->observacion_cuarta;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 4;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticastoxico->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',4)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticastoxico->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticastoxico->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticastoxico->cuarta_id;
                    $updateAnalitica->clase_id = $this->Preanaliticastoxico->clase_cuarta_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticastoxico->fecha_toma_cuarta;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticastoxico->estado_cuarta_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticastoxico->observacion_cuarta;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 4;
                    $updateAnalitica->update();
                }
            }

            if($this->Preanaliticastoxico->quinta_id>0){
                $control = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',5)->count();
                if($control==0){
                    if($tipogenera==2){
                        $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticastoxico->sedes_id,$this->Preanaliticastoxico->crns_id);
                    }
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Preanaliticastoxico->id;
                    $newMuestra->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $newMuestra->crns_id = $this->Preanaliticastoxico->crns_id;
                    $newMuestra->evento_id = $this->Preanaliticastoxico->evento_id;
                    $newMuestra->muestra_id = $this->Preanaliticastoxico->quinta_id;
                    $newMuestra->clase_id = $this->Preanaliticastoxico->clase_quinta_id;
                    $newMuestra->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $newMuestra->fecha_toma = $this->Preanaliticastoxico->fecha_toma_quinta;
                    $newMuestra->estado_muestra_id = $this->Preanaliticastoxico->estado_quinta_id;
                    $newMuestra->observacion_muestra = $this->Preanaliticastoxico->observacion_quinta;
                    $newMuestra->codigo_muestra = $muestra;
                    if($tipogenera==1){
                        $newMuestra->codigo_secuencial = 5;
                    }
                    else{
                        $newMuestra->codigo_secuencial = $codigo;
                    }
                    $newMuestra->usuariot_id = $this->Preanaliticastoxico->usuariot_id;
                    $newMuestra->save();
                }
                else{
                    $updateAnalitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$this->Preanaliticastoxico->id)->where('anio_registro','=',$this->Preanaliticastoxico->anio_registro)->where('codigo_secuencial','=',4)->first();

                    $updateAnalitica->sedes_id = $this->Preanaliticastoxico->sedes_id;
                    $updateAnalitica->crns_id = $this->Preanaliticastoxico->crns_id;
                    $updateAnalitica->evento_id = $this->Preanaliticastoxico->evento_id;
                    $updateAnalitica->muestra_id = $this->Preanaliticastoxico->quinta_id;
                    $updateAnalitica->clase_id = $this->Preanaliticastoxico->clase_quinta_id;
                    $updateAnalitica->anio_registro = $this->Preanaliticastoxico->anio_registro;
                    $updateAnalitica->fecha_toma = $this->Preanaliticastoxico->fecha_toma_quinta;
                    $updateAnalitica->estado_muestra_id = $this->Preanaliticastoxico->estado_quinta_id;
                    $updateAnalitica->observacion_muestra = $this->Preanaliticastoxico->observacion_quinta;
                    $updateAnalitica->codigo_muestra = $muestra;
                    $updateAnalitica->codigo_secuencial = 5;
                    $updateAnalitica->update();
                }
            }

            DB::commit();
            $this->alert('success', 'Preanalitica actualizado con éxito');
            $this->emit('closeModal');

            if($this->Preanaliticastoxico->crns_id == 1){
                return redirect()->route('preanaliticamico.index');
            }else{
                return redirect()->route('preanalitica.index');
            }
            
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
            if(Storage::exists($this->Preanaliticastoxico->archivo)){
                Storage::delete($this->Preanaliticastoxico->archivo);
            }

            $path = $this->PreanaliticaTmp->store('public/fichas/crns');
            $path = substr($path, 7);
            $this->Preanaliticastoxico->archivo = $path;

        }
    }

    public function removePreanalitica(){
        if($this->Preanaliticastoxico->archivo){
            if(Storage::exists($this->Preanaliticastoxico->archivo)){
                Storage::delete($this->Preanaliticastoxico->archivo);
            }

            $this->Preanaliticastoxico->archivo = null;
            $this->Preanaliticass->update();
        }
        $this->reset('PreanaliticaTmp');
        $this->alert('success', 'Ficha digitalizada eliminada con exito');
    }
}
