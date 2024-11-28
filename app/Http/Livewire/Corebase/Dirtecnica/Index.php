<?php

namespace App\Http\Livewire\Corebase\Dirtecnica;

use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Direcciontecnica;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $searchd;
    public $searcht;
    protected $queryString = ['searchd' => ['except' => ''], 'searcht' => ['except' => '']];

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
        $count = Direcciontecnica::where('status','=','A')->count();
        $direcciones = Direcciontecnica::where('status','=','A')->orderBy('id', 'asc');

        if($this->searchd){
            $datDirec = Direccion::where('nombre', 'LIKE', "%{$this->searchd}%")->pluck('id')->toArray();
            $direcciones = $direcciones->whereIn('direccion_id', $datDirec);
        }

        if($this->searcht){
            $direcciones = $direcciones->where('nombre', 'LIKE', "%{$this->searcht}%");
        }

        $direcciones = $direcciones->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.corebase.dirtecnica.index', compact('count', 'direcciones'));
    }

    public function destroy(Direcciontecnica $Direcciones)
    {
        try{
            $Direcciones->status='I';
            $Direcciones->update();
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
