<?php

namespace App\Http\Livewire\Centrosreferencia\Preanaliticacd4;

use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Pacientetemp;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use DB;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $userPresent;

    //Tools
    public $perPage = 25;
    public $search;
    public $searchc;

    protected $queryString = ['search' => ['except' => ''],'searchc' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Pacientetemp::where('estado','=','A')->count();
        $cargapacientes = Pacientetemp::where('estado','=','A')->orderBy('id', 'asc');

        if($this->searchc){
            $pacientes = Paciente::where(function ($query){
                $query->where('identidad', 'LIKE', "%{$this->searchc}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $cargapacientes = $cargapacientes->whereIn('paciente_id',$pacientes);
            $count = $cargapacientes->count();

        }

        if($this->search){
            $pacientes = Paciente::where(function ($query){
                $query->where('apellidos', 'LIKE', "%{$this->search}%")
                  ->orWhere('nombres', 'LIKE', "%{$this->search}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $cargapacientes = $cargapacientes->whereIn('paciente_id',$pacientes);
            $count = $cargapacientes->count();

        }

        $cargapacientes = $cargapacientes->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.preanaliticacd4.index', compact('count', 'cargapacientes'));
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
