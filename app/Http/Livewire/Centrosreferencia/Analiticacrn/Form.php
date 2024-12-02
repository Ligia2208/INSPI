<?php

namespace App\Http\Livewire\Centrosreferencia\Analiticacrn;

use App\Models\CentrosReferencia\Analitica;
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

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $method;

    //Tools
    public $Analiticacrns;
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
            'Analiticacrns.sedes_id' => 'required|numeric',
            'Analiticacrns.crns_id' => 'required|numeric',
            'Analiticacrns.id_paciente' => 'sometimes|max:10',
            'Analiticacrns.sexo_id' => 'required|numeric',
            'Analiticacrns.fecha_nac' => 'required|max:10',
            'Analiticacrns.provincia_id' => 'required|numeric',
            'Analiticacrns.canton_id' => 'required|numeric',
            'Analiticacrns.codigo_muestra' => 'required|max:15',
            'Analiticacrns.fecha_toma_muestra' => 'required|max:10',
            'Analiticacrns.fecha_llegada_lab' => 'required|max:10',
            'Analiticacrns.evento_id' => 'required|numeric',
            'Analiticacrns.tecnica_id' => 'required|numeric',
            'Analiticacrns.resultado_id' => 'required|numeric',
            'Analiticacrns.descripcion' => 'sometimes|max:2000',

        ];
    }

    public function mount(Analitica $analitica, $method){
        $this->Analiticacrns = $analitica;
        dd($this->Analiticacrns);
        $this->method = $method;
        if($method=='update'){
            $config = SedeCrn::where('sedes_id','=',$this->Analiticacrns->sedes_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();

            $this->eventos = Evento::where('crns_id','=',$this->Analiticacrns->crns_id)->orderBy('id', 'asc')->get();
            $this->tecnicas = Tecnica::where('crns_id','=',$this->Analiticacrns->crns_id)->orderBy('id', 'asc')->get();
            $this->reportes = Reporte::where('crns_id','=',$this->Analiticacrns->crns_id)->orderBy('id', 'asc')->get();

            $this->cantones = Canton::where('provincia_id','=',$this->Analiticacrns->provincia_id)->orderBy('id', 'asc')->get();
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


        return view('livewire.centrosreferencia.analiticacrn.form', compact('sedes','sexos','provincias'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticacrns->usuario_id = $user;
        $this->Analiticacrns->save();
        $this->alert('success', 'Analiticacrn agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('resultado.index');

    }

    public function update(){
        $this->validate();
        $this->Analiticacrns->update();
        $this->alert('success', 'Analiticacrn actualizado con éxito');
        $this->emit('closeModal');
        return redirect()->route('resultado.index');
    }

}
