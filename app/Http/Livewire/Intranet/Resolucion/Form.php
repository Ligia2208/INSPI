<?php

namespace App\Http\Livewire\Intranet\Resolucion;

use App\Models\Intranet\Resolucion;
use App\Models\Intranet\Director;
use App\Models\Intranet\Tiporesolucion;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $method;

    //Tools
    public $ResolucionTmp;
    public $Origenes;
    public $Resoluciones;
    public $Areas;


    protected $listeners = ['render'];

    protected function rules()
    {

        return [
            'Resoluciones.titulo' => 'required|max:400',
            'Resoluciones.numero' => 'required|max:75',
            'Resoluciones.anio' => 'required|numeric',
            'Resoluciones.fechafirma' => 'required|max:10',
            'Resoluciones.resolucion' => 'required|max:2500',
            'Resoluciones.director_id' => 'required|numeric',
            'Resoluciones.tipo_id' => 'required|numeric',

        ];
    }

    public function mount(Resolucion $resolucion, $method){
        $this->Resoluciones = $resolucion;
        $this->method = $method;

    }

    public function render()
    {
        $directores = Director::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $tipos = Tiporesolucion::where('estado','=','A')->orderBy('id', 'asc')->cursor();

        $this->emit('renderJs');
        return view('livewire.intranet.resolucion.form', compact('directores','tipos'));
    }


    public function store(){
        $this->validate();
        /* $this->validate([
            'ResolucionTmp' => 'required',
        ]); */
        $this->saveResolucion();
        $this->Resoluciones->save();
        session()->flash('alert', 'Resolucion agregada');
        session()->flash('alert-type', 'success');

        return redirect()->route('resolucion.index');
    }

    public function update(){
        $this->validate();
        $this->saveResolucion();
        $this->Resoluciones->update();
        session()->flash('alert', 'Resolucion actualizado con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('resolucion.index');
    }


    public function saveResolucion(){
        if($this->ResolucionTmp){
            if(Storage::exists($this->Resoluciones->archivo)){
                Storage::delete($this->Resoluciones->archivo);
            }

            $path = $this->ResolucionTmp->store('public/resoluciones/inspi');
            $this->Resoluciones->archivo = $path;
        }
    }

    public function removeResolucion(){
        if($this->Resoluciones->archivo){
            if(Storage::exists($this->Resoluciones->archivo)){
                Storage::delete($this->Resoluciones->archivo);
            }

            $this->Resoluciones->archivo = null;
            $this->Resoluciones->update();
        }
        $this->reset('ResolucionTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
