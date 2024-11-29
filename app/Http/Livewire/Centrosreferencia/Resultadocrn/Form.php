<?php

namespace App\Http\Livewire\Centrosreferencia\Resultadocrn;

use App\Models\CentrosReferencia\Resultado;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Semana;
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

class Form extends Component
{

    use WithFileUploads;

    public $method;

    //Tools
    public $Resultados;
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
            'Resultados.sedes_id' => 'required|numeric',
            'Resultados.crns_id' => 'required|numeric',
            'Resultados.id_paciente' => 'sometimes|max:10',
            'Resultados.sexo_id' => 'required|numeric',
            'Resultados.fecha_nac' => 'required|max:10',
            'Resultados.provincia_id' => 'required|numeric',
            'Resultados.canton_id' => 'required|numeric',
            'Resultados.codigo_muestra' => 'required|max:15',
            'Resultados.fecha_toma_muestra' => 'required|max:10',
            'Resultados.fecha_llegada_lab' => 'required|max:10',
            'Resultados.evento_id' => 'required|numeric',
            'Resultados.tecnica_id' => 'required|numeric',
            'Resultados.resultado_id' => 'required|numeric',
            'Resultados.descripcion' => 'sometimes|max:2000',

        ];
    }

    public function mount(Resultado $Resultado, $method){
        $this->Resultados = $Resultado;
        $this->method = $method;
        if($method=='update'){
            $config = SedeCrn::where('sedes_id','=',$this->Resultados->sedes_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();

            $this->eventos = Evento::where('crns_id','=',$this->Resultados->crns_id)->orderBy('id', 'asc')->get();
            $this->tecnicas = Tecnica::where('crns_id','=',$this->Resultados->crns_id)->orderBy('id', 'asc')->get();
            $this->reportes = Reporte::where('crns_id','=',$this->Resultados->crns_id)->orderBy('id', 'asc')->get();

            $this->cantones = Canton::where('provincia_id','=',$this->Resultados->provincia_id)->orderBy('id', 'asc')->get();
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
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $sexos = Sexo::orderBy('id', 'asc')->cursor();
        $provincias = Provincia::orderBy('id', 'asc')->cursor();

        //$crns = Crn::orderBy('id', 'asc')->cursor();
        //$eventos = Evento::orderBy('id', 'asc')->cursor();
        //$cantones = Canton::orderBy('id', 'asc')->cursor();
        //$reportes = Reporte::orderBy('id', 'asc')->cursor();
        //$tecnicas = Tecnica::orderBy('id', 'asc')->cursor();

        return view('livewire.centrosreferencia.resultadocrn.form', compact('sedes','sexos','provincias'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Resultados->usuario_id = $user;
        $this->Resultados->save();
        $this->alert('success', 'Resultado agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('resultado.index');

    }

    public function update(){
        $this->validate();
        $this->Resultados->update();
        $this->alert('success', 'Resultado actualizado con éxito');
        $this->emit('closeModal');
        return redirect()->route('resultado.index');
    }

}
