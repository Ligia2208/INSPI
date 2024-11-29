<?php

namespace App\Http\Livewire\Centrosreferencia\Resultado;

use App\Models\CentrosReferencia\Resultado;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Crn;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

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
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];

        //$count = Resultado::where('estado','=','A')->count();
        //$resultados = Resultado::where('estado','=','A')->orderBy('id', 'asc');

        $count = Analitica::where('estado','=','A')->where('validado','=','S')->count();
        $resultados = Analitica::where('estado','=','A')->where('validado','=','S')->orderBy('id', 'asc');

        if($this->search){
            $resultados = $resultados->where('codigo_muestra', 'LIKE', "%{$this->search}%");
            $count = $resultados->count();

        }
        if($this->csedes){
            $resultados = $resultados->where('sedes_id', '=', $this->csedes);
            $count = $resultados->count();
            $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
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
                        $resultados = $resultados->where('fecha_toma_muestra', '>=', $this->fechainicio)->where('fecha_toma_muestra','<=',$this->fechafin);
                        $count = $resultados->count();

                    }
                    if($this->controlf==2){
                        $resultados = $resultados->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $resultados->count();
                    }
                    if($this->controlf==3){
                        $resultados = $resultados->where('created_at', '>=', $this->fechainicio)->where('created_at','<=',$this->fechafin);
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

        return view('livewire.centrosreferencia.resultado.index', compact('count', 'resultados','sedes','crns','eventos'));
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
