<?php

namespace App\Http\Livewire\Centrosreferencia\Analitica;

use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Muestra;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Sexo;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use App\Models\CentrosReferencia\Reporte;
use App\Models\CentrosReferencia\Tecnica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $method;

    //Tools
    public $Analiticas;
    public $eventos;
    public $tecnicas;
    public $cantones;
    public $reportes;
    public $crns;
    public $selectedSede = null;
    public $selectedCrn = null;
    public $selectedProvincia = null;


    protected $listeners = ['render'];

    protected function rules()
    {

        return [
            'Analiticas.sedes_id' => 'required|numeric',
            'Analiticas.crns_id' => 'required|numeric',
            'Analiticas.muestra_id' => 'required|numeric',
            'Analiticas.codigo_muestra' => 'required|max:15',
            'Analiticas.fecha_toma' => 'required|max:10',
            'Analiticas.anio_registro' => 'required|max:10',
            'Analiticas.fecha_llegada_lab' => 'required|max:10',
            'Analiticas.evento_id' => 'required|numeric',
            'Analiticas.tecnica_id' => 'required|numeric',
            'Analiticas.resultado_id' => 'required|numeric',
            'Analiticas.descripcion' => 'sometimes|max:2000',

        ];
    }

    public function mount(Analitica $Analiticas, $method){
        $this->Analiticas = $Analiticas;
        $this->method = $method;
        if($method=='update'){
            $config = SedeCrn::where('sedes_id','=',$this->Analiticas->sedes_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
            $this->tecnicas = Tecnica::where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->get();
            $this->reportes = Reporte::where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->get();
            $this->eventos = Evento::where('crns_id','=',$this->Analiticas->crns_id)->orderBy('id', 'asc')->get();

        }

    }

    public function updatedselectedSede($sede_id){
        $config = SedeCrn::where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrn($crns_id){
        $this->eventos = Evento::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedProvincia($provincia_id){
        $this->cantones = Canton::where('provincia_id','=',$provincia_id)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function render()
    {
        $sedes = Sede::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $muestras = Muestra::where('estado','=','A')->orderBy('id','asc')->cursor();
        return view('livewire.centrosreferencia.analitica.form', compact('sedes','muestras'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticas->fecha_resultado = date();
        $this->Analiticas->usuarior_id = $user;
        $this->Analiticas->save();
        $this->alert('success', 'Analitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('analitica.index');

    }

    public function update(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticas->fecha_resultado = date("Y-m-d");
        $this->Analiticas->usuarior_id = $user;
        $this->Analiticas->update();
        $this->alert('success', 'Analitica actualizado con éxito');
        $this->emit('closeModal');
        return redirect()->route('analitica.index');
    }

}
