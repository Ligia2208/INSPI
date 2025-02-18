<?php

namespace App\Http\Livewire\Centrosreferencia\Visorresultadosgerencial;

use App\Models\CentrosReferencia\Resultado;
use App\Models\CentrosReferencia\Responsable;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Crn;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use DB;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $userPresent;

    //Tools
    public $perPage = 25;
    public $search;
    public $csedes;
    public $claboratorios;
    public $ceventos;
    protected $queryString = ['search' => ['except' => ''], 'csedes' => ['except' => ''], 'claboratorios' => ['except' => ''], 'ceventos' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $iduser = auth()->user()->id;
        $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();

        $crns = [];
        $eventos = [];
        $data = [];

        $resultados = DB::table('inspi_crns.detalle_muestras');
        $count = $resultados->count();

        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->groupBy('evento')->get()->toArray();
        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->groupBy('provincia')->get()->toArray();
        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->groupBy('canton')->get()->toArray();
        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->groupBy('clase_muestra')->get()->toArray();
        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->groupBy('tipo_muestra')->get()->toArray();
        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->groupBy('procesado')->get()->toArray();
        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->groupBy('estado_muestra')->get()->toArray();
        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->groupBy('institucion')->get()->toArray();
        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->groupBy('tecnica')->get()->toArray();
        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->groupBy('resultado')->get()->toArray();

        $etiqueta0 = 'Total por Institución de Salud';
        $etiqueta1 = 'Total por evento';
        $etiqueta2 = '% por evento';
        $etiqueta3 = 'Total por Clase';
        $etiqueta4 = 'Total por Tipo Muestra';
        $etiqueta5 = 'Total Muestras Procesadas';
        $etiqueta6 = 'Total Muestras Válidas';
        $etiqueta7 = 'Total Muestras por Provincia';
        $etiqueta8 = 'Total Muestras por Cantón';
        $etiqueta9 = '% por Técnica Aplicada';
        $etiqueta10 = 'Total por Resultado Encontrado';

        if($this->csedes>=1){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes);
            $count = $resultados->count();

            $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();

            $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('evento')->get()->toArray();
            $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->groupBy('canton')->get()->toArray();
            $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('clase_muestra')->get()->toArray();
            $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('tipo_muestra')->get()->toArray();
            $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('procesado')->get()->toArray();
            $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('estado_muestra')->get()->toArray();
            $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('institucion')->get()->toArray();
            $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('tecnica')->get()->toArray();
            $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->groupBy('resultado')->get()->toArray();

            $etiqueta = 'Crns - Laboratorios';
        }
        if($this->csedes<1){
            $this->ceventos='';
            $this->claboratorios='';
        }
        if($this->claboratorios){
            $resultados = $resultados->where('crns_id','=',$this->claboratorios);
            $count = $resultados->count();
            $eventos = Evento::where('estado','=','A')->where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();

            $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('evento')->get()->toArray();
            $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('canton')->get()->toArray();
            $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('clase_muestra')->get()->toArray();
            $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('tipo_muestra')->get()->toArray();
            $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('procesado')->get()->toArray();
            $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('estado_muestra')->get()->toArray();
            $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('institucion')->get()->toArray();
            $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('tecnica')->get()->toArray();
            $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('resultado')->get()->toArray();

            $etiqueta = 'Eventos Registrados';
        }
        if($this->ceventos){
            $resultados = $resultados->where('evento_id','=',$this->ceventos);
            $count = $resultados->count();

            $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('evento')->get()->toArray();
            $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('canton')->get()->toArray();
            $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('clase_muestra')->get()->toArray();
            $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('tipo_muestra')->get()->toArray();
            $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('procesado')->get()->toArray();
            $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('estado_muestra')->get()->toArray();
            $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('institucion')->get()->toArray();
            $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('tecnica')->get()->toArray();
            $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('resultado')->get()->toArray();

            $etiqueta = 'Resultados Registrados';
        }

        $data_res = json_encode($data);
        $data_prov = json_encode($dataprov);
        $data_cant = json_encode($datacant);
        $data_clase = json_encode($dataclase);
        $data_tipo = json_encode($datatipo);
        $data_procesado = json_encode($dataproc);
        $data_cumple = json_encode($datacump);
        $data_insa = json_encode($datainsa);
        $data_tecn = json_encode($datatecn);
        $data_resu = json_encode($dataresu);

        return view('livewire.centrosreferencia.visorresultadosgerencial.index', compact('count', 'resultados','data_res','data_prov','data_cant','data_clase','data_tipo','data_procesado','data_cumple','data_insa','data_tecn','data_resu','sedes','crns','eventos','etiqueta0','etiqueta1','etiqueta2','etiqueta3','etiqueta4','etiqueta5','etiqueta6','etiqueta7','etiqueta8','etiqueta9','etiqueta10'));
    }


}
