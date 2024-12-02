<?php

namespace App\Http\Livewire\Recursoshumanos\Persona;

use App\Models\CoreBase\TipoDocumento;
use App\Models\CoreBase\Nacionalidad;
use App\Models\CoreBase\Sexo;
use App\Models\CoreBase\TipoSangre;
use App\Models\CoreBase\EstadoCivil;
use App\Models\RecursosHumanos\Persona;
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
    public $searchc;
    public $searchn;
    protected $queryString = ['searchc' => ['except' => ''], 'searchn' => ['except' => '']];

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
        $count = Persona::count();
        $Personas = Persona::orderBy('id', 'asc');

        if($this->searchn){
            $Personas = $Personas->where('nombres', 'LIKE', "%{$this->searchn}%")->orWhere('apellidos', 'LIKE', "%{$this->searchn}%");
            $count = Persona::where('nombres', 'LIKE', "%{$this->searchn}%")->orWhere('apellidos', 'LIKE', "%{$this->searchn}%")->count();
        }

        if($this->searchc){
            $Personas = $Personas->where('identidad', 'LIKE', "%{$this->searchc}%");
            $count = Persona::where('identidad', 'LIKE', "%{$this->searchc}%")->count();
        }

        $Personas = $Personas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.recursoshumanos.persona.index', compact('count', 'Personas'));
    }


    public function destroy(Persona $Personas)
    {
        try{
            $Personas->delete();
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
