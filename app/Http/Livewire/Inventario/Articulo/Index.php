<?php

namespace App\Http\Livewire\Inventario\Articulo;

use App\Models\User;
use App\Models\RecursosHumanos\Sede;
use App\Models\Inventario\Edificio;
use App\Models\Inventario\Sector;
use App\Models\Inventario\Clase;
use App\Models\Inventario\Marca;
use App\Models\Inventario\Origen;
use App\Models\Inventario\Estado;
use App\Models\Inventario\Articulo;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    //Tools
    public $perPage = 35;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

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
        $count = Articulo::count();
        $Articulos = Articulo::where('estadoregistro','=','A')->orderBy('id', 'asc');

        if($this->search){
            $Articulos = $Articulos->where('codigoinventario', 'LIKE', "%{$this->search}%")
            ->orWhere('nombre','LIKE',"%{$this->search}%")
            ->orWhere('codigoebye','LIKE',"%{$this->search}%");
            $count = Articulo::where('estadoregistro','=','A')
            ->where('codigoinventario', 'LIKE', "%{$this->search}%")
            ->orWhere('nombre','LIKE',"%{$this->search}%")
            ->orWhere('codigoebye','LIKE',"%{$this->search}%")->count();
        }

        $Articulos = $Articulos->paginate($this->perPage);
        $this->emit('renderJs');
        return view('livewire.inventario.articulo.index', compact('count', 'Articulos'));
    }


    public function destroy(Articulo $Articulos)
    {
        try{
            $Articulos->estadoregistro='I';
            $Articulos->update();
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
