<?php

namespace App\Http\Livewire\Centrosreferencia\Preanalitica;

use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
use App\Models\CentrosReferencia\Paciente;
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
    public $csedes;
    public $claboratorios;
    public $ceventos;
    public $fechainicio;
    public $fechafin;
    public $controlf;

    protected $queryString = ['search' => ['except' => ''],'searchc' => ['except' => ''], 'csedes' => ['except' => ''], 'claboratorios' => ['except' => ''], 'ceventos' => ['except' => ''], 'fechainicio' => ['except' => ''], 'fechafin' => ['except' => ''], 'controlf' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $crns = [];
        $eventos = [];

        $count = Preanalitica::where('estado','=','A')->count();
        $preanaliticas = Preanalitica::where('estado','=','A')->orderBy('id', 'desc');

        if($this->searchc){
            $pacientes = Paciente::where(function ($query){
                $query->where('identidad', 'LIKE', "%{$this->searchc}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $preanaliticas = $preanaliticas->whereIn('paciente_id',$pacientes);
            $count = $preanaliticas->count();

        }

        if($this->search){
            $pacientes = Paciente::where(function ($query){
                $query->where('apellidos', 'LIKE', "%{$this->search}%")
                  ->orWhere('nombres', 'LIKE', "%{$this->search}%");
            })->orderBy('id', 'asc')->pluck('id')->toArray();

            $preanaliticas = $preanaliticas->whereIn('paciente_id',$pacientes);
            $count = $preanaliticas->count();

        }
        if($this->csedes){
            $preanaliticas = $preanaliticas->where('sedes_id', '=', $this->csedes);
            $count = $preanaliticas->count();
            $config = SedeCrn::where('sedes_id','=',$this->csedes)->orderBy('id', 'asc')->pluck('crns_id')->toArray();
            $crns = Crn::whereIn('id',$config)->orderBy('id', 'asc')->get();
        }
        if($this->claboratorios){
            $preanaliticas = $preanaliticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios);
            $count = $preanaliticas->count();
            $eventos = Evento::where('crns_id','=',$this->claboratorios)->orderBy('id', 'asc')->get();
        }

        if($this->ceventos){
            $preanaliticas = $preanaliticas->where('sedes_id', '=', $this->csedes)->where('crns_id','=',$this->claboratorios)->where('evento_id','=',$this->ceventos);
            $count = $preanaliticas->count();
        }

        if($this->fechainicio){
            if ($this->fechafin){
                if ($this->fechainicio <= $this->fechafin){
                    if($this->controlf==0){
                        $this->fechainicio='';
                        $this->fechafin='';
                    }
                    if($this->controlf==1){
                        $preanaliticas = $preanaliticas->where('fecha_atencion', '>=', $this->fechainicio)->where('fecha_atencion','<=',$this->fechafin);
                        $count = $preanaliticas->count();

                    }
                    if($this->controlf==2){
                        $preanaliticas = $preanaliticas->where('fecha_sintomas', '>=', $this->fechainicio)->where('fecha_sintomas','<=',$this->fechafin);
                        $count = $preanaliticas->count();
                    }
                    if($this->controlf==3){
                        $nfecha = strtotime ( '+1 day' , strtotime ( $this->fechafin ) ) ;
                        $nfecha = date ( 'Y-m-j' , $nfecha );
                        $preanaliticas = $preanaliticas->where('created_at', '>=', $this->fechainicio)->where('created_at','<=',$nfecha);
                        $count = $preanaliticas->count();
                    }
                }
                else{
                    $this->alert('error', __('Fecha fin debe ser mayor o igual a Fecha inicio'));
                }
            }
            else{
                $this->alert('error', __('Fecha fin no puede ser nulo'));
            }
        }

        $preanaliticas = $preanaliticas->paginate($this->perPage);
        $this->emit('renderJs');

        return view('livewire.centrosreferencia.preanalitica.index', compact('count', 'preanaliticas','sedes','crns','eventos'));
    }

    public function descargarExcel(){
       try{

        $excel = new Spreadsheet();

        $hoja = $excel->getActiveSheet();
        $hoja->setCellValue('A1','Institución Salud');
        $hoja->setCellValue('B1','Periodo');
        $hoja->setCellValue('C1','Id. Paciente');
        $hoja->setCellValue('D1','Identidad');
        $hoja->setCellValue('E1','Nombres');
        $hoja->setCellValue('F1','Apellidos');
        $hoja->setCellValue('G1','F.Nacimiento');
        $hoja->setCellValue('H1','Anios');
        $hoja->setCellValue('I1','Meses');
        $hoja->setCellValue('J1','Dias');
        $hoja->setCellValue('K1','Sexo');
        $hoja->setCellValue('L1','Cantón');
        $hoja->setCellValue('M1','Provincia');
        $hoja->setCellValue('N1','Sede');
        $hoja->setCellValue('O1','CRN');
        $hoja->setCellValue('P1','Evento');
        $hoja->setCellValue('Q1','Clase');
        $hoja->setCellValue('R1','Tipo');
        $hoja->setCellValue('S1','No. Muestra');
        $hoja->setCellValue('T1','Observación');
        $hoja->setCellValue('U1','Secuencia');
        $hoja->setCellValue('V1','Estado');
        $hoja->setCellValue('W1','F. Registro');


        $fila = 2;
        $i = 0;
        if ($this->csedes>0){
            $sid = $this->csedes;
        }
        else{
            $sid = 0;
        }

        if ($this->claboratorios>0){
            $cid = $this->claboratorios;
        }
        else{
            $cid = 0;
        }

        if ($this->ceventos>0){
            $eid = $this->ceventos;
        }
        else{
            $eid = 0;
        }

        if ($this->controlf>0){
            $tf = $this->controlf;
        }
        else{
            $tf = 0;
        }

        if ($this->fechainicio != null){
            $f1 = $this->fechainicio;
        }
        else{
            $f1 = null;
        }

        if ($this->fechafin != null){
            $f2 = $this->fechafin;
        }
        else{
            $f2 = null;
        }

        if($sid==0){
            if($tf==1){
                $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->whereDate('fecha_atencion','>=',$f1)->whereDate('fecha_atencion','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
            }
            else{
                if($tf==2){
                    $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->whereDate('fecha_sintomas','>=',$f1)->whereDate('fecha_sintomas','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                }
                else{
                    if($tf==3){
                        $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->whereDate('fecha_registro','>=',$f1)->whereDate('fecha_registro','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                    }
                    else{
                        $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                    }
                }
            }
        }
        else{
            if($cid==0){
                if($tf==1){
                    $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->whereDate('fecha_atencion','>=',$f1)->whereDate('fecha_atencion','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                }
                else{
                    if($tf==2){
                        $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->whereDate('fecha_sintomas','>=',$f1)->whereDate('fecha_sintomas','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                    }
                    else{
                        if($tf==3){
                            $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->whereDate('fecha_registro','>=',$f1)->whereDate('fecha_registro','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                        }
                        else{
                            $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                        }
                    }
                }
            }
            else{
                if($eid==0){
                    if($tf==1){
                        $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->whereDate('fecha_atencion','>=',$f1)->whereDate('fecha_atencion','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                    }
                    else{
                        if($tf==2){
                            $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->whereDate('fecha_sintomas','>=',$f1)->whereDate('fecha_sintomas','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                        }
                        else{
                            if($tf==3){
                                $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->whereDate('fecha_registro','>=',$f1)->whereDate('fecha_registro','<=',$f2)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                            }
                            else{
                                $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                            }
                        }
                    }
                }
                else{
                    $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','nombres','apellidos','fechanacimiento','anios','meses','dias','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','observacion','fecha_registro')->where('sedes_id','=',$sid)->where('crns_id','=',$cid)->where('evento_id','=',$eid)->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
                }
            }
        }

        $total = $data->count();

        while($i < $total){
            $hoja->setCellValue('A'.$fila,$data[$i]->institucion);
            $hoja->setCellValue('B'.$fila,$data[$i]->anio);
            $hoja->setCellValue('C'.$fila,$data[$i]->paciente);
            $hoja->setCellValue('D'.$fila,$data[$i]->identidad);
            $hoja->setCellValue('E'.$fila,$data[$i]->nombres);
            $hoja->setCellValue('F'.$fila,$data[$i]->apellidos);
            $hoja->setCellValue('G'.$fila,$data[$i]->fechanacimiento);
            $hoja->setCellValue('H'.$fila,$data[$i]->anios);
            $hoja->setCellValue('I'.$fila,$data[$i]->meses);
            $hoja->setCellValue('J'.$fila,$data[$i]->dias);
            $hoja->setCellValue('K'.$fila,$data[$i]->sexo);
            $hoja->setCellValue('L'.$fila,$data[$i]->canton);
            $hoja->setCellValue('M'.$fila,$data[$i]->provincia);
            $hoja->setCellValue('N'.$fila,$data[$i]->sede);
            $hoja->setCellValue('O'.$fila,$data[$i]->crn);
            $hoja->setCellValue('P'.$fila,$data[$i]->evento);
            $hoja->setCellValue('Q'.$fila,$data[$i]->clase_muestra);
            $hoja->setCellValue('R'.$fila,$data[$i]->tipo_muestra);
            $hoja->setCellValue('S'.$fila,$data[$i]->muestra);
            $hoja->setCellValue('T'.$fila,$data[$i]->observacion);
            $hoja->setCellValue('U'.$fila,$data[$i]->codigo_secuencial);
            $hoja->setCellValue('V'.$fila,$data[$i]->estado_muestra);
            $hoja->setCellValue('W'.$fila,$data[$i]->fecha_registro);
            $fila = $fila + 1;
            $i = $i + 1;
        }

        $this->alert('success', 'Archivo generado con exito');

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="descarga_muestras.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel,'Xlsx');
        $writer->save(storage_path('app/public/descargas/')."descarga_muestras.xlsx");

       }
       catch(IOException $e){
        }
        $this->emit('renderJs');
        return redirect()->back();
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
