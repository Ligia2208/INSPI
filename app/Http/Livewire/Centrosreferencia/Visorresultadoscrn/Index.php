<?php

namespace App\Http\Livewire\Centrosreferencia\Visorresultadoscrn;

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
        $sedes_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('sedes_id')->pluck('sedes_id')->toArray();
        $crns_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('crns_id')->pluck('crns_id')->toArray();
        $sedes = Sede::whereIn('id',$sedes_users)->orderBy('id', 'asc')->cursor();

        $crns = [];
        $eventos = [];
        $data = [];

        $resultados = DB::table('inspi_crns.detalle_muestras')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->orderBy('id', 'asc');
        $count = $resultados->count();

        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('evento')->get()->toArray();
        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(paciente) as eventos'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('provincia')->get()->toArray();
        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(paciente) as eventos'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('canton')->get()->toArray();
        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('clase_muestra')->get()->toArray();
        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('tipo_muestra')->get()->toArray();
        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('procesado')->get()->toArray();
        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('estado_muestra')->get()->toArray();
        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('institucion')->get()->toArray();
        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('tecnica')->get()->toArray();
        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(paciente) as total'))->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->groupBy('resultado')->get()->toArray();

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

            $crns = Crn::whereIn('id',$crns_users)->orderBy('id', 'asc')->get();

            $data = DB::table('inspi_crns.consolidado')->select('crn as grupo',DB::raw('count(evento) as total'))->where('sedes_id','=',$this->csedes)->groupBy('crn')->get()->toArray();

            $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->groupBy('canton')->get()->toArray();
            $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->where('sedes_id','=',$this->csedes)->groupBy('sexo')->get()->toArray();
            $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->where('sedes_id','=',$this->csedes)->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

            $etiqueta = 'Crns - Laboratorios';
        }
        if($this->csedes<1){
            $this->ceventos='';
            $this->claboratorios='';
        }
        if($this->claboratorios){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $res = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->get()->toArray();
            $count = $resultados->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();

            $data = DB::table('inspi_crns.consolidado')->select('evento as grupo',DB::raw('count(resultado) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('evento')->get()->toArray();

            $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('canton')->get()->toArray();
            $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('sexo')->get()->toArray();
            $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

            $etiqueta = 'Eventos Registrados';
        }
        if($this->ceventos){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $res = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->get()->toArray();
            $count = $resultados->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();

            $data = DB::table('inspi_crns.consolidado')->select('resultado as grupo',DB::raw('count(*) as total'))->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('resultado')->get()->toArray();

            $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('canton')->get()->toArray();
            $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('sexo')->get()->toArray();
            $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

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

        return view('livewire.centrosreferencia.visorresultadoscrn.index', compact('count', 'resultados','data_res','data_prov','data_cant','data_clase','data_tipo','data_procesado','data_cumple','data_insa','data_tecn','data_resu','sedes','crns','eventos','etiqueta0','etiqueta1','etiqueta2','etiqueta3','etiqueta4','etiqueta5','etiqueta6','etiqueta7','etiqueta8','etiqueta9','etiqueta10'));
    }

    public function eventosemanal(){
        $record1 = DB::table('inspi_intranet.ineve_eventos')->select(\DB::raw("COUNT(*) as count"), 'inspi_intranet.ineve_eventos.cerrado as cerrado')
            ->where('inspi_intranet.ineve_eventos.cerrado','=',0)
            ->where('inspi_intranet.ineve_eventos.created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('cerrado')
            ->orderBy('cerrado')
            ->get();
            $record2 = DB::table('inspi_intranet.ineve_eventos')->select(\DB::raw("COUNT(*) as count"), 'inspi_intranet.ineve_eventos.cerrado as cerrado')
            ->where('inspi_intranet.ineve_eventos.cerrado','=',1)
            ->where('inspi_intranet.ineve_eventos.created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('cerrado')
            ->orderBy('cerrado')
            ->get();
        $d1=0;   $d2=0;

        $this->dataos['label'][0] = 'En curso';
        $this->dataos['label'][1] = 'Cerrado';

        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }

        $this->dataos['data'][0] = $d1;
        $this->dataos['data'][1] = $d2;

        $this->dataos['chart_data_origen_semanal'] = json_encode($this->dataos);

    }

}
