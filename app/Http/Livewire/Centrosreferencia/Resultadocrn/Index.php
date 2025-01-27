<?php

namespace App\Http\Livewire\Centrosreferencia\Resultadocrn;

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

        if($rol == 'Administrador'){
            $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();
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
        }
        else{
            $sedes_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('sedes_id')->pluck('sedes_id')->toArray();
            $crns_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('crns_id')->pluck('crns_id')->toArray();
            $sedes = Sede::whereIn('id',$sedes_users)->orderBy('id', 'asc')->cursor();
        }

        $crns = [];
        $eventos = [];

        $sedes_up = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->count();
        if($rol == 'Administrador'){
            $count = Analitica::where('estado','=','A')->count();
            $resultados = Analitica::where('estado','=','A')->orderBy('id', 'asc');
        }
        else{
            $count = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->count();
            $resultados = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->orderBy('id', 'asc');
            $countlab = $count;
            $countlabcum = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('estado_muestra_id','=',1)->count();
            $countlabrec = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('estado_muestra_id','=',2)->count();
            $countlabpro = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','S')->count();
            $countlabana = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('estado_muestra_id','=',1)->where('usuarior_id','>',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();
            $countlabpen = Analitica::where('estado','=','A')->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->where('estado_muestra_id','=',1)->where('usuarior_id','=',0)->where('validado','=','N')->where('estado_muestra_id','=',1)->count();

        }

        if($this->search){
            $resultados = $resultados->where('codigo_muestra', 'LIKE', "%{$this->search}%");
            $count = $resultados->count();

        }
        if($this->csedes){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes);
            $count = $resultados->count();

            $crns_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->distinct('crns_id')->pluck('crns_id')->toArray();

            if($rol == 'Administrador'){
                $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
                $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
            }
            else{
                $config = SedeCrn::where('sedes_id','=',$this->csedes)->whereIn('crns_id',$crns_users)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
                $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
            }
        }
        if($this->claboratorios){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $resultados->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
        }

        if($this->ceventos){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $count = $resultados->count();
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

        $resultados = $resultados->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.resultadocrn.index', compact('count', 'resultados','rol','sedes','crns','eventos','sedes_up','cmicobacterias','cinfluenza','cbacteriologia','cvectores','cparasitologia','cmicologia','ctoxicologia','cexantematicos','cgenomica','cram','czoonosis','cinmunohematologia','countlab','countlabpro','countlabana','countlabpen','countlabrec','countlabcum'));
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
