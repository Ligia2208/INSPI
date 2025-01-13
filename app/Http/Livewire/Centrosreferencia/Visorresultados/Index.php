<?php

namespace App\Http\Livewire\Centrosreferencia\Visorresultados;

use App\Models\CentrosReferencia\Resultado;
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
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];
        $data = [];

        $count = Preanalitica::where('estado','=','A')->where('validado','=','S')->count();
        $resultados = Preanalitica::where('estado','=','A')->where('validado','=','S')->orderBy('id', 'asc');

        $res = Preanalitica::where('estado','=','A')->where('validado','=','S')->orderBy('id', 'asc')->get()->toArray();
        $data = DB::table('inspi_crns.consolidado')->select('sede as grupo',DB::raw('count(evento) as total'))->groupBy('sede')->get()->toArray();
        $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->groupBy('provincia')->get()->toArray();
        $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->groupBy('canton')->get()->toArray();
        $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->groupBy('sexo')->get()->toArray();
        $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

        $etiqueta1 = 'Total Casos';
        $etiqueta2 = '% Casos';
        $etiqueta3 = '% Casos por Sexo';
        $etiqueta4 = 'Total Casos por Edad';
        $etiqueta5 = 'Total Casos por Provincia';
        $etiqueta6 = 'Total Casos por Cantón';

        if($this->csedes>=1){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes);
            $res = $resultados->where('sedes_id', '=', $this->csedes)->get()->toArray();
            $count = $resultados->count();

            $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();

            $dsede = Sede::findOrFail($this->csedes);
            $data = DB::table('inspi_crns.consolidado')->select('crn as grupo',DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->groupBy('crn')->get()->toArray();

            $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->where('sede','=',$dsede->descripcion)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->where('sede','=',$dsede->descripcion)->groupBy('canton')->get()->toArray();
            $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->groupBy('sexo')->get()->toArray();
            $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

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

            $dsede = Sede::findOrFail($this->csedes);
            $dlab = Crn::findOrFail($this->claboratorios);
            $data = DB::table('inspi_crns.consolidado')->select('evento as grupo',DB::raw('count(tecnica) as total'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->groupBy('evento')->get()->toArray();

            $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->groupBy('canton')->get()->toArray();
            $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->groupBy('sexo')->get()->toArray();
            $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

            $etiqueta = 'Eventos Registrados';
        }
        if($this->ceventos){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $res = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->get()->toArray();
            $count = $resultados->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();

            $dsede = Sede::findOrFail($this->csedes);
            $dlab = Crn::findOrFail($this->claboratorios);
            $devento = Evento::findOrFail($this->ceventos);
            $data = DB::table('inspi_crns.consolidado')->select('resultado as grupo',DB::raw('count(*) as total'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->where('evento','=',$devento->descripcion)->groupBy('resultado')->get()->toArray();

            $dataprov = DB::table('inspi_crns.consolidado')->select('provincia', DB::raw('count(evento) as eventos'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->where('evento','=',$devento->descripcion)->groupBy('provincia')->get()->toArray();
            $datacant = DB::table('inspi_crns.consolidado')->select('canton', DB::raw('count(evento) as eventos'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->where('evento','=',$devento->descripcion)->groupBy('canton')->get()->toArray();
            $datasexo = DB::table('inspi_crns.consolidado')->select('sexo as grupo', DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->where('evento','=',$devento->descripcion)->groupBy('sexo')->get()->toArray();
            $dataedad = DB::table('inspi_crns.consolidado')->select('edad as grupo', DB::raw('count(evento) as total'))->where('sede','=',$dsede->descripcion)->where('crn','=',$dlab->descripcion)->where('evento','=',$devento->descripcion)->groupBy('edad')->orderBy('edad','ASC')->get()->toArray();

            $etiqueta = 'Resultados Registrados';
        }

        $data_res = json_encode($data);
        $data_prov = json_encode($dataprov);
        $data_cant = json_encode($datacant);
        $data_sexo = json_encode($datasexo);
        $data_edad = json_encode($dataedad);

        return view('livewire.centrosreferencia.visorresultados.index', compact('count', 'resultados','data_res','data_prov','data_cant','data_sexo','data_edad','sedes','crns','eventos','etiqueta1','etiqueta2','etiqueta3','etiqueta4','etiqueta5','etiqueta6'));
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
