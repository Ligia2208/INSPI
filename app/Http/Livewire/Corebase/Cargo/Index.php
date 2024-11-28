<?php

namespace App\Http\Livewire\Corebase\Cargo;

use App\Models\CoreBase\Cargo;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $searchc;
    public $searcha;
    public $searchd;
    protected $queryString = ['searchc' => ['except' => ''], 'searcha' => ['except' => ''], 'searchd' => ['except' => '']];

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
        $count = Cargo::where('status','=','A')->count();
        $cargos = Cargo::where('status','=','A')->orderBy('id', 'asc');


        if($this->searchc){
            $cargos = $cargos->where('nombre', 'LIKE', "%{$this->searchc}%");
            $count = $cargos->count();
        }

        if($this->searcha){
            $datArea = Area::where('nombre', 'LIKE', "%{$this->searcha}%")->pluck('id')->toArray();
            $cargos = $cargos->whereIn('area_id', $datArea);
            $count = $cargos->count();
        }

        if($this->searchd){
            $datDirec = Direccion::where('nombre', 'LIKE', "%{$this->searchd}%")->pluck('id')->toArray();
            $cargos = $cargos->whereIn('direccion_id', $datDirec);
            $count = $cargos->count();
        }

        $cargos = $cargos->paginate($this->perPage);

        return view('livewire.corebase.cargo.index', compact('count', 'cargos'));
    }

    public function destroy(Cargo $Cargos)
    {
        try{
            $Cargos->status='I';
            $Cargos->update();
            $this->alert('success', 'Cargo Eliminado con exito');
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
