<?php

namespace App\Http\Livewire\Centrosreferencia\Analitica;

use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analitica;
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
    public $Analiticas;
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
            'Analiticas.sedes_id' => 'required|numeric',
            'Analiticas.crns_id' => 'required|numeric',
            'Analiticas.muestra_id' => 'required|numeric',
            'Analiticas.clase_id' => 'required|numeric',
            'Analiticas.estado_muestra_id' => 'required|numeric',
            'Analiticas.codigo_muestra' => 'required|numeric',
            'Analiticas.codigo_secuencial' => 'required|numeric',
            'Analiticas.codigo_externo' => 'sometimes|max:25',
            'Analiticas.fecha_toma' => 'required|max:10',
            'Analiticas.hora_toma' => 'sometimes|max:10',
            'Analiticas.anio_registro' => 'required|max:10',
            'Analiticas.fecha_llegada_lab' => 'required|max:10',
            'Analiticas.fecha_procesamiento' => 'required|max:10',
            'Analiticas.evento_id' => 'required|numeric',
            'Analiticas.tecnica_id' => 'required|numeric',
            'Analiticas.resultado_id' => 'required|numeric',
            'Analiticas.descripcion' => 'sometimes|max:2000',
            'Analiticas.identificado' => 'sometimes|max:200',
            'Analiticas.recomendacion_bacterio' => 'sometimes|max:200',
            'Analiticas.carga_viral' => 'sometimes|numeric',
            'Analiticas.unidades_id' => 'sometimes|numeric',
            'Analiticas.recomendacion_inmuno' => 'sometimes|max:200',

            'Analiticas.tecnica_segunda_id' => 'sometimes|numeric',
            'Analiticas.resultado_segunda_id' => 'sometimes|numeric',
            'Analiticas.identificado_segunda' => 'sometimes|max:200',

            'Analiticas.tecnica_tercera_id' => 'sometimes|numeric',
            'Analiticas.resultado_tercera_id' => 'sometimes|numeric',
            'Analiticas.identificado_tercera' => 'sometimes|max:200',

            'Analiticas.tecnica_cuarta_id' => 'sometimes|numeric',
            'Analiticas.resultado_cuarta_id' => 'sometimes|numeric',
            'Analiticas.identificado_cuarta' => 'sometimes|max:200',

            'Analiticas.tecnica_quinta_id' => 'sometimes|numeric',
            'Analiticas.resultado_quinta_id' => 'sometimes|numeric',
            'Analiticas.identificado_quinta' => 'sometimes|max:200',

            'Analiticas.tecnica_sexta_id' => 'sometimes|numeric',
            'Analiticas.resultado_sexta_id' => 'sometimes|numeric',
            'Analiticas.identificado_sexta' => 'sometimes|max:200',

            'Analiticas.germenaislado_mico' => 'sometimes|max:80',
            'Analiticas.directokoh_mico' => 'sometimes|max:80',
            'Analiticas.directoplaca_mico' => 'sometimes|max:80',
            'Analiticas.tintachina_mico' => 'sometimes|max:80',
            'Analiticas.antibiogramamico_id' => 'sometimes|numeric',

            'Analiticas.fungicounomico_id' => 'sometimes|numeric',
            'Analiticas.cimuno_mico' => 'sometimes|max:15',
            'Analiticas.difusionuno_mico' => 'sometimes|max:40',
            'Analiticas.escalaunomico_id' => 'sometimes|numeric',

            'Analiticas.fungicodosmico_id' => 'sometimes|numeric',
            'Analiticas.cimdos_mico' => 'sometimes|max:15',
            'Analiticas.difusiondos_mico' => 'sometimes|max:40',
            'Analiticas.escaladosmico_id' => 'sometimes|numeric',

            'Analiticas.fungicotresmico_id' => 'sometimes|numeric',
            'Analiticas.cimtres_mico' => 'sometimes|max:15',
            'Analiticas.difusiontres_mico' => 'sometimes|max:40',
            'Analiticas.escalatresmico_id' => 'sometimes|numeric',

            'Analiticas.fungicocuatromico_id' => 'sometimes|numeric',
            'Analiticas.cimcuatro_mico' => 'sometimes|max:15',
            'Analiticas.difusioncuatro_mico' => 'sometimes|max:40',
            'Analiticas.escalacuatromico_id' => 'sometimes|numeric',

            'Analiticas.fungicocincomico_id' => 'sometimes|numeric',
            'Analiticas.cimcinco_mico' => 'sometimes|max:15',
            'Analiticas.difusioncinco_mico' => 'sometimes|max:40',
            'Analiticas.escalacincomico_id' => 'sometimes|numeric',

            'Analiticas.fungicoseismico_id' => 'sometimes|numeric',
            'Analiticas.cimseis_mico' => 'sometimes|max:15',
            'Analiticas.difusionseis_mico' => 'sometimes|max:40',
            'Analiticas.escalaseismico_id' => 'sometimes|numeric',

            'Analiticas.fungicosietemico_id' => 'sometimes|numeric',
            'Analiticas.cimsiete_mico' => 'sometimes|max:15',
            'Analiticas.difusionsiete_mico' => 'sometimes|max:40',
            'Analiticas.escalasietemico_id' => 'sometimes|numeric',

            'Analiticas.deteccionunomico_id' => 'sometimes|numeric',
            'Analiticas.interpretaunomico_id' => 'sometimes|numeric',
            'Analiticas.detecciondosmico_id' => 'sometimes|numeric',
            'Analiticas.interpretadosmico_id' => 'sometimes|numeric',
            'Analiticas.detecciontresmico_id' => 'sometimes|numeric',
            'Analiticas.interpretatresmico_id' => 'sometimes|numeric',
            'Analiticas.deteccioncuatromico_id' => 'sometimes|numeric',
            'Analiticas.interpretacuatromico_id' => 'sometimes|numeric',

            'Analiticas.observacioninvestiga' => 'sometimes|max:250',

            'Analiticas.antibioticopsunobacte_id' => 'sometimes|numeric',
            'Analiticas.halopsuno_bacte' => 'sometimes|numeric',
            'Analiticas.escalapsunobacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticopsdosbacte_id' => 'sometimes|numeric',
            'Analiticas.halopsdos_bacte' => 'sometimes|numeric',
            'Analiticas.escalapsdosbacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticopstresbacte_id' => 'sometimes|numeric',
            'Analiticas.halopstres_bacte' => 'sometimes|numeric',
            'Analiticas.escalapstresbacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticopscuatrobacte_id' => 'sometimes|numeric',
            'Analiticas.halopscuatro_bacte' => 'sometimes|numeric',
            'Analiticas.escalapscuatrobacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticopscincobacte_id' => 'sometimes|numeric',
            'Analiticas.halopscinco_bacte' => 'sometimes|numeric',
            'Analiticas.escalapscincobacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticopsseisbacte_id' => 'sometimes|numeric',
            'Analiticas.halopsseis_bacte' => 'sometimes|numeric',
            'Analiticas.escalapsseisbacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticomdunobacte_id' => 'sometimes|numeric',
            'Analiticas.cimmduno_bacte' => 'sometimes|numeric',
            'Analiticas.escalamdunobacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticomddosbacte_id' => 'sometimes|numeric',
            'Analiticas.cimmddos_bacte' => 'sometimes|numeric',
            'Analiticas.escalamddosbacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticomdtresbacte_id' => 'sometimes|numeric',
            'Analiticas.cimmdtres_bacte' => 'sometimes|numeric',
            'Analiticas.escalamdtresbacte_id' => 'sometimes|numeric',

            'Analiticas.antibioticomdcuatrobacte_id' => 'sometimes|numeric',
            'Analiticas.cimmdcuatro_bacte' => 'sometimes|numeric',
            'Analiticas.escalamdcuatrobacte_id' => 'sometimes|numeric',

            'Analiticas.pi01_id' => 'sometimes|numeric',
            'Analiticas.pi02_id' => 'sometimes|numeric',
            'Analiticas.pi03_id' => 'sometimes|numeric',
            'Analiticas.pi04_id' => 'sometimes|numeric',
            'Analiticas.pi05_id' => 'sometimes|numeric',
            'Analiticas.pi06_id' => 'sometimes|numeric',
            'Analiticas.pi07_id' => 'sometimes|numeric',
            'Analiticas.pi08_id' => 'sometimes|numeric',

            'Analiticas.nrti01_id' => 'sometimes|numeric',
            'Analiticas.nrti02_id' => 'sometimes|numeric',
            'Analiticas.nrti03_id' => 'sometimes|numeric',
            'Analiticas.nrti04_id' => 'sometimes|numeric',
            'Analiticas.nrti05_id' => 'sometimes|numeric',
            'Analiticas.nrti06_id' => 'sometimes|numeric',
            'Analiticas.nrti07_id' => 'sometimes|numeric',

            'Analiticas.nnrti01_id' => 'sometimes|numeric',
            'Analiticas.nnrti02_id' => 'sometimes|numeric',
            'Analiticas.nnrti03_id' => 'sometimes|numeric',
            'Analiticas.nnrti04_id' => 'sometimes|numeric',
            'Analiticas.nnrti05_id' => 'sometimes|numeric',
            'Analiticas.nnrti06_id' => 'sometimes|numeric',

            'Analiticas.ini01_id' => 'sometimes|numeric',
            'Analiticas.ini02_id' => 'sometimes|numeric',
            'Analiticas.ini03_id' => 'sometimes|numeric',
            'Analiticas.ini04_id' => 'sometimes|numeric',
            'Analiticas.ini05_id' => 'sometimes|numeric',

        ];
    }

    public function mount(Analitica $Analiticas, $method){
        $this->Analiticas = $Analiticas;
        $this->method = $method;

        if($this->Analiticas->tecnica_segunda_id == 0){
            $this->Analiticas->tecnica_segunda_id = 0;
            $this->Analiticas->resultado_segunda_id = 0;
        }

        if($this->Analiticas->tecnica_tercera_id == 0){
            $this->Analiticas->tecnica_tercera_id = 0;
            $this->Analiticas->resultado_tercera_id = 0;
        }

        if($this->Analiticas->tecnica_cuarta_id == 0){
            $this->Analiticas->tecnica_cuarta_id = 0;
            $this->Analiticas->resultado_cuarta_id = 0;
        }

        if($this->Analiticas->tecnica_quinta_id == 0){
            $this->Analiticas->tecnica_quinta_id = 0;
            $this->Analiticas->resultado_quinta_id = 0;
        }

        if($this->Analiticas->tecnica_sexta_id == 0){
            $this->Analiticas->tecnica_sexta_id = 0;
            $this->Analiticas->resultado_sexta_id = 0;
        }

        if($this->Analiticas->deteccionunomico_id == 0){
            $this->Analiticas->deteccionunomico_id = 0;
            $this->Analiticas->interpretaunomico_id = 0;
        }

        if($this->Analiticas->detecciondosmico_id == 0){
            $this->Analiticas->detecciondosmico_id = 0;
            $this->Analiticas->interpretadosmico_id = 0;
        }

        if($this->Analiticas->detecciontresmico_id == 0){
            $this->Analiticas->detecciontresmico_id = 0;
            $this->Analiticas->interpretatresmico_id = 0;
        }

        if($this->Analiticas->deteccioncuatromico_id == 0){
            $this->Analiticas->deteccioncuatromico_id = 0;
            $this->Analiticas->interpretacuatromico_id = 0;
        }

        if($this->Analiticas->fungicounomico_id == 0){
            $this->Analiticas->fungicounomico_id = 0;
            $this->Analiticas->escalaunomico_id = 0;
        }

        if($this->Analiticas->fungicodosmico_id == 0){
            $this->Analiticas->fungicodosmico_id = 0;
            $this->Analiticas->escaladosmico_id = 0;
        }

        if($this->Analiticas->fungicotresmico_id == 0){
            $this->Analiticas->fungicotresmico_id = 0;
            $this->Analiticas->escalatresmico_id = 0;
        }

        if($this->Analiticas->fungicocuatromico_id == 0){
            $this->Analiticas->fungicocuatromico_id = 0;
            $this->Analiticas->escalacuatromico_id = 0;
        }

        if($this->Analiticas->fungicocincomico_id == 0){
            $this->Analiticas->fungicocincomico_id = 0;
            $this->Analiticas->escalacincomico_id = 0;
        }

        if($this->Analiticas->fungicoseismico_id == 0){
            $this->Analiticas->fungicoseismico_id = 0;
            $this->Analiticas->escalaseismico_id = 0;
        }

        if($this->Analiticas->fungicosietemico_id == 0){
            $this->Analiticas->fungicosietemico_id = 0;
            $this->Analiticas->escalasietemico_id = 0;
        }

        if($this->Analiticas->antibioticopsunobacte_id == 0){
            $this->Analiticas->antibioticopsunobacte_id = 0;
            $this->Analiticas->halopsuno_bacte = 0;
            $this->Analiticas->escalapsunobacte_id = 0;

        }

        if($this->Analiticas->antibioticopsdosbacte_id == 0){
            $this->Analiticas->antibioticopsdosbacte_id = 0;
            $this->Analiticas->halopsdos_bacte = 0;
            $this->Analiticas->escalapsdosbacte_id = 0;

        }

        if($this->Analiticas->antibioticopstresbacte_id == 0){
            $this->Analiticas->antibioticopstresbacte_id = 0;
            $this->Analiticas->halopstres_bacte = 0;
            $this->Analiticas->escalapstresbacte_id = 0;

        }

        if($this->Analiticas->antibioticopscuatrobacte_id == 0){
            $this->Analiticas->antibioticopscuatrobacte_id = 0;
            $this->Analiticas->halopscuatro_bacte = 0;
            $this->Analiticas->escalapscuatroacte_id = 0;

        }

        if($this->Analiticas->antibioticopscincobacte_id == 0){
            $this->Analiticas->antibioticopscincobacte_id = 0;
            $this->Analiticas->halopscinco_bacte = 0;
            $this->Analiticas->escalapscincobacte_id = 0;

        }

        if($this->Analiticas->antibioticopsseisbacte_id == 0){
            $this->Analiticas->antibioticopsseisbacte_id = 0;
            $this->Analiticas->halopsseis_bacte = 0;
            $this->Analiticas->escalapsseisbacte_id = 0;

        }

        if($this->Analiticas->antibioticomdunobacte_id == 0){
            $this->Analiticas->antibioticomdunobacte_id = 0;
            $this->Analiticas->cimmduno_bacte = 0;
            $this->Analiticas->escalamdunobacte_id = 0;

        }

        if($this->Analiticas->antibioticomddosbacte_id == 0){
            $this->Analiticas->antibioticomddosbacte_id = 0;
            $this->Analiticas->cimmddos_bacte = 0;
            $this->Analiticas->escalamddosbacte_id = 0;

        }

        if($this->Analiticas->antibioticomdtresbacte_id == 0){
            $this->Analiticas->antibioticomdtresbacte_id = 0;
            $this->Analiticas->cimmdtres_bacte = 0;
            $this->Analiticas->escalamdtresbacte_id = 0;

        }

        if($this->Analiticas->antibioticomdcuatrobacte_id == 0){
            $this->Analiticas->antibioticomdcuatrobacte_id = 0;
            $this->Analiticas->cimmdcuatro_bacte = 0;
            $this->Analiticas->escalamdcuatrobacte_id = 0;

        }

        if($method=='update'){
            $preanalitica = Preanalitica::findOrFail($this->Analiticas->preanalitica_id);
            $this->Analiticas->evolucion = $this->diferencia($preanalitica->fecha_sintomas,$preanalitica->fecha_toma_primera);
            $config = SedeCrn::where('sedes_id','=',$this->Analiticas->sedes_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
            $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->get();
            $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->get();
            $this->eventos = Evento::where('estado','=','A')->where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->get();

        }

    }

    public function updatedselectedSede($sede_id){
        $config = SedeCrn::where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrn($crns_id){
        $this->eventos = Evento::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedProvincia($provincia_id){
        $this->cantones = Canton::where('provincia_id','=',$provincia_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function render(){

        $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $muestras = Muestra::where('estado','=','A')->orderBy('id','asc')->cursor();
        $preanalitica = Preanalitica::findOrFail($this->Analiticas->preanalitica_id);
        $estados = Estadomuestra::orderBy('id', 'asc')->cursor();
        $unidades = Unidades::where('estado','=','A')->where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->cursor();
        $clases = Clase::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $instituciones = Institucion::where('estado','=','A')->orderBy('id','asc')->cursor();
        $paramicrobianos = Tipoparametros::where('estado','=','A')->where('crns_id','=',6)->where('tipo','=','Antimicrobianos')->orderBy('id','asc')->cursor();
        $paradifusion = Tipoparametros::where('estado','=','A')->where('crns_id','=',6)->where('tipo','=','Inmunodifusion')->orderBy('id','asc')->cursor();
        $parabiograma = Tipoparametros::where('estado','=','A')->where('crns_id','=',6)->where('tipo','=','Antibiograma')->orderBy('id','asc')->cursor();
        $bacteantibioticomic = Tipoparametros::where('estado','=','A')->where('crns_id','=',3)->where('tipo','=','AntibioticoMIC')->orderBy('id','asc')->cursor();
        $bacteantibioticokb = Tipoparametros::where('estado','=','A')->where('crns_id','=',3)->where('tipo','=','AntibioticoKB')->orderBy('id','asc')->cursor();
        $medicamentopi = Tipoparametros::where('estado','=','A')->where('crns_id','=',12)->where('tipo','=','Medicamento-PI')->orderBy('id','asc')->cursor();
        $medicamentonrti = Tipoparametros::where('estado','=','A')->where('crns_id','=',12)->where('tipo','=','Medicamento-NRTI')->orderBy('id','asc')->cursor();
        $medicamentonnrti = Tipoparametros::where('estado','=','A')->where('crns_id','=',12)->where('tipo','=','Medicamento-NNRTI')->orderBy('id','asc')->cursor();
        $medicamentoini = Tipoparametros::where('estado','=','A')->where('crns_id','=',12)->where('tipo','=','Medicamento-INI')->orderBy('id','asc')->cursor();
        return view('livewire.centrosreferencia.analitica.form', compact('sedes','muestras','instituciones','paramicrobianos','paradifusion','parabiograma','bacteantibioticomic','bacteantibioticokb','medicamentopi','medicamentonrti','medicamentonnrti','medicamentoini','preanalitica','estados','unidades','clases'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticas->fecha_resultado = date();
        $this->Analiticas->usuarior_id = $user;
        $this->saveAnalitica();
        $this->Analiticas->save();
        $this->alert('success', 'Analitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('analitica.index');

    }

    public function diferencia($fsintomas, $fregistro){
        $datetime1 = new Datetime($fsintomas);
        $datetime2 = new Datetime($fregistro);
        $diff = $datetime1->diff($datetime2);
        return $diff->days;
    }

    public function update(){
        $this->validate();
        DB::beginTransaction();
        try{

            $user = auth()->user()->id;
            $this->Analiticas->fecha_resultado = date("Y-m-d");
            $this->Analiticas->usuarior_id = $user;
            $this->saveAnalitica();

           if($this->Analiticas->tecnica_segunda_id==0){
                $this->Analiticas->tecnica_segunda_id=0;
                $this->Analiticas->resultado_segunda_id=0;
            }
            if($this->Analiticas->tecnica_tercera_id==0){
                $this->Analiticas->tecnica_tercera_id=0;
                $this->Analiticas->resultado_tercera_id=0;
            }
            if($this->Analiticas->tecnica_cuarta_id==0){
                $this->Analiticas->tecnica_cuarta_id=0;
                $this->Analiticas->resultado_cuarta_id=0;
            }
            if($this->Analiticas->tecnica_quinta_id==0){
                $this->Analiticas->tecnica_quinta_id=0;
                $this->Analiticas->resultado_quinta_id=0;
            }
            if($this->Analiticas->tecnica_sexta_id==0){
                $this->Analiticas->tecnica_sexta_id=0;
                $this->Analiticas->resultado_sexta_id=0;
            }
            $this->Analiticas->update();

            $cont = 0;
            if($this->Analiticas->tecnica_segunda_id>0){
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id = $this->Analiticas->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticas->sedes_id;
                $newMuestra->crns_id = $this->Analiticas->crns_id;
                $newMuestra->evento_id = $this->Analiticas->evento_id;
                $newMuestra->muestra_id = $this->Analiticas->muestra_id;
                $newMuestra->clase_id = $this->Analiticas->clase_id;
                $newMuestra->estado_muestra_id = $this->Analiticas->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticas->observacion_muestra;
                $newMuestra->anio_registro = $this->Analiticas->anio_registro;
                $newMuestra->codigo_muestra = $this->Analiticas->codigo_muestra;
                $secuencia = $this->Analiticas->codigo_secuencial*10+1;
                $newMuestra->codigo_secuencial = $secuencia;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticas->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticas->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticas->tecnica_segunda_id;
                $newMuestra->resultado_id = $this->Analiticas->resultado_segunda_id;
                $newMuestra->identificado = $this->Analiticas->identificado_segunda;
                $newMuestra->descripcion = $this->Analiticas->descripcion;
                $newMuestra->usuariot_id = $user;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticas->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticas->fecha_procesamiento;
                $newMuestra->usuarior_id = $user;
                $newMuestra->archivo = $this->Analiticas->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $cont = $cont + 1;
            }

            if($this->Analiticas->tecnica_tercera_id>0){
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id =  $this->Analiticas->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticas->sedes_id;
                $newMuestra->crns_id = $this->Analiticas->crns_id;
                $newMuestra->evento_id = $this->Analiticas->evento_id;
                $newMuestra->muestra_id = $this->Analiticas->muestra_id;
                $newMuestra->clase_id = $this->Analiticas->clase_id;
                $newMuestra->anio_registro = $this->Analiticas->anio_registro;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->estado_muestra_id = $this->Analiticas->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticas->observacion_muestra;
                $newMuestra->codigo_muestra = $this->Analiticas->codigo_muestra;
                $secuencia = $this->Analiticas->codigo_secuencial*10+2;
                $newMuestra->codigo_secuencial = $secuencia;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticas->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticas->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticas->tecnica_tercera_id;
                $newMuestra->resultado_id = $this->Analiticas->resultado_tercera_id;
                $newMuestra->identificado = $this->Analiticas->identificado_tercera;
                $newMuestra->descripcion = $this->Analiticas->descripcion;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticas->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticas->fecha_procesamiento;
                $newMuestra->usuariot_id = $user;
                $newMuestra->archivo = $this->Analiticas->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->usuarior_id = $user;
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $cont = $cont + 1;

            }

            if($this->Analiticas->tecnica_cuarta_id>0){
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id =  $this->Analiticas->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticas->sedes_id;
                $newMuestra->crns_id = $this->Analiticas->crns_id;
                $newMuestra->evento_id = $this->Analiticas->evento_id;
                $newMuestra->muestra_id = $this->Analiticas->muestra_id;
                $newMuestra->clase_id = $this->Analiticas->clase_id;
                $newMuestra->anio_registro = $this->Analiticas->anio_registro;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->estado_muestra_id = $this->Analiticas->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticas->observacion_muestra;
                $newMuestra->codigo_muestra = $this->Analiticas->codigo_muestra;
                $secuencia = $this->Analiticas->codigo_secuencial*10+3;
                $newMuestra->codigo_secuencial = $secuencia;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticas->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticas->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticas->tecnica_cuarta_id;
                $newMuestra->resultado_id = $this->Analiticas->resultado_cuarta_id;
                $newMuestra->identificado = $this->Analiticas->identificado_cuarta;
                $newMuestra->descripcion = $this->Analiticas->descripcion;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticas->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticas->fecha_procesamiento;
                $newMuestra->usuariot_id = $user;
                $newMuestra->archivo = $this->Analiticas->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->usuarior_id = $user;
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $cont = $cont + 1;

            }

            if($this->Analiticas->tecnica_quinta_id>0){
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id =  $this->Analiticas->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticas->sedes_id;
                $newMuestra->crns_id = $this->Analiticas->crns_id;
                $newMuestra->evento_id = $this->Analiticas->evento_id;
                $newMuestra->muestra_id = $this->Analiticas->muestra_id;
                $newMuestra->clase_id = $this->Analiticas->clase_id;
                $newMuestra->anio_registro = $this->Analiticas->anio_registro;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->estado_muestra_id = $this->Analiticas->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticas->observacion_muestra;
                $newMuestra->codigo_muestra = $this->Analiticas->codigo_muestra;
                $secuencia = $this->Analiticas->codigo_secuencial*10+4;
                $newMuestra->codigo_secuencial = $secuencia;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticas->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticas->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticas->tecnica_quinta_id;
                $newMuestra->resultado_id = $this->Analiticas->resultado_quinta_id;
                $newMuestra->identificado = $this->Analiticas->identificado_quinta;
                $newMuestra->descripcion = $this->Analiticas->descripcion;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticas->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticas->fecha_procesamiento;
                $newMuestra->usuariot_id = $user;
                $newMuestra->archivo = $this->Analiticas->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->usuarior_id = $user;
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $cont = $cont + 1;

            }

            if($this->Analiticas->tecnica_sexta_id>0){
                $newMuestra = new Analitica();
                $newMuestra->preanalitica_id =  $this->Analiticas->preanalitica_id;
                $newMuestra->sedes_id = $this->Analiticas->sedes_id;
                $newMuestra->crns_id = $this->Analiticas->crns_id;
                $newMuestra->evento_id = $this->Analiticas->evento_id;
                $newMuestra->muestra_id = $this->Analiticas->muestra_id;
                $newMuestra->clase_id = $this->Analiticas->clase_id;
                $newMuestra->anio_registro = $this->Analiticas->anio_registro;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->estado_muestra_id = $this->Analiticas->estado_muestra_id;
                $newMuestra->observacion_muestra = $this->Analiticas->observacion_muestra;
                $newMuestra->codigo_muestra = $this->Analiticas->codigo_muestra;
                $secuencia = $this->Analiticas->codigo_secuencial*10+5;
                $newMuestra->codigo_secuencial = $secuencia;
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticas->codigo_muestra.'-'.$secuencia;
                $newMuestra->codigo_calidad = $this->Analiticas->codigo_calidad;
                $newMuestra->tecnica_id = $this->Analiticas->tecnica_sexta_id;
                $newMuestra->resultado_id = $this->Analiticas->resultado_sexta_id;
                $newMuestra->identificado = $this->Analiticas->identificado_sexta;
                $newMuestra->descripcion = $this->Analiticas->descripcion;
                $newMuestra->fecha_toma = $this->Analiticas->fecha_toma;
                $newMuestra->fecha_llegada_lab = $this->Analiticas->fecha_llegada_lab;
                $newMuestra->fecha_procesamiento = $this->Analiticas->fecha_procesamiento;
                $newMuestra->usuariot_id = $user;
                $newMuestra->archivo = $this->Analiticas->archivo;
                $newMuestra->fecha_resultado = date("Y-m-d");
                $newMuestra->usuarior_id = $user;
                $newMuestra->adicional = $secuencia;
                $newMuestra->save();
                $cont = $cont + 1;

            }

            if($cont>0){
                $this->Analiticas->adicional=$cont;
                $this->Analiticas->update();
            }

            DB::commit();
            $this->alert('success', 'Analitica actualizado con éxito');
            $this->emit('renderJs');
            $this->emit('closeModal');
            return redirect()->route('analiticap.index');
         }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al agregar la Analitica');
            return $e->getMessage();
        }

    }

    public function saveAnalitica(){
        if($this->AnaliticaTmp){
            if(Storage::exists($this->Analiticas->archivo)){
                Storage::delete($this->Analiticas->archivo);
            }

            $path = $this->AnaliticaTmp->store('public/informes/crns');
            $path = substr($path, 7);
            $this->Analiticas->archivo = $path;

        }
    }

    public function sgte_codigomuestra($anio, $sede, $crn){
        $max = Analitica::where('estado','=','A')->where('anio_registro','=',$anio)->where('sedes_id','=',$sede)->where('crns_id','=',$crn)->max('codigo_muestra');
        return $max+1;
    }

    public function removeAnalitica(){
        if($this->Analiticas->archivo){
            if(Storage::exists($this->Analiticas->archivo)){
                Storage::delete($this->Analiticas->archivo);
            }

            $this->Analiticas->archivo = null;
            $this->Analiticas->update();
        }
        $this->reset('AnaliticaTmp');
        $this->alert('success', 'Informe digitalizado eliminado con exito');
    }

}
