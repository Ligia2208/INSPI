<?php

namespace App\Http\Livewire\Centrosreferencia\Postanalitica;

use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Preanalitica;
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
            'Analiticas.evento_id' => 'required|numeric',
            'Analiticas.tecnica_id' => 'required|numeric',
            'Analiticas.resultado_id' => 'required|numeric',
            'Analiticas.descripcion' => 'sometimes|max:2000',
            'Analiticas.descripcion_responsable' => 'sometimes|max:2000',
            'Analiticas.eventosav_id' => ['sometimes', 'array'],

        ];
    }

    public function mount(Postanalitica $Analiticas, $method){
        $data = Preanalitica::findOrFail($Analiticas->id);
        $muestra = Analitica::where('preanalitica_id','=',$data->id)->pluck('codigo_muestra')->first();

        $this->Analiticas = $data;
        $this->Analiticas->codigo_muestra = str_pad($muestra, 6, "0", STR_PAD_LEFT);
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
        return view('livewire.centrosreferencia.postanalitica.form', compact('sedes','muestras'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticas->fecha_resultado = date();
        $this->Analiticas->usuarior_id = $user;
        $this->Analiticas->save();
        $this->alert('success', 'Analitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('postanalitica.index');

    }

    public function update(){

        $analiticas = Analitica::where('preanalitica_id','=',$this->Analiticas->id)->get();
        $user = auth()->user()->id;
        $i=0;
        $preanalitica = Preanalitica::findOrFail($this->Analiticas->id);
        if($preanalitica->resultado_id==67 && ($preanalitica->evento_id==116 || $preanalitica->evento_id==117 || $preanalitica->evento_id==118 || $preanalitica->evento_id==119 || $preanalitica->evento_id==120 || $preanalitica->evento_id==125)){
                $lista = $this->Analiticas->eventosav_id;
                $total = count($lista);
                if($total>0){
                    while($i<$total){
                        try{
                            $objPreanalitica = Preanalitica::findOrFail($this->Analiticas->id);
                            $newPreanalitica = new Preanalitica();
                            $newPreanalitica->instituciones_id =  $objPreanalitica->instituciones_id;
                            $newPreanalitica->fecha_atencion = $objPreanalitica->fecha_atencion;
                            $newPreanalitica->quien_notifica = $objPreanalitica->quien_notifica;
                            $newPreanalitica->paciente_id = $objPreanalitica->paciente_id;
                            $newPreanalitica->probable_infeccion = $objPreanalitica->probable_infeccion;
                            $newPreanalitica->fecha_sintomas = $objPreanalitica->fecha_sintomas;
                            $newPreanalitica->embarazo = $objPreanalitica->embarazo;
                            $newPreanalitica->gestacion = $objPreanalitica->gestacion;
                            $newPreanalitica->laboratorio = $objPreanalitica->laboratorio;
                            $newPreanalitica->nombre_laboratorio = $objPreanalitica->nombre_laboratorio;
                            $newPreanalitica->sedes_id = $objPreanalitica->sedes_id;
                            $newPreanalitica->crns_id = $objPreanalitica->crns_id;
                            $newPreanalitica->evento_id = $this->Analiticas->eventosav_id[$i];
                            $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                            $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                            $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                            $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                            $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
                            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                            $newPreanalitica->usuariot_id = $objPreanalitica->usuariot_id;
                            $newPreanalitica->save();

                            $Analiticas = Analitica::where('preanalitica_id','=',$this->Analiticas->id)->first();
                            $newAnalitica = new Analitica();
                            $newAnalitica->preanalitica_id = $newPreanalitica->id;
                            $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                            $newAnalitica->crns_id = $objPreanalitica->crns_id;
                            $newAnalitica->evento_id = $this->Analiticas->eventosav_id[$i];
                            $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                            $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                            $newAnalitica->codigo_muestra = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,12);
                            $newAnalitica->codigo_secuencial = 1;
                            $newAnalitica->codigo_externo = 'EXAN-AMPLIADA';
                            $newAnalitica->usuariot_id = $objPreanalitica->usuariot_id;
                            $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                            $newAnalitica->save();

                            $newPreanalitica->campliada=$Analiticas->codigo_muestra;
                            $newPreanalitica->update();

                            $objPreanalitica->campliada=$newPreanalitica->id;
                            $objPreanalitica->update();

                        }
                        catch(Exception $e){
                            $this->alert('error',
                                'Ocurrio un error en la generación: '.$e->getMessage(),
                                [
                                    'showConfirmButton' => true,
                                    'confirmButtonText' => 'Entiendo',
                                    'timer' => null,
                                ]);
                        }
                        $i=$i+1;
                    }
                    $preanalitica->campliada=$analiticas[0]->codigo_muestra;
                    $preanalitica->update();
                    $this->alert('success', 'Eventos para investigación ampliada generados con éxito');
                    $this->emit('closeModal');
                }
                else{

                }
        }
        else{
            foreach($analiticas as $ana){
                $ana->descripcion_responsable = $this->Analiticas->descripcion;
                $ana->usuariop_id = $user;
                $ana->fecha_publicacion = date("Y-m-d");
                $ana->validado = 'S';
                $ana->update();
            }

            $preanalitica_update = Preanalitica::findOrFail($this->Analiticas->id);
            $preanalitica_update->resultado_id=$this->Analiticas->resultado_id;
            $preanalitica_update->descripcion=$this->Analiticas->descripcion_responsable;
            $preanalitica_update->fecha_resultado = date("Y-m-d");
            $preanalitica_update->usuarior_id = $user;
            $preanalitica_update->validado = 'S';
            $preanalitica_update->update();

            $this->alert('success', 'Analitica actualizado con éxito');
            $this->emit('closeModal');
        }
        return redirect()->route('postanalitica.index');
    }

    public function sgte_codigomuestra($anio, $sede, $crn){
        $max = Analitica::where('estado','=','A')->where('anio_registro','=',$anio)->where('sedes_id','=',$sede)->where('crns_id','=',$crn)->max('codigo_muestra');
        return $max+1;
    }

}
