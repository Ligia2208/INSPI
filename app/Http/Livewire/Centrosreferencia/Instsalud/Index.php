<?php

namespace App\Http\Livewire\Centrosreferencia\Instsalud;

use App\Models\CentrosReferencia\Institucion;
use App\Models\CoreBase\Nacionalidad;
use App\Models\CoreBase\Sexo;
use App\Models\CoreBase\TipoSangre;
use App\Models\CoreBase\EstadoCivil;
use App\Models\CentrosReferencia\Paciente;
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
        $Instituciones = Institucion::where('estado','=','A')->orderBy('id', 'asc');
        $count = $Instituciones->count();

        if($this->searchn){
            /* $Pacientes = $Pacientes->where('nombres', 'LIKE', "%{$this->searchn}%")->orWhere('apellidos', 'LIKE', "%{$this->searchn}%");
            $count = Paciente::where('nombres', 'LIKE', "%{$this->searchn}%")->orWhere('apellidos', 'LIKE', "%{$this->searchn}%")->count(); */
        }

        if($this->searchc){
            /*$Pacientes = $Pacientes->where('identidad', 'LIKE', "%{$this->searchc}%");
            $count = Paciente::where('identidad', 'LIKE', "%{$this->searchc}%")->count(); */
        }

        $Instituciones = $Instituciones->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.instsalud.index', compact('count', 'Instituciones'));
    }


    public function destroy(Institucion $Instituciones)
    {
        try{
            $Instituciones->estado='I';
            $Instituciones->update();
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
