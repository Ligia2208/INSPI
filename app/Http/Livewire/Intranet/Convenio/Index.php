<?php

namespace App\Http\Livewire\Intranet\Convenio;

use App\Models\Intranet\Convenio;
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
    public $perPage = 12;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Convenio::where('estado','=','A')->count();
        $Convenios = Convenio::where('estado','=','A')->orderBy('id', 'asc');
        if($this->search){
            $Convenios = $Convenios->where('nombre', 'LIKE', "%{$this->search}%");
            $count = Convenio::where('estado','=','A')->where('nombre', 'LIKE', "%{$this->search}%")->count();

        }
        $Convenios = $Convenios->paginate($this->perPage);
        return view('livewire.intranet.convenio.index', compact('count', 'Convenios'));
    }

    public function destroy($id)
    {
        try{
            $Convenios = Convenio::findOrFail($id);
            if(Storage::exists($Convenios->archivo)){
                Storage::delete($Convenios->archivo);
            }
            $Convenios->delete();
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
