<?php

namespace App\Http\Livewire\Centrosreferencia\Preanalitica;

use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Crn;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Sede;
use App\Models\CentrosReferencia\SedeCrn;
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
    public $csedes;
    public $claboratorios;
    public $ceventos;
    public $fechainicio;
    public $fechafin;
    public $controlf;

    protected $queryString = ['search' => ['except' => ''], 'csedes' => ['except' => ''], 'claboratorios' => ['except' => ''], 'ceventos' => ['except' => ''], 'fechainicio' => ['except' => ''], 'fechafin' => ['except' => ''], 'controlf' => ['except' => '']];

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

        if($this->search){
            $preanaliticas = $preanaliticas->where('codigo_muestra', 'LIKE', "%{$this->search}%");
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
                        $preanaliticas = $preanaliticas->where('fecha_atencion', '>=', $this->fechainicio)->where('fecha_toma_muestra','<=',$this->fechafin);
                        $count = $preanaliticas->count();

                    }
                    if($this->controlf==2){
                        $preanaliticas = $preanaliticas->where('fecha_sintomas', '>=', $this->fechainicio)->where('fecha_llegada_lab','<=',$this->fechafin);
                        $count = $preanaliticas->count();
                    }
                    if($this->controlf==3){
                        $preanaliticas = $preanaliticas->where('created_at', '>=', $this->fechainicio)->where('created_at','<=',$this->fechafin);
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

    public function descargarExcel($sid,$cid,$eid,$tf,$f1,$f2){

       try{
        $excel = new Spreadsheet();

        $hoja = $excel->getActiveSheet();
        $hoja->setCellValue('A1','Institución Salud');
        $hoja->setCellValue('B1','Periodo');
        $hoja->setCellValue('C1','Id. Paciente');
        $hoja->setCellValue('D1','Identidad');
        $hoja->setCellValue('E1','F.Nacimiento');
        $hoja->setCellValue('F1','Edad');
        $hoja->setCellValue('G1','Sexo');
        $hoja->setCellValue('H1','Cantón');
        $hoja->setCellValue('I1','Provincia');
        $hoja->setCellValue('J1','Sede');
        $hoja->setCellValue('K1','CRN');
        $hoja->setCellValue('L1','Evento');
        $hoja->setCellValue('M1','Clase');
        $hoja->setCellValue('N1','Tipo');
        $hoja->setCellValue('O1','No. Muestra');
        $hoja->setCellValue('P1','Secuencia');
        $hoja->setCellValue('Q1','Estado');
        $hoja->setCellValue('R1','F. Registro');


        $fila = 2;
        $i = 0;
        $data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','fechanacimiento','edad','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','fecha_registro')->orderBy('sedes_id','ASC')->orderBy('crns_id','ASC')->orderBy('evento_id','ASC')->orderBy('muestra','ASC')->orderBy('codigo_secuencial','ASC')->get();
        //$data = DB::table('inspi_crns.detalle_muestras')->select('institucion','anio','paciente','identidad','fechanacimiento','edad','sexo','canton','provincia','sede','crn','evento','clase_muestra','tipo_muestra','muestra','codigo_secuencial','estado_muestra','fecha_registro')->where('sedes_id','=',1)->where('crns_id','=',8)->where('evento_id','=',109)->where('fecha_registro','>=','2024-12-01')->where('fecha_registro','<=','2025-01-31')->get();
        $total = $data->count();
        while($i < $total){
            $hoja->setCellValue('A'.$fila,$data[$i]->institucion);
            $hoja->setCellValue('B'.$fila,$data[$i]->anio);
            $hoja->setCellValue('C'.$fila,$data[$i]->paciente);
            $hoja->setCellValue('D'.$fila,$data[$i]->identidad);
            $hoja->setCellValue('E'.$fila,$data[$i]->fechanacimiento);
            $hoja->setCellValue('F'.$fila,$data[$i]->edad);
            $hoja->setCellValue('G'.$fila,$data[$i]->sexo);
            $hoja->setCellValue('H'.$fila,$data[$i]->canton);
            $hoja->setCellValue('I'.$fila,$data[$i]->provincia);
            $hoja->setCellValue('J'.$fila,$data[$i]->sede);
            $hoja->setCellValue('K'.$fila,$data[$i]->crn);
            $hoja->setCellValue('L'.$fila,$data[$i]->evento);
            $hoja->setCellValue('M'.$fila,$data[$i]->clase_muestra);
            $hoja->setCellValue('N'.$fila,$data[$i]->tipo_muestra);
            $hoja->setCellValue('O'.$fila,$data[$i]->muestra);
            $hoja->setCellValue('P'.$fila,$data[$i]->codigo_secuencial);
            $hoja->setCellValue('Q'.$fila,$data[$i]->estado_muestra);
            $hoja->setCellValue('R'.$fila,$data[$i]->fecha_registro);
            $fila = $fila + 1;
            $i = $i + 1;
        }

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="descarga_muestras.xlsx"');
        header('Cache-Control: max-age=0');


        $writer = IOFactory::createWriter($excel,'Xlsx');
        $writer->save("descarga_muestras.xlsx");
        $this->alert('success', 'Archivo generado con exito');
        exit;


       }
       catch(IOException $e){
        dd($e.toString);
       }

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
