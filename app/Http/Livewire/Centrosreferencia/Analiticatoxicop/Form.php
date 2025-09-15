<?php

namespace App\Http\Livewire\Centrosreferencia\Analiticatoxicop;

use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analiticatoxico;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Muestra;
use App\Models\CentrosReferencia\Clase;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Sexo;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use App\Models\CentrosReferencia\Reporte;
use App\Models\CentrosReferencia\Tecnica;
use App\Models\CentrosReferencia\Tipoparametros;
use App\Models\CentrosReferencia\Estadomuestra;
use App\Models\CentrosReferencia\Unidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;
use DB;
use Datetime;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $method;

    //Tools
    public $Analiticastoxico;
    public $eventos;
    public $tecnicas;
    public $cantones;
    public $reportes;
    public $crns;
    public $selectedSede = null;
    public $selectedCrn = null;
    public $selectedProvincia = null;
    public $AnaliticaTmp;

    protected $listeners = ['render'];

    protected function rules()
    {

        return [
            'Analiticastoxico.sedes_id' => 'required|numeric',
            'Analiticastoxico.crns_id' => 'required|numeric',
            'Analiticastoxico.muestra_id' => 'required|numeric',
            'Analiticastoxico.clase_id' => 'required|numeric',
            'Analiticastoxico.estado_muestra_id' => 'required|numeric',
            'Analiticastoxico.codigo_muestra' => 'required|numeric',
            'Analiticastoxico.codigo_secuencial' => 'required|numeric',
            'Analiticastoxico.codigo_externo' => 'sometimes|max:25',
            'Analiticastoxico.fecha_toma' => 'required|max:10',
            'Analiticastoxico.anio_registro' => 'required|max:10',
            'Analiticastoxico.fecha_llegada_lab' => 'required|max:10',
            'Analiticastoxico.fecha_procesamiento' => 'required|max:10',
            'Analiticastoxico.evento_id' => 'required|numeric',
            'Analiticastoxico.tecnica_id' => 'required|numeric',
            'Analiticastoxico.resultado_id' => 'required|numeric',
            'Analiticastoxico.descripcion' => 'sometimes|max:2000',
            'Analiticastoxico.identificado' => 'sometimes|max:200',
            'Analiticastoxico.recomendacion_bacterio' => 'sometimes|max:200',
            'Analiticastoxico.carga_viral' => 'sometimes|numeric',
            'Analiticastoxico.unidades_id' => 'sometimes|numeric',
            'Analiticastoxico.recomendacion_inmuno' => 'sometimes|max:200',

            'Analiticastoxico.tecnica_segunda_id' => 'sometimes|numeric',
            'Analiticastoxico.resultado_segunda_id' => 'sometimes|numeric',
            'Analiticastoxico.identificado_segunda' => 'sometimes|max:200',

            'Analiticastoxico.tecnica_tercera_id' => 'sometimes|numeric',
            'Analiticastoxico.resultado_tercera_id' => 'sometimes|numeric',
            'Analiticastoxico.identificado_tercera' => 'sometimes|max:200',

            'Analiticastoxico.tecnica_cuarta_id' => 'sometimes|numeric',
            'Analiticastoxico.resultado_cuarta_id' => 'sometimes|numeric',
            'Analiticastoxico.identificado_cuarta' => 'sometimes|max:200',

            'Analiticastoxico.tecnica_quinta_id' => 'sometimes|numeric',
            'Analiticastoxico.resultado_quinta_id' => 'sometimes|numeric',
            'Analiticastoxico.identificado_quinta' => 'sometimes|max:200',

            'Analiticastoxico.tecnica_sexta_id' => 'sometimes|numeric',
            'Analiticastoxico.resultado_sexta_id' => 'sometimes|numeric',
            'Analiticastoxico.identificado_sexta' => 'sometimes|max:200',

            'Analiticastoxico.germenaislado_mico' => 'sometimes|max:80',
            'Analiticastoxico.directokoh_mico' => 'sometimes|max:80',
            'Analiticastoxico.directoplaca_mico' => 'sometimes|max:80',
            'Analiticastoxico.tintachina_mico' => 'sometimes|max:80',
            'Analiticastoxico.antibiogramamico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicounomico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimuno_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusionuno_mico' => 'sometimes|max:40',
            'Analiticastoxico.escalaunomico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicodosmico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimdos_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusiondos_mico' => 'sometimes|max:40',
            'Analiticastoxico.escaladosmico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicotresmico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimtres_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusiontres_mico' => 'sometimes|max:40',
            'Analiticastoxico.escalatresmico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicocuatromico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimcuatro_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusioncuatro_mico' => 'sometimes|max:40',
            'Analiticastoxico.escalacuatromico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicocincomico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimcinco_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusioncinco_mico' => 'sometimes|max:40',
            'Analiticastoxico.escalacincomico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicoseismico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimseis_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusionseis_mico' => 'sometimes|max:40',
            'Analiticastoxico.escalaseismico_id' => 'sometimes|numeric',

            'Analiticastoxico.fungicosietemico_id' => 'sometimes|numeric',
            'Analiticastoxico.cimsiete_mico' => 'sometimes|max:15',
            'Analiticastoxico.difusionsiete_mico' => 'sometimes|max:40',
            'Analiticastoxico.escalasietemico_id' => 'sometimes|numeric',

            'Analiticastoxico.deteccionunomico_id' => 'sometimes|numeric',
            'Analiticastoxico.interpretaunomico_id' => 'sometimes|numeric',
            'Analiticastoxico.detecciondosmico_id' => 'sometimes|numeric',
            'Analiticastoxico.interpretadosmico_id' => 'sometimes|numeric',
            'Analiticastoxico.detecciontresmico_id' => 'sometimes|numeric',
            'Analiticastoxico.interpretatresmico_id' => 'sometimes|numeric',
            'Analiticastoxico.deteccioncuatromico_id' => 'sometimes|numeric',
            'Analiticastoxico.interpretacuatromico_id' => 'sometimes|numeric',

            'Analiticastoxico.observacioninvestiga' => 'sometimes|max:250',

            'Analiticastoxico.antibioticopsunobacte_id' => 'sometimes|numeric',
            'Analiticastoxico.halopsuno_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalapsunobacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticopsdosbacte_id' => 'sometimes|numeric',
            'Analiticastoxico.halopsdos_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalapsdosbacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticopstresbacte_id' => 'sometimes|numeric',
            'Analiticastoxico.halopstres_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalapstresbacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticopscuatrobacte_id' => 'sometimes|numeric',
            'Analiticastoxico.halopscuatro_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalapscuatrobacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticopscincobacte_id' => 'sometimes|numeric',
            'Analiticastoxico.halopscinco_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalapscincobacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticopsseisbacte_id' => 'sometimes|numeric',
            'Analiticastoxico.halopsseis_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalapsseisbacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticomdunobacte_id' => 'sometimes|numeric',
            'Analiticastoxico.cimmduno_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalamdunobacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticomddosbacte_id' => 'sometimes|numeric',
            'Analiticastoxico.cimmddos_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalamddosbacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticomdtresbacte_id' => 'sometimes|numeric',
            'Analiticastoxico.cimmdtres_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalamdtresbacte_id' => 'sometimes|numeric',

            'Analiticastoxico.antibioticomdcuatrobacte_id' => 'sometimes|numeric',
            'Analiticastoxico.cimmdcuatro_bacte' => 'sometimes|numeric',
            'Analiticastoxico.escalamdcuatrobacte_id' => 'sometimes|numeric',
        ];
    }

    public function mount(Analiticatoxico $Analiticastoxico, $method){
        $this->Analiticastoxico = $Analiticastoxico;
        $this->method = $method;

        if($this->Analiticastoxico->tecnica_segunda_id == 0){
            $this->Analiticastoxico->tecnica_segunda_id = 0;
            $this->Analiticastoxico->resultado_segunda_id = 0;
        }

        if($this->Analiticastoxico->tecnica_tercera_id == 0){
            $this->Analiticastoxico->tecnica_tercera_id = 0;
            $this->Analiticastoxico->resultado_tercera_id = 0;
        }

        if($this->Analiticastoxico->tecnica_cuarta_id == 0){
            $this->Analiticastoxico->tecnica_cuarta_id = 0;
            $this->Analiticastoxico->resultado_cuarta_id = 0;
        }

        if($this->Analiticastoxico->deteccionunomico_id == 0){
            $this->Analiticastoxico->deteccionunomico_id = 0;
            $this->Analiticastoxico->interpretaunomico_id = 0;
        }

        if($this->Analiticastoxico->detecciondosmico_id == 0){
            $this->Analiticastoxico->detecciondosmico_id = 0;
            $this->Analiticastoxico->interpretadosmico_id = 0;
        }

        if($this->Analiticastoxico->detecciontresmico_id == 0){
            $this->Analiticastoxico->detecciontresmico_id = 0;
            $this->Analiticastoxico->interpretatresmico_id = 0;
        }

        if($this->Analiticastoxico->deteccioncuatromico_id == 0){
            $this->Analiticastoxico->deteccioncuatromico_id = 0;
            $this->Analiticastoxico->interpretacuatromico_id = 0;
        }

        if($this->Analiticastoxico->fungicounomico_id == 0){
            $this->Analiticastoxico->fungicounomico_id = 0;
            $this->Analiticastoxico->escalaunomico_id = 0;
        }

        if($this->Analiticastoxico->fungicodosmico_id == 0){
            $this->Analiticastoxico->fungicodosmico_id = 0;
            $this->Analiticastoxico->escaladosmico_id = 0;
        }

        if($this->Analiticastoxico->fungicotresmico_id == 0){
            $this->Analiticastoxico->fungicotresmico_id = 0;
            $this->Analiticastoxico->escalatresmico_id = 0;
        }

        if($this->Analiticastoxico->fungicocuatromico_id == 0){
            $this->Analiticastoxico->fungicocuatromico_id = 0;
            $this->Analiticastoxico->escalacuatromico_id = 0;
        }

        if($this->Analiticastoxico->fungicocincomico_id == 0){
            $this->Analiticastoxico->fungicocincomico_id = 0;
            $this->Analiticastoxico->escalacincomico_id = 0;
        }

        if($this->Analiticastoxico->fungicoseismico_id == 0){
            $this->Analiticastoxico->fungicoseismico_id = 0;
            $this->Analiticastoxico->escalaseismico_id = 0;
        }

        if($this->Analiticastoxico->fungicosietemico_id == 0){
            $this->Analiticastoxico->fungicosietemico_id = 0;
            $this->Analiticastoxico->escalasietemico_id = 0;
        }

        if($this->Analiticastoxico->antibioticopsunobacte_id == 0){
            $this->Analiticastoxico->antibioticopsunobacte_id = 0;
            $this->Analiticastoxico->halopsuno_bacte = 0;
            $this->Analiticastoxico->escalapsunobacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticopsdosbacte_id == 0){
            $this->Analiticastoxico->antibioticopsdosbacte_id = 0;
            $this->Analiticastoxico->halopsdos_bacte = 0;
            $this->Analiticastoxico->escalapsdosbacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticopstresbacte_id == 0){
            $this->Analiticastoxico->antibioticopstresbacte_id = 0;
            $this->Analiticastoxico->halopstres_bacte = 0;
            $this->Analiticastoxico->escalapstresbacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticopscuatrobacte_id == 0){
            $this->Analiticastoxico->antibioticopscuatrobacte_id = 0;
            $this->Analiticastoxico->halopscuatro_bacte = 0;
            $this->Analiticastoxico->escalapscuatroacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticopscincobacte_id == 0){
            $this->Analiticastoxico->antibioticopscincobacte_id = 0;
            $this->Analiticastoxico->halopscinco_bacte = 0;
            $this->Analiticastoxico->escalapscincobacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticopsseisbacte_id == 0){
            $this->Analiticastoxico->antibioticopsseisbacte_id = 0;
            $this->Analiticastoxico->halopsseis_bacte = 0;
            $this->Analiticastoxico->escalapsseisbacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticomdunobacte_id == 0){
            $this->Analiticastoxico->antibioticomdunobacte_id = 0;
            $this->Analiticastoxico->cimmduno_bacte = 0;
            $this->Analiticastoxico->escalamdunobacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticomddosbacte_id == 0){
            $this->Analiticastoxico->antibioticomddosbacte_id = 0;
            $this->Analiticastoxico->cimmddos_bacte = 0;
            $this->Analiticastoxico->escalamddosbacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticomdtresbacte_id == 0){
            $this->Analiticastoxico->antibioticomdtresbacte_id = 0;
            $this->Analiticastoxico->cimmdtres_bacte = 0;
            $this->Analiticastoxico->escalamdtresbacte_id = 0;

        }

        if($this->Analiticastoxico->antibioticomdcuatrobacte_id == 0){
            $this->Analiticastoxico->antibioticomdcuatrobacte_id = 0;
            $this->Analiticastoxico->cimmdcuatro_bacte = 0;
            $this->Analiticastoxico->escalamdcuatrobacte_id = 0;

        }

        if($method=='update'){
            $config = SedeCrn::where('sedes_id','=',$this->Analiticastoxico->sedes_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
            $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$this->Analiticastoxico->crns_id)->orderBy('id', 'asc')->get();
            $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$this->Analiticastoxico->crns_id)->orderBy('id', 'asc')->get();
            $this->eventos = Evento::whereIn('estado',['A','M'])->where('crns_id','=',$this->Analiticastoxico->crns_id)->orderBy('id', 'asc')->get();

        }

    }

    public function updatedselectedSede($sede_id){
        $config = SedeCrn::where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrn($crns_id){
        $this->eventos = Evento::whereIn('estado',['A','M'])->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedProvincia($provincia_id){
        $this->cantones = Canton::where('provincia_id','=',$provincia_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function render()
    {
        $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $muestras = Muestra::where('estado','=','A')->orderBy('id','asc')->cursor();
        $preanalitica = Preanalitica::findOrFail($this->Analiticastoxico->preanalitica_id);
        $estados = Estadomuestra::orderBy('id', 'asc')->cursor();
        $unidades = Unidades::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $clases = Clase::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $instituciones = Institucion::where('estado','=','A')->orderBy('id','asc')->cursor();
        $paramicrobianos = Tipoparametros::where('estado','=','A')->where('crns_id','=',6)->where('tipo','=','Antimicrobianos')->orderBy('id','asc')->cursor();
        $paradifusion = Tipoparametros::where('estado','=','A')->where('crns_id','=',6)->where('tipo','=','Inmunodifusion')->orderBy('id','asc')->cursor();
        $parabiograma = Tipoparametros::where('estado','=','A')->where('crns_id','=',6)->where('tipo','=','Antibiograma')->orderBy('id','asc')->cursor();
        $bacteantibioticomic = Tipoparametros::where('estado','=','A')->where('crns_id','=',3)->where('tipo','=','AntibioticoMIC')->orderBy('id','asc')->cursor();
        $bacteantibioticokb = Tipoparametros::where('estado','=','A')->where('crns_id','=',3)->where('tipo','=','AntibioticoKB')->orderBy('id','asc')->cursor();
        return view('livewire.centrosreferencia.analiticatoxicop.form', compact('sedes','muestras','instituciones','paramicrobianos','paradifusion','parabiograma','bacteantibioticomic','bacteantibioticokb','preanalitica','estados','unidades','clases'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticastoxico->fecha_resultado = date();
        $this->Analiticastoxico->usuarior_id = $user;
        $this->saveAnalitica();
        $this->Analiticastoxico->save();
        $this->alert('success', 'Analitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('analiticatoxicop.index');

    }

    public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $control = 0;
            $user = auth()->user()->id;
            $this->Analiticastoxico->fecha_resultado = date("Y-m-d");
            $this->Analiticastoxico->usuarior_id = $user;
            $this->saveAnalitica();
            if($this->Analiticastoxico->tecnica_segunda_id==0){
                $this->Analiticastoxico->tecnica_segunda_id=0;
                $this->Analiticastoxico->resultado_segunda_id=0;
            }
            if($this->Analiticastoxico->tecnica_tercera_id==0){
                $this->Analiticastoxico->tecnica_tercera_id=0;
                $this->Analiticastoxico->resultado_tercera_id=0;
            }
            if($this->Analiticastoxico->tecnica_cuarta_id==0){
                $this->Analiticastoxico->tecnica_cuarta_id=0;
                $this->Analiticastoxico->resultado_cuarta_id=0;
            }
            $this->Analiticastoxico->update();

            if($this->Analiticastoxico->tecnica_segunda_id>0){
                $newMuestra = new Analiticatoxico();
                $newMuestra->preanalitica_id = $this->Analiticastoxico->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticastoxico->sedes_id;
                $newMuestra->crns_id = $this->Analiticastoxico->crns_id;
                $newMuestra->evento_id = $this->Analiticastoxico->evento_id;
                $newMuestra->muestra_id = $this->Analiticastoxico->muestra_id;
                $newMuestra->clase_id = $this->Analiticastoxico->clase_id;
                $newMuestra->estado_muestra_id = $this->Analiticastoxico->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticastoxico->observacion_muestra;
                $newMuestra->anio_registro = $this->Analiticastoxico->anio_registro;
                $newMuestra->codigo_muestra = $this->Analiticastoxico->codigo_muestra;
                $newMuestra->codigo_secuencial = $this->Analiticastoxico->codigo_secuencial*10+1;
                $secuencia = $this->Analiticastoxico->codigo_secuencial*10+1;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticastoxico->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticastoxico->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticastoxico->tecnica_segunda_id;
                $newMuestra->resultado_id = $this->Analiticastoxico->resultado_segunda_id;
                $newMuestra->identificado = $this->Analiticastoxico->identificado_segunda;
                $newMuestra->descripcion = $this->Analiticastoxico->descripcion;
                $newMuestra->usuariot_id = $user;
                $newMuestra->fecha_toma = $this->Analiticastoxico->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticastoxico->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticastoxico->fecha_procesamiento;
                $newMuestra->usuarior_id = $user;
                $newMuestra->archivo = $this->Analiticastoxico->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $control = 1;
            }

            if($this->Analiticastoxico->tecnica_tercera_id>0){
                $newMuestra = new Analiticatoxico();
                $newMuestra->preanalitica_id =  $this->Analiticastoxico->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticastoxico->sedes_id;
                $newMuestra->crns_id = $this->Analiticastoxico->crns_id;
                $newMuestra->evento_id = $this->Analiticastoxico->evento_id;
                $newMuestra->muestra_id = $this->Analiticastoxico->muestra_id;
                $newMuestra->clase_id = $this->Analiticastoxico->clase_id;
                $newMuestra->anio_registro = $this->Analiticastoxico->anio_registro;
                $newMuestra->fecha_toma = $this->Analiticastoxico->fecha_toma;
                $newMuestra->estado_muestra_id = $this->Analiticastoxico->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticastoxico->observacion_muestra;
                $newMuestra->codigo_muestra = $this->Analiticastoxico->codigo_muestra;
                $newMuestra->codigo_secuencial = $this->Analiticastoxico->codigo_secuencial*10+2;
                $secuencia = $this->Analiticastoxico->codigo_secuencial*10+2;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticastoxico->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticastoxico->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticastoxico->tecnica_tercera_id;
                $newMuestra->resultado_id = $this->Analiticastoxico->resultado_tercera_id;
                $newMuestra->identificado = $this->Analiticastoxico->identificado_tercera;
                $newMuestra->descripcion = $this->Analiticastoxico->descripcion;
                $newMuestra->fecha_toma = $this->Analiticastoxico->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticastoxico->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticastoxico->fecha_procesamiento;
                $newMuestra->usuariot_id = $user;
                $newMuestra->archivo = $this->Analiticastoxico->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->usuarior_id = $user;
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $control = 1;

            }

            if($this->Analiticastoxico->tecnica_cuarta_id>0){
                $newMuestra = new Analiticatoxico();
                $newMuestra->preanalitica_id =  $this->Analiticastoxico->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticastoxico->sedes_id;
                $newMuestra->crns_id = $this->Analiticastoxico->crns_id;
                $newMuestra->evento_id = $this->Analiticastoxico->evento_id;
                $newMuestra->muestra_id = $this->Analiticastoxico->muestra_id;
                $newMuestra->clase_id = $this->Analiticastoxico->clase_id;
                $newMuestra->anio_registro = $this->Analiticastoxico->anio_registro;
                $newMuestra->fecha_toma = $this->Analiticastoxico->fecha_toma;
                $newMuestra->estado_muestra_id = $this->Analiticastoxico->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticastoxico->observacion_muestra;
                $newMuestra->codigo_muestra = $this->Analiticastoxico->codigo_muestra;
                $newMuestra->codigo_secuencial = $this->Analiticastoxico->codigo_secuencial*10+3;
                $secuencia = $this->Analiticastoxico->codigo_secuencial*10+3;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticastoxico->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticastoxico->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticastoxico->tecnica_cuarta_id;
                $newMuestra->resultado_id = $this->Analiticastoxico->resultado_cuarta_id;
                $newMuestra->identificado = $this->Analiticastoxico->identificado_cuarta;
                $newMuestra->descripcion = $this->Analiticastoxico->descripcion;
                $newMuestra->fecha_toma = $this->Analiticastoxico->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticastoxico->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticastoxico->fecha_procesamiento;
                $newMuestra->usuariot_id = $user;
                $newMuestra->archivo = $this->Analiticastoxico->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->usuarior_id = $user;
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $control = 1;
            }

            if($control>0){
                $this->Analiticastoxico->adicional=1;
                $this->Analiticastoxico->update();
            }

            DB::commit();
            $this->alert('success', 'Analitica actualizado con éxito');
            $this->emit('renderJs');
            $this->emit('closeModal');
            return redirect()->route('analiticatoxicop.index');
         }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al agregar la Analitica'.$e->getMessage());
            return $e->getMessage();
        }

    }

    public function saveAnalitica(){
        if($this->AnaliticaTmp){
            if(Storage::exists($this->Analiticastoxico->archivo)){
                Storage::delete($this->Analiticastoxico->archivo);
            }

            $path = $this->AnaliticaTmp->store('public/informes/crns');
            $path = substr($path, 7);
            $this->Analiticastoxico->archivo = $path;

        }
    }

    public function removeAnalitica(){
        if($this->Analiticastoxico->archivo){
            if(Storage::exists($this->Analiticastoxico->archivo)){
                Storage::delete($this->Analiticastoxico->archivo);
            }

            $this->Analiticastoxico->archivo = null;
            $this->Analiticastoxico->update();
        }
        $this->reset('AnaliticaTmp');
        $this->alert('success', 'Informe digitalizado eliminado con exito');
    }

}
