<?php

namespace App\Http\Livewire\Centrosreferencia\Analitica;

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
        $sedes_users = Responsable::where('estado','=','A')->where('tipo_id','=',1)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('sedes_id')->pluck('sedes_id')->toArray();
        $crns_users = Responsable::where('estado','=','A')->where('tipo_id','=',1)->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->distinct('crns_id')->pluck('crns_id')->toArray();
        $sedes = Sede::whereIn('id',$sedes_users)->orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];
        $sedes_up = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->where('vigente_hasta','=',null)->count();

        $count = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->count();
        $analiticas = Analitica::where('estado','=','A')->where('usuarior_id','>=',0)->whereIn('sedes_id',$sedes_users)->whereIn('crns_id',$crns_users)->orderBy('id', 'desc');

        if($this->search){
            $analiticas = $analiticas->where('codigo_muestra', 'LIKE', "%{$this->search}%");
            $count = $analiticas->count();

        }
        if($this->csedes){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes);
            $count = $analiticas->count();
            $crns_users = Responsable::where('estado','=','A')->where('usuario_id','=',$iduser)->distinct('crns_id')->pluck('crns_id')->toArray();
            $config = SedeCrn::where('sedes_id','=',$this->csedes)->whereIn('crns_id',$crns_users)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        }
        if($this->claboratorios){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $analiticas->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
        }

        if($this->ceventos){
            $analiticas = $analiticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $count = $analiticas->count();
        }

        if($this->fechainicio){
            if ($this->fechafin){
                if ($this->fechainicio <= $this->fechafin){
                    if($this->controlf==0){
                        $this->fechainicio='';
                        $this->fechafin='';
                    }
                    if($this->controlf==1){
                        $analiticas = $analiticas->where('fecha_toma_muestra', '>=', $this->fechainicio)->where('fecha_toma_muestra','<=',$this->fechafin);
                        $count = $analiticas->count();

                    }
                    if($this->controlf==2){
                        $analiticas = $analiticas->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $analiticas->count();
                    }
                    if($this->controlf==3){
                        $analiticas = $analiticas->where('created_at', '>=', $this->fechainicio)->where('created_at','<=',$this->fechafin);
                        $count = $analiticas->count();
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

        $analiticas = $analiticas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.analitica.index', compact('count', 'analiticas','sedes','crns','eventos'));
    }

    public function destroy($id)
    {
        try{
            $Analiticas = Analitica::findOrFail($id);
            $Analiticas->estado = 'I';
            $Analiticas->update();
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
    public function duplicate($id)
    {
        try{
            $Analiticas = Analitica::findOrFail($id);
            $newAnalitica = new Analitica();
            $newAnalitica->preanalitica_id = $Analiticas->preanalitica_id;
            $newAnalitica->sedes_id = $Analiticas->sedes_id;
            $newAnalitica->crns_id = $Analiticas->crns_id;
            $newAnalitica->evento_id = $Analiticas->evento_id;
            $newAnalitica->muestra_id = $Analiticas->muestra_id;
            $newAnalitica->anio_registro = $Analiticas->anio_registro;
            $newAnalitica->codigo_muestra = $Analiticas->codigo_muestra;
            $newAnalitica->codigo_secuencial = $Analiticas->codigo_secuencial;
            $newAnalitica->codigo_externo = $Analiticas->codigo_externo;
            $newAnalitica->tecnica_id = $Analiticas->tecnica_id;
            $newAnalitica->resultado_id = $Analiticas->resultado_id;
            $newAnalitica->descripcion = $Analiticas->descripcion;
            $newAnalitica->descripcion_responsable = $Analiticas->descripcion_responsable;
            $newAnalitica->usuariot_id = $Analiticas->usuariot_id;
            $newAnalitica->fecha_toma = $Analiticas->fecha_toma;
            $newAnalitica->fecha_llegada_lab = $Analiticas->fecha_llegada_lab;
            $newAnalitica->usuarior_id = $Analiticas->usuarior_id;
            $newAnalitica->fecha_resultado = $Analiticas->fecha_resultado;
            $newAnalitica->usuariop_id = $Analiticas->usuariop_id;
            $newAnalitica->fecha_publicacion = $Analiticas->fecha_publicacion;
            $newAnalitica->save();

            $this->alert('success', 'Registro duplicado con exito');
        }catch(Exception $e){
            $this->alert('error',
                'Ocurrio un error en la duplicación: '.$e->getMessage(),
                [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entiendo',
                    'timer' => null,
                ]);
        }
    }
}
