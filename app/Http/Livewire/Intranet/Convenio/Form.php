<?php

namespace App\Http\Livewire\Intranet\Convenio;

use App\Models\Intranet\Convenio;
use App\Models\Intranet\Ambito;
use App\Models\Intranet\Institucion;
use App\Models\Intranet\Estado;
use App\Models\Intranet\Tipo;
use App\Models\Intranet\Ies;
use App\Models\Intranet\Sector;
use App\Models\Intranet\Ubicacion;
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
    public $ConvenioTmp;
    public $Origenes;
    public $Convenios;
    public $Areas;


    protected $listeners = ['render'];

    protected function rules()
    {

        return [
            'Convenios.nombre' => 'required|max:750',
            'Convenios.institucionprincipal_id' => 'required|numeric',
            'Convenios.institucionsecundaria_id' => 'required|numeric',
            'Convenios.tipoconvenio_id' => 'required|numeric',
            'Convenios.tiempovigencia' => 'required|numeric',
            'Convenios.fechafirma' => 'required',
            'Convenios.fechavigencia' => 'required',
            'Convenios.ambitoconvenio_id' => 'required|numeric',
            'Convenios.objetivo' => 'required|max:1500',
            'Convenios.acuerdos' => 'required|max:1500',
            'Convenios.acuerdosexternos' => 'required|max:1500',
            'Convenios.contactointerno_id' => 'required|numeric',
            'Convenios.contactoexterno' => 'required|max:175',
            'Convenios.correoexterno' => 'required|max:175',
            'Convenios.estadoconvenio_id' => 'required|numeric',
            'Convenios.articulaies_id' => 'required|numeric',
            'Convenios.articulasector_id' => 'required|numeric',
            'Convenios.articulaubica_id' => 'required|numeric',
        ];
    }

    public function mount(Convenio $Convenio, $method){
        $this->Convenios = $Convenio;
        $this->method = $method;

    }

    public function render()
    {
        $instituciones = Institucion::orderBy('id', 'asc')->cursor();
        $ambitos = Ambito::orderBy('id', 'asc')->cursor();
        $tipos = Tipo::orderBy('id', 'asc')->cursor();
        $users = User::orderBy('id', 'asc')->cursor();
        $estados = Estado::orderBy('id', 'asc')->cursor();
        $ies = Ies::orderBy('id', 'asc')->cursor();
        $sectores = Sector::orderBy('id', 'asc')->cursor();
        $ubicaciones = Ubicacion::orderBy('id', 'asc')->cursor();

        $this->emit('renderJs');
        return view('livewire.intranet.convenio.form', compact('estados','users','instituciones','ambitos','tipos','ies','sectores','ubicaciones'));
    }


    public function store(){
        $this->validate();
        $this->validate([
            'ConvenioTmp' => 'required',
        ]);
        $this->saveConvenio();
        $this->Convenios->save();
        session()->flash('alert', 'Convenio agregada');
        session()->flash('alert-type', 'success');

        return redirect()->route('convenio.show', $this->Convenios);
    }

    public function update(){
        $this->validate();
        $this->saveConvenio();
        $this->Convenios->update();
        session()->flash('alert', 'Convenio actualizado con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('convenio.show', $this->Convenios);
    }


    public function saveConvenio(){
        if($this->ConvenioTmp){
            if(Storage::exists($this->Convenios->archivo)){
                Storage::delete($this->Convenios->archivo);
            }

            $path = $this->ConvenioTmp->store('public/convenios/inspi');
            $this->Convenios->archivo = $path;
        }
    }

    public function removeConvenio(){
        if($this->Convenios->archivo){
            if(Storage::exists($this->Convenios->archivo)){
                Storage::delete($this->Convenios->archivo);
            }

            $this->Convenios->archivo = null;
            $this->Convenios->update();
        }
        $this->reset('ConvenioTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
