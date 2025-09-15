<?php

namespace App\Http\Livewire\Centrosreferencia\Analiticap;

use App\Models\CentrosReferencia\Analiticap;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\Muestra;
use App\Models\CentrosReferencia\Clase;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Sexo;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use App\Models\CentrosReferencia\Reporte;
use App\Models\CentrosReferencia\Tecnica;
use App\Models\CentrosReferencia\Estadomuestra;
use App\Models\CentrosReferencia\Unidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;
use DB;
use Datetime;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $method;

    //Tools
    public $Analiticasp;
    public $eventos;
    public $tecnicas;
    public $cantones;
    public $reportes;
    public $crns;
    public $selectedSede = null;
    public $selectedCrn = null;
    public $selectedProvincia = null;
    public $AnaliticaTmp;

    protected $listeners = ['render'];

    protected function rules()
    {

        return [
            'Analiticasp.sedes_id' => 'required|numeric',
            'Analiticasp.crns_id' => 'required|numeric',
            'Analiticasp.muestra_id' => 'required|numeric',
            'Analiticasp.clase_id' => 'required|numeric',
            'Analiticasp.estado_muestra_id' => 'required|numeric',
            'Analiticasp.codigo_muestra' => 'required|numeric',
            'Analiticasp.codigo_secuencial' => 'required|numeric',
            'Analiticasp.codigo_externo' => 'sometimes|max:25',
            'Analiticasp.fecha_toma' => 'required|max:10',
            'Analiticasp.anio_registro' => 'required|max:10',
            'Analiticasp.fecha_llegada_lab' => 'required|max:10',
            'Analiticasp.fecha_procesamiento' => 'required|max:10',
            'Analiticasp.evento_id' => 'required|numeric',
            'Analiticasp.tecnica_id' => 'required|numeric',
            'Analiticasp.resultado_id' => 'required|numeric',
            'Analiticasp.descripcion' => 'sometimes|max:2000',
            'Analiticasp.identificado' => 'sometimes|max:200',
            'Analiticasp.recomendacion_bacterio' => 'sometimes|max:200',
            'Analiticasp.carga_viral' => 'sometimes|numeric',
            'Analiticasp.unidades_id' => 'sometimes|numeric',
            'Analiticasp.recomendacion_inmuno' => 'sometimes|max:200',

            'Analiticasp.tecnica_segunda_id' => 'sometimes|numeric',
            'Analiticasp.resultado_segunda_id' => 'sometimes|numeric',

            'Analiticasp.tecnica_tercera_id' => 'sometimes|numeric',
            'Analiticasp.resultado_tercera_id' => 'sometimes|numeric',

            'Analiticasp.tecnica_cuarta_id' => 'sometimes|numeric',
            'Analiticasp.resultado_cuarta_id' => 'sometimes|numeric',

        ];
    }

    public function mount(Analiticap $analitica, $method){
        $this->Analiticasp = $analitica;
        $this->method = $method;

        if($this->Analiticasp->tecnica_segunda_id == 0){
            $this->Analiticasp->tecnica_segunda_id = 0;
            $this->Analiticasp->resultado_segunda_id = 0;
        }

        if($this->Analiticasp->tecnica_tercera_id == 0){
            $this->Analiticasp->tecnica_tercera_id = 0;
            $this->Analiticasp->resultado_tercera_id = 0;
        }

        if($this->Analiticasp->tecnica_cuarta_id == 0){
            $this->Analiticasp->tecnica_cuarta_id = 0;
            $this->Analiticasp->resultado_cuarta_id = 0;
        }

        if($method=='update'){
            $config = SedeCrn::where('sedes_id','=',$this->Analiticasp->sedes_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
            $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$this->Analiticasp->crns_id)->orderBy('id', 'asc')->get();
            $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$this->Analiticasp->crns_id)->orderBy('id', 'asc')->get();
            $this->eventos = Evento::whereIn('estado',['A','M'])->where('crns_id','=',$this->Analiticasp->crns_id)->orderBy('id', 'asc')->get();

        }

    }

    public function updatedselectedSede($sede_id){
        $config = SedeCrn::where('sedes_id','=',$sede_id)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
        $this->crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        $this->emit('renderJs');
    }

    public function updatedselectedCrn($crns_id){
        $this->eventos = Evento::whereIn('estado',['A','M'])->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->tecnicas = Tecnica::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
        $this->reportes = Reporte::where('estado','=','A')->where('crns_id','=',$crns_id)->orderBy('id', 'asc')->get();
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
        $preanalitica = Preanalitica::findOrFail($this->Analiticasp->preanalitica_id);
        $estados = Estadomuestra::orderBy('id', 'asc')->cursor();
        $unidades = Unidades::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        $clases = Clase::where('estado','=','A')->orderBy('id', 'asc')->cursor();
        return view('livewire.centrosreferencia.analiticap.form', compact('sedes','muestras','preanalitica','estados','unidades','clases'));
    }

    public function store(){
        $this->validate();
        $user = auth()->user()->id;
        $this->Analiticasp->fecha_resultado = date();
        $this->Analiticasp->usuarior_id = $user;
        $this->saveAnalitica();
        $this->Analiticasp->save();
        $this->alert('success', 'Analitica agregado con éxito');
        $this->emit('closeModal');
        return redirect()->route('analitica.index');

    }

    public function update(){
        $lista = [];
        $user = auth()->user()->id;
        DB::beginTransaction();
        try{
            if($this->Analiticasp->resultado_id==67 && ($this->Analiticasp->evento_id==116 || $this->Analiticasp->evento_id==117 || $this->Analiticasp->evento_id==118 || $this->Analiticasp->evento_id==119 || $this->Analiticasp->evento_id==120 || $this->Analiticasp->evento_id==125)){
                $absede = Sede::findOrFail($this->Analiticasp->sedes_id);
                $abcrn = Crn::findOrFail(8);
                $lista = $this->Analiticasp->eventosav_id;
                $total = count($lista);
                $muestraorigen = $this->Analiticasp->codigo_muestra;
                $i=0;
                if($total>0){
                    while($i<$total){
                        try{
                            $objPreanalitica = Preanalitica::findOrFail($this->Analiticasp->preanalitica->id);
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
                            $newPreanalitica->evento_id = $lista[$i];
                            $newPreanalitica->anio_registro = $objPreanalitica->anio_registro;
                            $newPreanalitica->primera_id = $objPreanalitica->primera_id;
                            $newPreanalitica->clase_primera_id = $objPreanalitica->clase_primera_id;
                            $newPreanalitica->fecha_toma_primera = $objPreanalitica->fecha_toma_primera;
                            $newPreanalitica->estado_primera_id = $objPreanalitica->estado_primera_id;
                            $newPreanalitica->observacion_primera = $objPreanalitica->observacion_primera;
                            $newPreanalitica->campliada = $muestraorigen;
                            $newPreanalitica->fecha_recepcion = $objPreanalitica->fecha_recepcion;
                            $newPreanalitica->usuariot_id = $user;
                            $newPreanalitica->save();

                            $Analiticasp = Analitica::where('preanalitica_id','=',$newPreanalitica->id)->first();
                            $newAnalitica = new Analitica();
                            $newAnalitica->preanalitica_id = $newPreanalitica->id;
                            $newAnalitica->sedes_id = $objPreanalitica->sedes_id;
                            $newAnalitica->crns_id = $objPreanalitica->crns_id;
                            $newAnalitica->evento_id = $lista[$i];
                            $newAnalitica->muestra_id = $objPreanalitica->primera_id;
                            $newAnalitica->anio_registro = $objPreanalitica->anio_registro;
                            $codigo = $this->sgte_codigomuestra($objPreanalitica->anio_registro,$objPreanalitica->sedes_id,8);
                            $newAnalitica->codigo_muestra = $codigo;
                            $newAnalitica->codigo_secuencial = 1;
                            $fechacomoentero = strtotime($objPreanalitica->fecha_toma_primera);
                            $anio = date("Y", $fechacomoentero)-2000;
                            $mes = date("m", $fechacomoentero);
                            $newAnalitica->codigo_calidad = str_pad($codigo, 5, '0', STR_PAD_LEFT).'-'.str_pad($mes,2,0,STR_PAD_LEFT).str_pad($anio,2,0,STR_PAD_LEFT).'-'.$abcrn->abreviatura.'-'.$absede->abreviatura.'-'.str_pad($newAnalitica->codigo_secuencial, 2, '0', STR_PAD_LEFT);
                            $newAnalitica->codigo_externo = 'EXANT-AMP-'.$muestraorigen;
                            $newAnalitica->usuariot_id = $user;
                            $newAnalitica->fecha_toma = $objPreanalitica->fecha_toma_primera;
                            $newAnalitica->campliada = $muestraorigen;
                            $newAnalitica->save();

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
                    $objPreanalitica->campliada=$muestraorigen;
                    $objPreanalitica->update();
                    $objAnaliticas = Analitica::where('preanalitica_id','=',$objPreanalitica->id)->first();
                    $objAnaliticas->campliada=$muestraorigen;
                    $objAnaliticas->update();

                    $this->alert('success', 'Eventos para investigación ampliada generados con éxito');
                    $this->emit('closeModal');
                }
                else{
                }
            }
            else{
                $control = 0;
                $user = auth()->user()->id;
                $this->Analiticasp->fecha_resultado = date("Y-m-d");
                $this->Analiticasp->usuarior_id = $user;
                $this->saveAnalitica();
                $this->Analiticasp->update();

                if($this->Analiticasp->tecnica_segunda_id>0 && $this->Analiticasp->adicional==0){
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id = $this->Analiticasp->preanalitica_id;
                    $newMuestra->sedes_id = $this->Analiticasp->sedes_id;
                    $newMuestra->crns_id = $this->Analiticasp->crns_id;
                    $newMuestra->evento_id = $this->Analiticasp->evento_id;
                    $newMuestra->muestra_id = $this->Analiticasp->muestra_id;
                    $newMuestra->clase_id = $this->Analiticasp->clase_id;
                    $newMuestra->estado_muestra_id = $this->Analiticasp->estado_muestra_id;
                    $newMuestra->observacion_muestra = $this->Analiticasp->observacion_muestra;
                    $newMuestra->anio_registro = $this->Analiticasp->anio_registro;
                    $newMuestra->codigo_muestra = $this->Analiticasp->codigo_muestra;
                    $newMuestra->codigo_secuencial = $this->Analiticasp->codigo_secuencial*10+1;
                    $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticasp->codigo_muestra;
                    $newMuestra->codigo_calidad = $this->Analiticasp->codigo_calidad;
                    $newMuestra->tecnica_id = $this->Analiticasp->tecnica_segunda_id;
                    $newMuestra->resultado_id = $this->Analiticasp->resultado_segunda_id;
                    $newMuestra->identificado = $this->Analiticasp->identificado_segunda;
                    $newMuestra->descripcion = $this->Analiticasp->descripcion;
                    $newMuestra->usuariot_id = $user;
                    $newMuestra->fecha_toma = $this->Analiticasp->fecha_toma;
                    $newMuestra->fecha_llegada_lab = $this->Analiticasp->fecha_llegada_lab;
                    $newMuestra->fecha_procesamiento = $this->Analiticasp->fecha_procesamiento;
                    $newMuestra->usuarior_id = $user;
                    $newMuestra->archivo = $this->Analiticasp->archivo;
                    $newMuestra->fecha_resultado = date("Y-m-d");
                    $newMuestra->adicional = 1;
                    $newMuestra->save();
                    $control = 1;
                }

                if($this->Analiticasp->tecnica_tercera_id>0 && $this->Analiticasp->adicional==0){
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id =  $this->Analiticasp->preanalitica_id;
                    $newMuestra->sedes_id = $this->Analiticasp->sedes_id;
                    $newMuestra->crns_id = $this->Analiticasp->crns_id;
                    $newMuestra->evento_id = $this->Analiticasp->evento_id;
                    $newMuestra->muestra_id = $this->Analiticasp->muestra_id;
                    $newMuestra->clase_id = $this->Analiticasp->clase_id;
                    $newMuestra->anio_registro = $this->Analiticasp->anio_registro;
                    $newMuestra->fecha_toma = $this->Analiticasp->fecha_toma;
                    $newMuestra->estado_muestra_id = $this->Analiticasp->estado_muestra_id;
                    $newMuestra->observacion_muestra = $this->Analiticasp->observacion_muestra;
                    $newMuestra->codigo_muestra = $this->Analiticasp->codigo_muestra;
                    $newMuestra->codigo_secuencial = $this->Analiticasp->codigo_secuencial*10+2;
                    $newMuestra->codigo_externo = 'Adicional-'.$this->Analiticasp->codigo_muestra;
                    $newMuestra->codigo_calidad = $this->Analiticasp->codigo_calidad;
                    $newMuestra->tecnica_id = $this->Analiticasp->tecnica_tercera_id;
                    $newMuestra->resultado_id = $this->Analiticasp->resultado_tercera_id;
                    $newMuestra->identificado = $this->Analiticasp->identificado_tercera;
                    $newMuestra->descripcion = $this->Analiticasp->descripcion;
                    $newMuestra->fecha_toma = $this->Analiticasp->fecha_toma;
                    $newMuestra->fecha_llegada_lab = $this->Analiticasp->fecha_llegada_lab;
                    $newMuestra->fecha_procesamiento = $this->Analiticasp->fecha_procesamiento;
                    $newMuestra->usuariot_id = $user;
                    $newMuestra->archivo = $this->Analiticasp->archivo;
                    $newMuestra->fecha_resultado = date("Y-m-d");
                    $newMuestra->usuarior_id = $user;
                    $newMuestra->adicional = 1;
                    $newMuestra->save();
                    $control = 1;

                }

                if($this->Analiticasp->tecnica_cuarta_id>0 && $this->Analiticasp->adicional==0){
                    $newMuestra = new Analitica();
                    $newMuestra->preanalitica_id =  $this->Analiticasp->preanalitica_id;
                    $newMuestra->sedes_id = $this->Analiticasp->sedes_id;
                    $newMuestra->crns_id = $this->Analiticasp->crns_id;
                    $newMuestra->evento_id = $this->Analiticasp->evento_id;
                    $newMuestra->muestra_id = $this->Analiticasp->muestra_id;
                    $newMuestra->clase_id = $this->Analiticasp->clase_id;
                    $newMuestra->anio_registro = $this->Analiticasp->anio_registro;
                    $newMuestra->fecha_toma = $this->Analiticasp->fecha_toma;
                    $newMuestra->estado_muestra_id = $this->Analiticasp->estado_muestra_id;
                    $newMuestra->observacion_muestra = $this->Analiticasp->observacion_muestra;
                    $newMuestra->codigo_muestra = $this->Analiticasp->codigo_muestra;
                    $newMuestra->codigo_secuencial = $this->Analiticasp->codigo_secuencial*10+3;
                    $newMuestra->codigo_externo = 'Adicional'.$this->Analiticasp->codigo_muestra;
                    $newMuestra->codigo_calidad = $this->Analiticasp->codigo_calidad;
                    $newMuestra->tecnica_id = $this->Analiticasp->tecnica_cuarta_id;
                    $newMuestra->resultado_id = $this->Analiticasp->resultado_cuarta_id;
                    $newMuestra->identificado = $this->Analiticasp->identificado_cuarta;
                    $newMuestra->descripcion = $this->Analiticasp->descripcion;
                    $newMuestra->fecha_toma = $this->Analiticasp->fecha_toma;
                    $newMuestra->fecha_llegada_lab = $this->Analiticasp->fecha_llegada_lab;
                    $newMuestra->fecha_procesamiento = $this->Analiticasp->fecha_procesamiento;
                    $newMuestra->usuariot_id = $user;
                    $newMuestra->archivo = $this->Analiticasp->archivo;
                    $newMuestra->fecha_resultado = date("Y-m-d");
                    $newMuestra->usuarior_id = $user;
                    $newMuestra->adicional = 1;
                    $newMuestra->save();
                    $control = 1;
                }

                if($control>0){
                    $this->Analiticasp->adicional=1;
                    $this->Analiticasp->update();
                }

            }

            DB::commit();
            $this->alert('success', 'Analitica actualizado con éxito');
            $this->emit('renderJs');
            $this->emit('closeModal');
            return redirect()->route('analitica.index');
         }
        catch (\Exception $e) {
            DB::rollback();
            $this->alert('warning', 'Ocurrió un error al agregar la Analitica'.$e->getMessage());
            return $e->getMessage();
        }

    }


    public function saveAnalitica(){
        if($this->AnaliticaTmp){
            if(Storage::exists($this->Analiticasp->archivo)){
                Storage::delete($this->Analiticasp->archivo);
            }

            $path = $this->AnaliticaTmp->store('public/informes/crns');
            $path = substr($path, 7);
            $this->Analiticasp->archivo = $path;

        }
    }

    public function removeAnalitica(){
        if($this->Analiticasp->archivo){
            if(Storage::exists($this->Analiticasp->archivo)){
                Storage::delete($this->Analiticasp->archivo);
            }

            $this->Analiticasp->archivo = null;
            $this->Analiticass->update();
        }
        $this->reset('AnaliticaTmp');
        $this->alert('success', 'Informe digitalizado eliminado con exito');
    }

}
