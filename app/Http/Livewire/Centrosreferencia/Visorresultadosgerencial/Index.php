<?php

namespace App\Http\Livewire\Centrosreferencia\Visorresultadosgerencial;

use App\Models\CentrosReferencia\Resultado;
use App\Models\CentrosReferencia\Responsable;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\Reporte;
use App\Models\CentrosReferencia\Tecnica;
use App\Models\User;
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
    public $fechainicio;
    public $fechafin;
    public $csedes;
    public $claboratorios;
    public $ceventos;
    public $ctecnicas;
    public $cresultados;
    public $ctecnicos;
    protected $queryString = ['search' => ['except' => ''], 'csedes' => ['except' => ''], 'claboratorios' => ['except' => ''], 'ceventos' => ['except' => ''], 'ctecnicas' => ['except' => ''], 'cresultados' => ['except' => ''], 'ctecnicos' => ['except' => '']];

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
        $tecnicas = [];
        $reportes = [];
        $usuarios = [];

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
            $tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
            $reportes = Reporte::where('estado','=','A')->where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
            $crns_tecnicos = Responsable::where('estado','=','A')->where('crns_id','=',$this->claboratorios)->where('vigente_hasta','=',null)->distinct('usuario_id')->pluck('usuario_id')->toArray();
            $usuarios = User::whereIn('id',$crns_tecnicos)->orderBy('id', 'asc')->get();

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

        if($this->ceventos>0){
            if($this->ctecnicas>0){
                if($this->cresultados>0){
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                    else{
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                }
                else{
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                    else{
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idtecnica','=',$this->ctecnicas)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                }
            }
            else{
                if($this->cresultados>0){
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';

                    }
                    else{
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('idresultado','=',$this->cresultados)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                }
                else{
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';

                    }
                    else{
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
                }
            }
        }
        else{
            if($this->ctecnicas>0){
                if($this->cresultados>0){
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                    else{
                        $resultados = $resultados->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('idresultado','=',$this->cresultados)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                }
                else{
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                    else{
                        $resultados = $resultados->where('idtecnica','=',$this->ctecnicas);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idtecnica','=',$this->ctecnicas)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                }
            }
            else{
                if($this->cresultados>0){
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                    else{
                        $resultados = $resultados->where('idresultado','=',$this->cresultados);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('idresultado','=',$this->cresultados)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                }
                else{
                    if($this->ctecnicos>0){
                        $resultados = $resultados->where('tecnico','=',$this->ctecnicos);
                        $count = $resultados->count();

                        $data = DB::table('inspi_crns.detalle_muestras')->select('evento as grupo',DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('evento')->get()->toArray();
                        $dataprov = DB::table('inspi_crns.detalle_muestras')->select('provincia', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('provincia')->get()->toArray();
                        $datacant = DB::table('inspi_crns.detalle_muestras')->select('canton', DB::raw('count(evento) as eventos'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('canton')->get()->toArray();
                        $dataclase = DB::table('inspi_crns.detalle_muestras')->select('clase_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('clase_muestra')->get()->toArray();
                        $datatipo = DB::table('inspi_crns.detalle_muestras')->select('tipo_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('tipo_muestra')->get()->toArray();
                        $dataproc = DB::table('inspi_crns.detalle_muestras')->select('procesado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('procesado')->get()->toArray();
                        $datacump = DB::table('inspi_crns.detalle_muestras')->select('estado_muestra as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('estado_muestra')->get()->toArray();
                        $datainsa = DB::table('inspi_crns.detalle_muestras')->select('institucion as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('institucion')->get()->toArray();
                        $datatecn = DB::table('inspi_crns.detalle_muestras')->select('tecnica as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('tecnica')->get()->toArray();
                        $dataresu = DB::table('inspi_crns.detalle_muestras')->select('resultado as grupo', DB::raw('count(*) as total'))->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('tecnico','=',$this->ctecnicos)->groupBy('resultado')->get()->toArray();

                        $etiqueta = 'Resultados Registrados';
                    }
                    else{
                        $resultados = $resultados;
                        $count = $resultados->count();
                    }
                }
            }
        }

        if($this->fechainicio){
            if ($this->fechafin){
                if ($this->fechainicio <= $this->fechafin){
                    if($this->controlf==0){
                        $this->fechainicio='';
                        $this->fechafin='';
                    }
                    if($this->controlf==1){
                        $resultados = $resultados->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin);
                        $count = $resultados->count();
                    }
                    if($this->controlf==2){
                        $resultados = $resultados->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $resultados->count();
                    }
                    if($this->controlf==3){
                        $resultados = $resultados->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin);
                        $count = $resultados->count();
                    }
                    if($this->controlf==4){
                        $resultados = $resultados->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin);
                        $count = $resultados->count();
                    }
                }
                else{
                    $this->alert('error', __('Fecha fin debe ser mayor o igual a Fecha inicio'));
                }
            }
            else{
                $this->alert('error', __('Fecha fin no puede ser nulo'));
            }
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

        return view('livewire.centrosreferencia.visorresultadosgerencial.index', compact('count', 'resultados','tecnicas','reportes','usuarios','data_res','data_prov','data_cant','data_clase','data_tipo','data_procesado','data_cumple','data_insa','data_tecn','data_resu','sedes','crns','eventos','etiqueta0','etiqueta1','etiqueta2','etiqueta3','etiqueta4','etiqueta5','etiqueta6','etiqueta7','etiqueta8','etiqueta9','etiqueta10'));
    }


}
