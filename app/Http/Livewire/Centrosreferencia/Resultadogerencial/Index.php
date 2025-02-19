<?php

namespace App\Http\Livewire\Centrosreferencia\Resultadogerencial;

use App\Models\CentrosReferencia\Resultado;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Responsable;
use App\Models\CentrosReferencia\Crn;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $fechainicio;
    public $fechafin;
    public $controlf;

    protected $queryString = ['search' => ['except' => ''], 'csedes' => ['except' => ''], 'claboratorios' => ['except' => ''], 'ceventos' => ['except' => ''], 'fechainicio' => ['except' => ''], 'fechafin' => ['except' => ''], 'controlf' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $iduser = auth()->user()->id;
        $rol = auth()->user()->roles()->first()->name;
        $cmicobacterias = 0;
        $cinfluenza = 0;
        $cbacteriologia = 0;
        $cvectores = 0;
        $cparasitologia = 0;
        $cmicologia = 0;
        $ctoxicologia = 0;
        $cexantematicos = 0;
        $cgenomica = 0;
        $cram = 0;
        $czoonosis = 0;
        $cinmunohematologia = 0;
        $countlab = 0;
        $countlabpro = 0;
        $countlabpen = 0;
        $countlabrec = 0;
        $countlabana = 0;
        $countlabcum = 0;

        $sedes = Sede::whereIn('estado',['A','M'])->orderBy('id', 'asc')->cursor();
        $cmicobacterias = Analitica::where('estado','=','A')->where('crns_id','=',1)->count();
        $cinfluenza = Analitica::where('estado','=','A')->where('crns_id','=',2)->count();
        $cbacteriologia = Analitica::where('estado','=','A')->where('crns_id','=',3)->count();
        $cvectores = Analitica::where('estado','=','A')->where('crns_id','=',4)->count();
        $cparasitologia = Analitica::where('estado','=','A')->where('crns_id','=',5)->count();
        $cmicologia = Analitica::where('estado','=','A')->where('crns_id','=',6)->count();
        $ctoxicologia = Analitica::where('estado','=','A')->where('crns_id','=',7)->count();
        $cexantematicos = Analitica::where('estado','=','A')->where('crns_id','=',8)->count();
        $cgenomica = Analitica::where('estado','=','A')->where('crns_id','=',9)->count();
        $cram = Analitica::where('estado','=','A')->where('crns_id','=',10)->count();
        $czoonosis = Analitica::where('estado','=','A')->where('crns_id','=',11)->count();
        $cinmunohematologia = Analitica::where('estado','=','A')->where('crns_id','=',12)->count();

        $crns = [];
        $eventos = [];
        $sedes_up = [];

        $count = Analitica::where('estado','=','A')->count();
        $resultados = Analitica::where('estado','=','A')->orderBy('id', 'asc');

        if($this->search){
            $resultados = $resultados->where('codigo_muestra', 'LIKE', "%{$this->search}%");
            $count = $resultados->count();

        }
        if($this->csedes){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes);
            $count = $resultados->count();

            $cmicobacterias = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',1)->count();
            $cinfluenza = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',2)->count();
            $cbacteriologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',3)->count();
            $cvectores = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',4)->count();
            $cparasitologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',5)->count();
            $cmicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',6)->count();
            $ctoxicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',7)->count();
            $cexantematicos = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',8)->count();
            $cgenomica = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',9)->count();
            $cram = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',10)->count();
            $czoonosis = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',11)->count();
            $cinmunohematologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',12)->count();

            $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();

        }

        if($this->claboratorios){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $resultados->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();

            $countlab = $count;
            $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('estado_muestra_id','=',1)->count();
            $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('estado_muestra_id','=',2)->count();
            $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
            $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
            $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();

        }


        if($this->ceventos){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $count = $resultados->count();

            $countlab = $count;
            $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('estado_muestra_id','=',1)->count();
            $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('estado_muestra_id','=',2)->count();
            $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
            $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
            $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();

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
                        if($this->csedes==''){
                            $cmicobacterias = Analitica::where('estado','=','A')->where('crns_id','=',1)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cinfluenza = Analitica::where('estado','=','A')->where('crns_id','=',2)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cbacteriologia = Analitica::where('estado','=','A')->where('crns_id','=',3)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cvectores = Analitica::where('estado','=','A')->where('crns_id','=',4)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cparasitologia = Analitica::where('estado','=','A')->where('crns_id','=',5)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cmicologia = Analitica::where('estado','=','A')->where('crns_id','=',6)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $ctoxicologia = Analitica::where('estado','=','A')->where('crns_id','=',7)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cexantematicos = Analitica::where('estado','=','A')->where('crns_id','=',8)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cgenomica = Analitica::where('estado','=','A')->where('crns_id','=',9)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cram = Analitica::where('estado','=','A')->where('crns_id','=',10)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $czoonosis = Analitica::where('estado','=','A')->where('crns_id','=',11)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            $cinmunohematologia = Analitica::where('estado','=','A')->where('crns_id','=',12)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                        }
                        else{
                            if($this->claboratorios==''){
                                $cmicobacterias = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',1)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cinfluenza = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',2)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cbacteriologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',3)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cvectores = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',4)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cparasitologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',5)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cmicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',6)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $ctoxicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',7)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cexantematicos = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',8)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cgenomica = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',9)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cram = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',10)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $czoonosis = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',11)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                                $cinmunohematologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',12)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->count();
                            }
                            else{
                                if($this->ceventos==''){
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                                else{
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_toma', '>=', $this->fechainicio)->where('fecha_toma','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                            }

                        }
                    }
                    if($this->controlf==2){
                        $resultados = $resultados->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $resultados->count();
                        if($this->csedes==''){
                            $cmicobacterias = Analitica::where('estado','=','A')->where('crns_id','=',1)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cinfluenza = Analitica::where('estado','=','A')->where('crns_id','=',2)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cbacteriologia = Analitica::where('estado','=','A')->where('crns_id','=',3)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cvectores = Analitica::where('estado','=','A')->where('crns_id','=',4)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cparasitologia = Analitica::where('estado','=','A')->where('crns_id','=',5)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cmicologia = Analitica::where('estado','=','A')->where('crns_id','=',6)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $ctoxicologia = Analitica::where('estado','=','A')->where('crns_id','=',7)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cexantematicos = Analitica::where('estado','=','A')->where('crns_id','=',8)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cgenomica = Analitica::where('estado','=','A')->where('crns_id','=',9)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cram = Analitica::where('estado','=','A')->where('crns_id','=',10)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $czoonosis = Analitica::where('estado','=','A')->where('crns_id','=',11)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            $cinmunohematologia = Analitica::where('estado','=','A')->where('crns_id','=',12)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                        }
                        else{
                            if($this->claboratorios==''){
                                $cmicobacterias = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',1)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cinfluenza = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',2)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cbacteriologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',3)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cvectores = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',4)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cparasitologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',5)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cmicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',6)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $ctoxicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',7)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cexantematicos = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',8)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cgenomica = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',9)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cram = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',10)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $czoonosis = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',11)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                                $cinmunohematologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',12)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->count();
                            }
                            else{
                                if($this->ceventos==''){
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                                else{
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                            }

                        }
                    }
                    if($this->controlf==3){
                        $resultados = $resultados->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin);
                        $count = $resultados->count();
                        if($this->csedes==''){
                            $cmicobacterias = Analitica::where('estado','=','A')->where('crns_id','=',1)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cinfluenza = Analitica::where('estado','=','A')->where('crns_id','=',2)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cbacteriologia = Analitica::where('estado','=','A')->where('crns_id','=',3)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cvectores = Analitica::where('estado','=','A')->where('crns_id','=',4)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cparasitologia = Analitica::where('estado','=','A')->where('crns_id','=',5)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cmicologia = Analitica::where('estado','=','A')->where('crns_id','=',6)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $ctoxicologia = Analitica::where('estado','=','A')->where('crns_id','=',7)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cexantematicos = Analitica::where('estado','=','A')->where('crns_id','=',8)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cgenomica = Analitica::where('estado','=','A')->where('crns_id','=',9)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cram = Analitica::where('estado','=','A')->where('crns_id','=',10)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $czoonosis = Analitica::where('estado','=','A')->where('crns_id','=',11)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            $cinmunohematologia = Analitica::where('estado','=','A')->where('crns_id','=',12)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                        }
                        else{
                            if($this->claboratorios==''){
                                $cmicobacterias = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',1)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cinfluenza = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',2)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cbacteriologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',3)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cvectores = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',4)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cparasitologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',5)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cmicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',6)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $ctoxicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',7)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cexantematicos = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',8)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cgenomica = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',9)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cram = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',10)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $czoonosis = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',11)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                                $cinmunohematologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',12)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->count();
                            }
                            else{
                                if($this->ceventos==''){
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                                else{
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_resultado', '>=', $this->fechainicio)->where('fecha_resultado','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                            }

                        }
                    }
                    if($this->controlf==4){
                        $resultados = $resultados->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin);
                        $count = $resultados->count();
                        if($this->csedes==''){
                            $cmicobacterias = Analitica::where('estado','=','A')->where('crns_id','=',1)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cinfluenza = Analitica::where('estado','=','A')->where('crns_id','=',2)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cbacteriologia = Analitica::where('estado','=','A')->where('crns_id','=',3)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cvectores = Analitica::where('estado','=','A')->where('crns_id','=',4)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cparasitologia = Analitica::where('estado','=','A')->where('crns_id','=',5)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cmicologia = Analitica::where('estado','=','A')->where('crns_id','=',6)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $ctoxicologia = Analitica::where('estado','=','A')->where('crns_id','=',7)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cexantematicos = Analitica::where('estado','=','A')->where('crns_id','=',8)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cgenomica = Analitica::where('estado','=','A')->where('crns_id','=',9)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cram = Analitica::where('estado','=','A')->where('crns_id','=',10)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $czoonosis = Analitica::where('estado','=','A')->where('crns_id','=',11)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            $cinmunohematologia = Analitica::where('estado','=','A')->where('crns_id','=',12)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                        }
                        else{
                            if($this->claboratorios==''){
                                $cmicobacterias = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',1)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cinfluenza = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',2)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cbacteriologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',3)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cvectores = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',4)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cparasitologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',5)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cmicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',6)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $ctoxicologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',7)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cexantematicos = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',8)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cgenomica = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',9)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cram = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',10)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $czoonosis = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',11)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                                $cinmunohematologia = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',12)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->count();
                            }
                            else{
                                if($this->ceventos==''){
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                                else{
                                    $countlab = $count;
                                    $countlabcum = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->count();
                                    $countlabrec = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',2)->count();
                                    $countlabpro = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
                                    $countlabana = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                    $countlabpen = Analitica::where('estado','=','A')->where('sedes_id','=',$this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos)->where('fecha_publicacion', '>=', $this->fechainicio)->where('fecha_publicacion','<=',$this->fechafin)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
                                }
                            }

                        }
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



        $resultados = $resultados->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.resultadogerencial.index', compact('count', 'resultados','rol','sedes','crns','eventos','sedes_up','cmicobacterias','cinfluenza','cbacteriologia','cvectores','cparasitologia','cmicologia','ctoxicologia','cexantematicos','cgenomica','cram','czoonosis','cinmunohematologia','countlab','countlabpro','countlabana','countlabpen','countlabrec','countlabcum'));
    }

    public function destroy($id)
    {
        try{
            $Resultados = Resultado::findOrFail($id);
            if(Storage::exists($Resultados->archivo)){
                Storage::delete($Resultados->archivo);
            }
            $Resultados->delete();
            $this->alert('success', 'Eliminación con exito');
        }catch(Exception $e){
            $this->alert('error',
                'Ocurrio un error en la eliminación: '.$e->getMessage(),
                [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entiendo',
                    'timer' => null,
                ]);
        }
    }
}
