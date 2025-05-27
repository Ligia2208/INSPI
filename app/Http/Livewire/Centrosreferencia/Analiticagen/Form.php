<?php

namespace App\Http\Livewire\Centrosreferencia\Analiticagen;

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

use App\Models\CentrosReferencia\Tipo_Organismo;
use App\Models\CentrosReferencia\Micobacteria;
use App\Models\CentrosReferencia\Genotificacion;

use App\Models\CentrosReferencia\Result_Evento;
use App\Models\CentrosReferencia\Result_Clado;
use App\Models\CentrosReferencia\Result_Clasificacion;
use App\Models\CentrosReferencia\Result_Genotipo;
use App\Models\CentrosReferencia\Result_Linaje;
use App\Models\CentrosReferencia\Result_Resistencia;
use App\Models\CentrosReferencia\Result_Subclado;
use App\Models\CentrosReferencia\Result_Sublinaje;
use App\Models\CentrosReferencia\Result_Subvariante;
use App\Models\CentrosReferencia\Result_Variante;

use App\Models\CentrosReferencia\Paciente;
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
    public $paciente = [];
    public $edad_paciente = "";
    public $tipo = 1;
    public $id_tipo_organismo;
    public $OrganismoTmp;

    //para los resultados de genotificacion
    public $resul_eventos = [];
    public $resul_subvariantes = [];
    public $resul_variantes = [];
    public $res_evento_id = null; // <- Para el select principal
    public $subvariante_id = null; // <- Para el select dependiente
    public $variante_id = null;

    protected $listeners = ['render'];

    protected function rules()
    {

        $rules = [
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
            'Analiticastoxico.ct'                     => 'required|string',

            'OrganismoTmp.identificacion'    => 'sometimes',
            'OrganismoTmp.tecnica_libreria'  => 'sometimes',
            'OrganismoTmp.q30_estado'        => 'sometimes',
            'OrganismoTmp.secuencia_ns'      => 'sometimes',
            'OrganismoTmp.fecha_entrega'     => 'sometimes',
            'OrganismoTmp.otros'             => 'sometimes',
            'OrganismoTmp.informacion'       => 'sometimes',
            'id_tipo_organismo'              => 'sometimes',

            'paciente.nombres'         => 'required|string|max:255',
            'paciente.apellidos'       => 'required|string|max:255',
            'paciente.identidad'       => 'required|string|max:20',
            'paciente.fechanacimiento' => 'required|date',
            'paciente.sexo_id'         => 'required|string|max:10',
        ];

        // Solo si es tipo 5 (Micobacterias), agregamos estas reglas
        if ($this->tipo == 5) {
            $rules['OrganismoTmp.tecnica_libreria']  = 'required|string';
            $rules['OrganismoTmp.q30_estado']        = 'required|string';
            $rules['OrganismoTmp.secuencia_ns']      = 'required|string';
            $rules['OrganismoTmp.fecha_entrega']     = 'required|string';
            $rules['OrganismoTmp.otros']             = 'required|string';
            $rules['OrganismoTmp.informacion']       = 'required|string';

            $rules['OrganismoTmp.tipo_micobacteria'] = 'required|string';
            $rules['OrganismoTmp.clado']             = 'required|string';
            $rules['OrganismoTmp.linaje_sublinaje']  = 'required|string';
        }   

        if ($this->tipo == 4) {

            $rules['OrganismoTmp.identificacion']    = 'required|string';
            $rules['OrganismoTmp.clado']             = 'required|string';
            $rules['OrganismoTmp.linaje_sublinaje']  = 'required|string';
            $rules['OrganismoTmp.tecnica_libreria']  = 'required|string';
            $rules['OrganismoTmp.q30_estado']        = 'required|string';
            $rules['OrganismoTmp.secuencia_ns']      = 'required|string';
            $rules['OrganismoTmp.fecha_entrega']     = 'required|string';
            $rules['OrganismoTmp.otros']             = 'required|string';
            $rules['OrganismoTmp.informacion']       = 'required|string';
        }

        if ($this->tipo == 3 || $this->tipo == 6) {
            $rules['OrganismoTmp.identificacion']    = 'required|string';
            $rules['OrganismoTmp.tecnica_libreria']  = 'required|string';
            $rules['OrganismoTmp.q30_estado']        = 'required|string';
            $rules['OrganismoTmp.secuencia_ns']      = 'required|string';
            $rules['OrganismoTmp.fecha_entrega']     = 'required|string';
            $rules['OrganismoTmp.otros']             = 'required|string';
            $rules['OrganismoTmp.informacion']       = 'required|string';
        }

        if ($this->tipo == 7) {
            $rules['OrganismoTmp.identificacion']    = 'required|string';
            $rules['OrganismoTmp.tecnica_libreria']  = 'required|string';
            $rules['OrganismoTmp.q30_estado']        = 'required|string';
            $rules['OrganismoTmp.secuencia_ns']      = 'required|string';
            $rules['OrganismoTmp.fecha_entrega']     = 'required|string';
            $rules['OrganismoTmp.informacion']       = 'required|string';

            $rules['OrganismoTmp.n_secuenciacion']   = 'required|string';
            $rules['OrganismoTmp.identificacion']    = 'required|string';
            $rules['OrganismoTmp.nota']              = 'required|string';
        }

        if ($this->tipo == 2) {
            $rules['OrganismoTmp.identificacion']    = 'required|string';
            $rules['OrganismoTmp.tecnica_libreria']  = 'required|string';
            $rules['OrganismoTmp.q30_estado']        = 'required|string';
            $rules['OrganismoTmp.secuencia_ns']      = 'required|string';
            $rules['OrganismoTmp.fecha_entrega']     = 'required|string';
            $rules['OrganismoTmp.informacion']       = 'required|string';

            $rules['OrganismoTmp.n_secuenciacion']   = 'required|string';
            $rules['OrganismoTmp.identificacion']    = 'required|string';
        }

        return $rules;
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->emit('renderJs');
        });
    }
    
    public function updatedTipo($value)
    {

        // $this->OrganismoTmp->tecnica_libreria = 'AMPICONES';
        // $this->OrganismoTmp->q30_estado = 'CUMPLE';
        // $this->OrganismoTmp->secuencia_ns = 'CUMPLE';
        // $this->OrganismoTmp->tipo_micobacteria = 'Tuberculosa';

        $this->tipo = $value;
        $this->emit('renderJs');
    }


    public function mount(Analitica $Analiticasgen, $method){
        $this->Analiticastoxico = $Analiticasgen;
        $this->method = $method;

        $this->OrganismoTmp = new Genotificacion();
        $preanalitica = Preanalitica::findOrFail($this->Analiticastoxico->preanalitica_id);

        $this->id_tipo_organismo = 1;
        $this->OrganismoTmp->tecnica_libreria = 'AMPICONES';
        $this->OrganismoTmp->q30_estado = 'CUMPLE';
        $this->OrganismoTmp->secuencia_ns = 'CUMPLE';
        $this->OrganismoTmp->tipo_micobacteria = 'Tuberculosa';
        //dd($this->OrganismoTmp);
        
        //$this->OrganismoTmp->clado = 'CUMPLE';
        //$this->OrganismoTmp->linaje_sublinaje = 'CUMPLE';

        $analiticaUpdate = Analitica::where('estado','=','A')
            ->where('preanalitica_id','=',$this->Analiticastoxico->preanalitica_id)
            ->where('anio_registro','=',$this->Analiticastoxico->anio_registro)->where('codigo_secuencial','=',1)->first();

        //dd($this->Analiticastoxico);

        $this->paciente = [
            'id'              => $preanalitica->paciente->id,
            'nombres'         => $preanalitica->paciente->nombres,
            'apellidos'       => $preanalitica->paciente->apellidos,
            'identidad'       => $preanalitica->paciente->identidad,
            'fechanacimiento' => $preanalitica->paciente->fechanacimiento,
            'sexo_id'         => $preanalitica->paciente->sexo->descripcion,
        ];

        $this->Analiticastoxico->codigo_externo = $analiticaUpdate->codigo_externo;

        //$this->edad_paciente = $this->getEdadPacienteProperty();
        $this->edad_paciente = $this->Analiticastoxico->edad;

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

            //carga los datos de tipo de organismos
            $this->OrganismoTmp = Genotificacion::where('id_analitica','=',$this->Analiticastoxico->id)->first();
            
            if($this->OrganismoTmp){
                $this->tipo = $this->OrganismoTmp->id_organismo;
            }


        }

        $this->resul_eventos = Result_Evento::where('estado', 'A')->get();

    }


    public function updatedResEventoId($value)
    {
        if($value == 1){
            $this->resul_subvariantes = Result_Subvariante::where('estado', 'A')
            ->where('id_resul_evento', $value)
            ->get();
        
            //dd($this->resul_subvariantes);

            $this->subvariante_id = null; // Limpia el segundo select al cambiar el primero
            $this->emit('renderJs');

        }else if($value == 2){

            $this->resul_variantes = Result_Variante::where('estado', 'A')
            ->where('id_resul_evento', $value)
            ->get();

            $this->variante_id = null;
            $this->emit('renderJs');
        }

    }

    public function updatedVarianteId($value)
    {

        $this->resul_variantes = Result_Genotipo::where('estado', 'A')
        ->where('id_resul_evento', $value)
        ->get();

    }

    public function updatedLinajeId($value)
    {

        $this->resul_variantes = Result_Linaje::where('estado', 'A')
        ->where('id_resul_evento', $value)
        ->get();

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

        $datosMico = Micobacteria::where('pre_analitica_id', $this->Analiticastoxico->preanalitica_id)->first();

        $resul_eventos = Result_Evento::where('estado', 'A')->get();

        $tipo_organismos = Tipo_Organismo::where('estado','=','A')->orderBy('id', 'asc')->get();

        return view('livewire.centrosreferencia.analiticagen.form', compact('sedes','muestras','instituciones','paramicrobianos','paradifusion','parabiograma',
            'bacteantibioticomic','bacteantibioticokb','preanalitica','estados','unidades','clases', 'datosMico', 'tipo_organismos', 'resul_eventos'));
    }



    public function getEdadPacienteProperty()
    {
        if (isset($this->paciente['fechanacimiento'])) {
            $tiempo = strtotime($this->paciente['fechanacimiento']);
            $ahora = time();
            $tanios = ($ahora - $tiempo) / (60 * 60 * 24 * 365.25);
            $tmeses = ($ahora - $tiempo) / (60 * 60 * 24 * 30.44);
            $tdias = ($ahora - $tiempo) / (60 * 60 * 24);
            
            $anios = floor($tanios);
            $meses = floor($tmeses) - $anios * 12;
            $mdias = floor($tdias) - $anios * 365.25 - $meses * 30.44;
            $dias = floor($mdias);

            return "{$anios} años {$meses} meses {$dias} días";
        }

        return "";
    }




    public function buscarPaciente()
    {
        if (!isset($this->paciente['identidad']) || empty($this->paciente['identidad'])) {
            // Si la identidad está vacía, limpiar los campos
            $this->paciente = [
                'id'              => '',
                'nombres'         => '',
                'apellidos'       => '',
                'identidad'       => '',
                'fechanacimiento' => '',
                'sexo_id'         => '',
            ];
            $this->edad_paciente = ''; // Limpiar la edad
            return;
        }
    
        // Buscar paciente en la base de datos
        $newPaciente = Paciente::where('identidad', $this->paciente['identidad'])
            ->where('estado', 'A')
            ->first();
    
        if ($newPaciente) {
            $this->paciente = [
                'id'              => $newPaciente->id,
                'nombres'         => $newPaciente->nombres,
                'apellidos'       => $newPaciente->apellidos,
                'identidad'       => $newPaciente->identidad,
                'fechanacimiento' => $newPaciente->fechanacimiento,
                'sexo_id'         => $newPaciente->sexo->descripcion,
            ];
    
            // Calcular la edad después de cargar el paciente
            $this->edad_paciente = $this->getEdadPacienteProperty($newPaciente->fechanacimiento);

            //dd($this->paciente);

        } else {
            // Limpiar campos si no se encuentra el paciente
            $this->paciente = [
                'id'              => '',
                'nombres'         => '',
                'apellidos'       => '',
                'identidad'       => '',
                'fechanacimiento' => '',
                'sexo_id'         => '',
            ];
            $this->edad_paciente = ''; // Limpiar edad

            $this->alert('error', 'No se encontró el paciente.');

        }

        $this->emit('reiniciarSelectPicker');
        $this->emit('renderJs');
    }
    

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticastoxico->fecha_resultado = date();
        $this->Analiticastoxico->usuarior_id = $user;
        $this->saveAnalitica();
        $this->saveGenotificacion($this->Analiticastoxico);

        //Tipo_Organismo
        //Genotificacion

        $preanaliticaModel = Preanalitica::findOrFail($this->Analiticastoxico->preanalitica_id);
        $preanaliticaModel->paciente_id = $this->paciente['id'];
        $preanaliticaModel->save();

        $this->Analiticastoxico->save();
        $this->alert('success', 'Analitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('analitica.index');

    }

    public function saveGenotificacion($id_analitica, $OrganismoTmp2){
        
        
        if (is_array($this->OrganismoTmp)) {
            $genotificacion = new Genotificacion($this->OrganismoTmp);
        } else {
            $genotificacion = $this->OrganismoTmp;
        }
        
        //dd($this->OrganismoTmp);

        Genotificacion::updateOrCreate(
            ['id_analitica' => $id_analitica], // Condición de búsqueda
            [ // Valores a actualizar o crear
                'id_organismo'      => $this->tipo,
                'subtipo'           => 'Bacterias',
                'tecnica_libreria'  => $genotificacion->tecnica_libreria,
                'q30_estado'        => $genotificacion->q30_estado,
                'secuencia_ns'      => $genotificacion->secuencia_ns,
                'fecha_entrega'     => $genotificacion->fecha_entrega,
                'otros'             => $genotificacion->otros,
                'informacion'       => $genotificacion->informacion,
                'tipo_micobacteria' => $genotificacion->tipo_micobacteria,
                'clado'             => $genotificacion->clado,
                'linaje_sublinaje'  => $genotificacion->linaje_sublinaje,
                'identificacion'    => $genotificacion->identificacion,
                'n_secuenciacion'   => $genotificacion->n_secuenciacion,
                'nota'              => $genotificacion->nota,
            ]
        );
        
    }

    public function update(){
        //dd($this->OrganismoTmp);
        $this->validate();
        //$this->emit('renderJs');
        DB::beginTransaction();
        try{
            $control = 0;
            $user = auth()->user()->id;
            $this->Analiticastoxico->fecha_resultado = date("Y-m-d");
            $this->Analiticastoxico->usuarior_id = $user;

            $preanaliticaModel = Preanalitica::findOrFail($this->Analiticastoxico->preanalitica_id);
            $preanaliticaModel->paciente_id = $this->paciente['id'];
            $preanaliticaModel->save();

            $this->saveGenotificacion($this->Analiticastoxico->id, $this->OrganismoTmp);

            $this->saveAnalitica();
            $this->Analiticastoxico->update();

            if($this->Analiticastoxico->tecnica_segunda_id>0 && $this->Analiticastoxico->adicional==0){
                $newMuestra = new Analitica();
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
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticastoxico->codigo_muestra;
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
                $newMuestra->adicional = 1;
                $newMuestra->save();
                $control = 1;
            }

            if($this->Analiticastoxico->tecnica_tercera_id>0 && $this->Analiticastoxico->adicional==0){
                $newMuestra = new Analitica();
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
                $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticastoxico->codigo_muestra;
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
                $newMuestra->adicional = 1;
                $newMuestra->save();
                $control = 1;

            }

            if($this->Analiticastoxico->tecnica_cuarta_id>0 && $this->Analiticastoxico->adicional==0){
                $newMuestra = new Analitica();
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
                $newMuestra->codigo_externo = 'Adicional'.$this->Analiticastoxico->codigo_muestra;
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
                $newMuestra->adicional = 1;
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
            return redirect()->route('analitica.index');
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
