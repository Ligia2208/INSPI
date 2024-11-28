<?php

namespace App\Http\Livewire\Corebase\Direccion;

use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Area;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $searcha;
    public $searchd;
    protected $queryString = ['searcha' => ['except' => ''], 'searchd' => ['except' => '']];

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
        $count = Direccion::count();
        $direcciones = Direccion::where('status','=','A')->orderBy('id', 'asc');

        if($this->searcha){
            $datAreas = Area::where('status','=','A')->where('nombre', 'LIKE', "%{$this->searcha}%")->pluck('id')->toArray();
            $direcciones = $direcciones->whereIn('area_id', $datAreas);
        }

        if($this->searchd){
            $direcciones = $direcciones->where('nombre', 'LIKE', "%{$this->searchd}%");
        }

        $direcciones = $direcciones->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.corebase.direccion.index', compact('count', 'direcciones'));
    }

    public function destroy(Direccion $direcciones)
    {
        try{
            $direcciones->status='I';
            $direcciones->update();
            $this->alert('success', 'Dirección eliminada con éxito');
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
