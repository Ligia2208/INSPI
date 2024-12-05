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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

use Jantinnerezo\LivewireAlert\LivewireAlert;

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


    protected $listeners = ['render'];

    protected function rules()
    {

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

            'Preanaliticas.embarazo' => 'sometimes|numeric',
            'Preanaliticas.gestacion' => 'sometimes|numeric',
            'Preanaliticas.laboratorio' => 'sometimes|numeric',
            'Preanaliticas.nombre_laboratorio' => 'sometimes|max:100',

            'Preanaliticas.sedes_id' => 'required|numeric',
            'Preanaliticas.crns_id' => 'required|numeric',
            'Preanaliticas.evento_id' => 'required|numeric',

            'Preanaliticas.primera_id' => 'required|numeric',
            'Preanaliticas.fecha_toma_primera' => 'required|max:10',
            'Preanaliticas.segunda_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_segunda' => 'sometimes|max:10',
            'Preanaliticas.tercera_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_tercera' => 'sometimes|max:10',
            'Preanaliticas.cuarta_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_cuarta' => 'sometimes|max:10',
            'Preanaliticas.quinta_id' => 'sometimes|numeric',
            'Preanaliticas.fecha_toma_quinta' => 'sometimes|max:10',
        ];
    }

    public function mount(Preanalitica $Preanalitica, $method){
        $this->Preanaliticas = $Preanalitica;
        $this->method = $method;
        $this->Preanaliticas->embarazo = 2;
        $this->Preanaliticas->laboratorio = 2;
        $this->Preanaliticas->gestacion = 0;
        $this->Preanaliticas->segunda_id = 0;
        $this->Preanaliticas->tercera_id = 0;
        $this->Preanaliticas->cuarta_id = 0;
        $this->Preanaliticas->quinta_id = 0;
    }

    public function updatedchangedInstitucion($institucion_id){
        $instSelected = Institucion::findorFail($institucion_id);
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
            $this->Preanaliticas->paciente_id = $pacSelected->id;
            $this->Preanaliticas->paciente_sexo = $pacSelected->sexo_id;
            $this->Preanaliticas->paciente_nombres = $pacSelected->nombres;
            $this->Preanaliticas->paciente_apellidos = $pacSelected->apellidos;
            $this->Preanaliticas->paciente_fechanac = $pacSelected->fechanacimiento;
            $this->Preanaliticas->paciente_direccion = $pacSelected->direccion;
            $this->Preanaliticas->paciente_telefono = $pacSelected->telefono;
            $this->Preanaliticas->paciente_ubicacion = $pacSelected->provincia->descripcion.' - '.$pacSelected->canton->descripcion;
            $this->Preanaliticas->paciente_nacionalidad = $pacSelected->nacionalidad->nacionalidad;
        }
        else{
            $this->Preanaliticas->paciente_id = 0;
            $this->Preanaliticas->paciente_nombres = '';
            $this->Preanaliticas->paciente_apellidos = '';
            $this->Preanaliticas->paciente_direccion = '';
            $this->Preanaliticas->paciente_telefono = '';
            $this->Preanaliticas->paciente_ubicacion = '';
            $this->Preanaliticas->paciente_nacionalidad = '';
        }
        $this->emit('renderJs');
    }

    public function render()
    {
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $sexos = Sexo::orderBy('id', 'asc')->cursor();
        $muestras = Muestra::orderBy('id', 'asc')->cursor();
        $instituciones = Institucion::where('estado','=','A')->orderBy('id','asc')->cursor();

        return view('livewire.centrosreferencia.preanalitica.form', compact('sedes','sexos','muestras','instituciones'));
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
        $user = auth()->user()->id;
        $fecha_anio = date("Y");
        $newToma = new Preanalitica();
        $newToma->instituciones_id = $this->Preanaliticas->instituciones_id;
        $newToma->paciente_id = $this->Preanaliticas->paciente_id;
        $newToma->fecha_atencion = $this->Preanaliticas->fecha_atencion;
        $newToma->quien_notifica = $this->Preanaliticas->quien_notifica;
        $newToma->probable_infeccion = $this->Preanaliticas->probable_infeccion;
        $newToma->fecha_sintomas = $this->Preanaliticas->fecha_sintomas;
        if ($this->Preanaliticas->embarazo==1){
            $newToma->embarazo = 'S';
        }
        else{
            $newToma->embarazo = 'N';
        }

        $newToma->gestacion = $this->Preanaliticas->gestacion;
        if ($this->Preanaliticas->laboratorio==1){
            $newToma->laboratorio = 'S';
        }
        else{
            $newToma->laboratorio = 'N';
        }

        $newToma->nombre_laboratorio = $this->Preanaliticas->nombre_laboratorio;
        $newToma->sedes_id = $this->Preanaliticas->sedes_id;
        $newToma->crns_id = $this->Preanaliticas->crns_id;
        $newToma->evento_id = $this->Preanaliticas->evento_id;
        if($this->Preanaliticas->primera_id>0){
            $newToma->primera_id = $this->Preanaliticas->primera_id;
            $newToma->fecha_toma_primera = $this->Preanaliticas->fecha_toma_primera;
        }
        else{
            $newToma->primera_id = 0;
        }
        if($this->Preanaliticas->segunda_id>0){
            $newToma->segunda_id = $this->Preanaliticas->segunda_id;
            $newToma->fecha_toma_segunda = $this->Preanaliticas->fecha_toma_segunda;
        }
        else{
            $newToma->segunda_id = 0;
        }
        if($this->Preanaliticas->tercera_id>0){
            $newToma->tercera_id = $this->Preanaliticas->tercera_id;
            $newToma->fecha_toma_tercera = $this->Preanaliticas->fecha_toma_tercera;
        }
        else{
            $newToma->tercera_id = 0;
        }
        if($this->Preanaliticas->cuarta_id>0){
            $newToma->cuarta_id = $this->Preanaliticas->cuarta_id;
            $newToma->fecha_toma_cuarta = $this->Preanaliticas->fecha_toma_cuarta;
        }
        else{
            $newToma->cuarta_id = 0;
        }
        if($this->Preanaliticas->quinta_id>0){
            $newToma->quinta_id = $this->Preanaliticas->quinta_id;
            $newToma->fecha_toma_quinta = $this->Preanaliticas->fecha_toma_quinta;
        }
        else{
            $newToma->quinta_id = 0;
        }
        $newToma->anio_registro = $fecha_anio;
        $newToma->usuario_id =  $user;
        $newToma->save();

        if($this->Preanaliticas->primera_id>0){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
            $newMuestra->crns_id = $this->Preanaliticas->crns_id;
            $newMuestra->evento_id = $this->Preanaliticas->evento_id;
            $newMuestra->muestra_id = $this->Preanaliticas->primera_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_primera;
            $newMuestra->codigo_muestra = $codigo;
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($this->Preanaliticas->segunda_id>0){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
            $newMuestra->crns_id = $this->Preanaliticas->crns_id;
            $newMuestra->evento_id = $this->Preanaliticas->evento_id;
            $newMuestra->muestra_id = $this->Preanaliticas->segunda_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_segunda;
            $newMuestra->codigo_muestra = $codigo;
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($this->Preanaliticas->tercera_id>0){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
            $newMuestra->crns_id = $this->Preanaliticas->crns_id;
            $newMuestra->evento_id = $this->Preanaliticas->evento_id;
            $newMuestra->muestra_id = $this->Preanaliticas->tercera_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_tercera;
            $newMuestra->codigo_muestra = $codigo;
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($this->Preanaliticas->cuarta_id>0){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
            $newMuestra->crns_id = $this->Preanaliticas->crns_id;
            $newMuestra->evento_id = $this->Preanaliticas->evento_id;
            $newMuestra->muestra_id = $this->Preanaliticas->cuarta_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_cuarta;
            $newMuestra->codigo_muestra = $codigo;
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        if($this->Preanaliticas->quinta_id>0){
            $codigo = $this->sgte_codigomuestra($fecha_anio,$this->Preanaliticas->sedes_id,$this->Preanaliticas->crns_id);
            $newMuestra = new Analitica();
            $newMuestra->preanalitica_id = $newToma->id;
            $newMuestra->sedes_id = $this->Preanaliticas->sedes_id;
            $newMuestra->crns_id = $this->Preanaliticas->crns_id;
            $newMuestra->evento_id = $this->Preanaliticas->evento_id;
            $newMuestra->muestra_id = $this->Preanaliticas->quinta_id;
            $newMuestra->anio_registro = $fecha_anio;
            $newMuestra->fecha_toma = $this->Preanaliticas->fecha_toma_quinta;
            $newMuestra->codigo_muestra = $codigo;
            $newMuestra->usuariot_id = $user;
            $newMuestra->save();
        }
        $this->alert('success', 'Preanalitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('preanalitica.index');

    }

    public function sgte_codigomuestra($anio, $sede, $crn){
        $max = Analitica::where('estado','=','A')->where('anio_registro','=',$anio)->where('sedes_id','=',$sede)->where('crns_id','=',$crn)->max('codigo_muestra');
        return $max+1;
    }

    public function update(){
        $this->validate();
        $this->Preanaliticas->update();
        $this->alert('success', 'Preanalitica actualizado con éxito');
        $this->emit('closeModal');
        return redirect()->route('preanalitica.index');
    }

}
