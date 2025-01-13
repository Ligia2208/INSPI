<?php

namespace App\Http\Livewire\Centrosreferencia\Preanalitica;

use App\Models\CentrosReferencia\Preanalitica;
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
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];

        $count = Preanalitica::where('estado','=','A')->count();
        $preanaliticas = Preanalitica::where('estado','=','A')->orderBy('id', 'desc');

        if($this->search){
            $preanaliticas = $preanaliticas->where('codigo_muestra', 'LIKE', "%{$this->search}%");
            $count = $preanaliticas->count();

        }
        if($this->csedes){
            $preanaliticas = $preanaliticas->where('sedes_id', '=', $this->csedes);
            $count = $preanaliticas->count();
            $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        }
        if($this->claboratorios){
            $preanaliticas = $preanaliticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $preanaliticas->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
        }

        if($this->ceventos){
            $preanaliticas = $preanaliticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $count = $preanaliticas->count();
        }

        if($this->fechainicio){
            if ($this->fechafin){
                if ($this->fechainicio <= $this->fechafin){
                    if($this->controlf==0){
                        $this->fechainicio='';
                        $this->fechafin='';
                    }
                    if($this->controlf==1){
                        $preanaliticas = $preanaliticas->where('fecha_toma_muestra', '>=', $this->fechainicio)->where('fecha_toma_muestra','<=',$this->fechafin);
                        $count = $preanaliticas->count();

                    }
                    if($this->controlf==2){
                        $preanaliticas = $preanaliticas->where('fecha_llegada_lab', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $preanaliticas->count();
                    }
                    if($this->controlf==3){
                        $preanaliticas = $preanaliticas->where('created_at', '>=', $this->fechainicio)->where('created_at','<=',$this->fechafin);
                        $count = $preanaliticas->count();
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

        $preanaliticas = $preanaliticas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.preanalitica.index', compact('count', 'preanaliticas','sedes','crns','eventos'));
    }

    public function destroy($id)
    {
        try{
            $analiticas = Analitica::where('preanalitica_id','=',$id)->where('usuarior_id','>',0);
            $control = $analiticas->count();
            if($control>0){
                $this->alert('warning', 'Una o mas muestras ya han sido procesadas');

            }
            else{
                $Preanaliticas = Preanalitica::findOrFail($id);
                $Preanaliticas->estado='I';
                $Preanaliticas->update();
                $analiticas = Analitica::where('preanalitica_id','=',$id)->where('usuarior_id','=',0)->get();

                foreach($analiticas as $objAna){
                    $objAna->estado='I';
                    $objAna->update();
                }
                $this->alert('success', 'Eliminación con exito');
            }
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
