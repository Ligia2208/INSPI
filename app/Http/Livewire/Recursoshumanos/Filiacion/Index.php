<?php

namespace App\Http\Livewire\Recursoshumanos\Filiacion;

use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\RecursosHumanos\Sede;
use App\Models\RecursosHumanos\Persona;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\CoreBase\Cargo;
use App\Models\RecursosHumanos\Escala;
use App\Models\RecursosHumanos\Modalidad;
use App\Models\CoreBase\TipoDiscapacidad;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $sedes;
    public $direcciones;
    public $gestiones;
    public $modalidades;
    public $escalas;
    public $cargos;
    public $searchi;
    public $searchn;
    protected $queryString = ['searchi' => ['except' => ''], 'searchn' => ['except' => ''], 'sedes' => ['except' => ''], 'direcciones' => ['except' => ''], 'gestiones' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    //Listeners
    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Filiacion::where('status','=','A')->count();
        $filiaciones = Filiacion::where('status','=','A')->orderBy('id', 'asc');
        $sedesc = Sede::where('status','=','A')->orderBy('id','ASC')->get();
        $areasc = Area::where('status','=','A')->orderBy('id','ASC')->get();
        $direccionesc = Direccion::where('status','=','A')->orderBy('id','ASC')->get();
        $modalidadesc = Modalidad::where('status','=','A')->orderBy('id','ASC')->get();
        $escalasc = Escala::where('status','=','A')->orderBy('id','ASC')->get();
        $cargosc = Cargo::where('status','=','A')->orderBy('id','ASC')->get();

        if($this->searchi){
            $datPers = Persona::where('status','=','A')->where('identidad','LIKE',"%{$this->searchi}%")->pluck('id')->toArray();
            $filiaciones = Filiacion::whereIn('persona_id', $datPers);
            $count = $filiaciones->count();
        }

        if($this->searchn){
            $datPers = Persona::where('nombres','LIKE',"%{$this->searchn}%")->orWhere('apellidos','LIKE',"%{$this->searchn}%")->pluck('id')->toArray();
            $filiaciones = Filiacion::whereIn('persona_id', $datPers);
            $count = $filiaciones->count();
        }

        if($this->sedes){
            $filiaciones = Filiacion::where('sede_id','=',$this->sedes);
            $count = $filiaciones->count();
        }

        if($this->direcciones){
            $filiaciones = Filiacion::where('area_id','=',$this->direcciones);
            $count = $filiaciones->count();
        }

        if($this->gestiones){
            $filiaciones = Filiacion::where('direccion_id','=',$this->gestiones);
            $count = $filiaciones->count();
        }

        if($this->modalidades){
            $filiaciones = Filiacion::where('modalidad_id','=',$this->modalidades);
            $count = $filiaciones->count();
        }

        if($this->escalas){
            $filiaciones = Filiacion::where('escala_id','=',$this->escalas);
            $count = $filiaciones->count();
        }

        if($this->cargos){
            $filiaciones = Filiacion::where('cargo_id','=',$this->cargos);
            $count = $filiaciones->count();
        }

        $filiaciones = $filiaciones->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.recursoshumanos.filiacion.index', compact('count', 'filiaciones','sedesc','areasc','direccionesc','modalidadesc','escalasc','cargosc'));
    }


    public function destroy(Filiacion $Filiaciones)
    {
        try{
            $Filiaciones->status='I';
            $Filiaciones->update();
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
