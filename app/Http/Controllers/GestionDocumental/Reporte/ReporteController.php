<?php

namespace App\Http\Controllers\GestionDocumental\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GestionDocumental\Seguimiento;
use App\Models\GestionDocumental\Solicitud;
use App\Models\GestionDocumental\Asignacion;
use Redirect,Response;
Use DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public $datao = [];
    public $datad = [];
    public $dataos = [];
    public $datas = [];
    public $dataom = [];
    public $datam = [];
    public $datat = [];

    public function __construct()
    {
        $this->middleware(['permission:reportesdocumental']);
    }
    public function origendiario(){
        $record1 = DB::table('inspi_documental.solicitudes')->join('inspi_documental.asignaciones','inspi_documental.solicitudes.id','=','inspi_documental.asignaciones.solicitud_id')->select(\DB::raw("COUNT(*) as count"), 'origen_id as origen')
            ->where('origen_id','=',1)
            ->where('inspi_documental.asignaciones.created_at', '>', Carbon::today())
            ->groupBy('origen')
            ->orderBy('origen')
            ->get();
        $record2 = DB::table('inspi_documental.solicitudes')->join('inspi_documental.asignaciones','inspi_documental.solicitudes.id','=','inspi_documental.asignaciones.solicitud_id')->select(\DB::raw("COUNT(*) as count"), 'origen_id as origen')
            ->where('origen_id','=',2)
            ->where('inspi_documental.asignaciones.created_at', '>', Carbon::today())
            ->groupBy('origen')
            ->orderBy('origen')
            ->get();
        $d1=0;   $d2=0;  

        $this->datao['label'][0] = 'Externo';
        $this->datao['label'][1] = 'Interno';
        
        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }
        
        $this->datao['data'][0] = $d1;
        $this->datao['data'][1] = $d2;
    
        $this->datao['chart_data_origen'] = json_encode($this->datao);

    }
    public function diario(){
        $record1 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',1)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get();
        $record2 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',2)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get();
        $record3 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',3)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record4 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',4)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get();  
        $record5 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',5)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record6 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',6)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record7 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',7)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record8 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',8)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record9 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',9)
            ->where('created_at', '>', Carbon::today())
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $d1=0;   $d2=0;   $d3=0;   $d4=0;   $d5=0;   $d6=0;   $d7=0;   $d8=0;   $d9=0;
        
        $this->datad['label'][0] = 'Dir. Eje.';
        $this->datad['label'][1] = 'Pla. GEs.';
        $this->datad['label'][2] = 'Ase. Jur.';
        $this->datad['label'][3] = 'Com. Soc.';
        $this->datad['label'][4] = 'Tal. Hum.';
        $this->datad['label'][5] = 'Adm. Fin.';
        $this->datad['label'][6] = 'Gen. Tec.';
        $this->datad['label'][7] = 'Crd. Zon6';
        $this->datad['label'][8] = 'Crd. Zon9';
        
        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }
        foreach($record3 as $row) {
            $d3 = (int) $row->count;
        }
        foreach($record4 as $row) {
            $d4 = (int) $row->count;
        }
        foreach($record5 as $row) {
            $d5 = (int) $row->count;
        }
        foreach($record6 as $row) {
            $d6 = (int) $row->count;
        }
        foreach($record7 as $row) {
            $d7 = (int) $row->count;
        }
        foreach($record8 as $row) {
            $d8 = (int) $row->count;
        }
        foreach($record9 as $row) {
            $d9 = (int) $row->count;
        }
        $this->datad['data'][0] = $d1;
        $this->datad['data'][1] = $d2;
        $this->datad['data'][2] = $d3;
        $this->datad['data'][3] = $d4;
        $this->datad['data'][4] = $d5;
        $this->datad['data'][5] = $d6;
        $this->datad['data'][6] = $d7;
        $this->datad['data'][7] = $d8;
        $this->datad['data'][8] = $d9;
    
        $this->datad['chart_data_diario'] = json_encode($this->datad);
    }
    public function origensemanal(){
        $record1 = DB::table('inspi_documental.solicitudes')->join('inspi_documental.asignaciones','inspi_documental.solicitudes.id','=','inspi_documental.asignaciones.solicitud_id')->select(\DB::raw("COUNT(*) as count"), 'origen_id as origen')
            ->where('origen_id','=',1)
            ->where('inspi_documental.asignaciones.created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('origen')
            ->orderBy('origen')
            ->get();
            $record2 = DB::table('inspi_documental.solicitudes')->join('inspi_documental.asignaciones','inspi_documental.solicitudes.id','=','inspi_documental.asignaciones.solicitud_id')->select(\DB::raw("COUNT(*) as count"), 'origen_id as origen')
            ->where('origen_id','=',2)
            ->where('inspi_documental.asignaciones.created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('origen')
            ->orderBy('origen')
            ->get();
        $d1=0;   $d2=0;  

        $this->dataos['label'][0] = 'Externo';
        $this->dataos['label'][1] = 'Interno';
        
        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }
        
        $this->dataos['data'][0] = $d1;
        $this->dataos['data'][1] = $d2;
    
        $this->dataos['chart_data_origen_semanal'] = json_encode($this->dataos);

    }
    public function semanal(){
        $record1 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',1)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get();
        $record2 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',2)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get();
        $record3 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',3)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record4 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',4)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get();  
        $record5 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',5)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record6 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',6)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record7 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',7)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record8 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',8)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record9 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',9)
            ->where('created_at', '>', Carbon::today()->subDay(7))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $d1=0;   $d2=0;   $d3=0;   $d4=0;   $d5=0;   $d6=0;   $d7=0;   $d8=0;   $d9=0;
        
        $this->datas['label'][0] = 'Dir. Eje.';
        $this->datas['label'][1] = 'Pla. GEs.';
        $this->datas['label'][2] = 'Ase. Jur.';
        $this->datas['label'][3] = 'Com. Soc.';
        $this->datas['label'][4] = 'Tal. Hum.';
        $this->datas['label'][5] = 'Adm. Fin.';
        $this->datas['label'][6] = 'Gen. Tec.';
        $this->datas['label'][7] = 'Crd. Zon6';
        $this->datas['label'][8] = 'Crd. Zon9';
        
        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }
        foreach($record3 as $row) {
            $d3 = (int) $row->count;
        }
        foreach($record4 as $row) {
            $d4 = (int) $row->count;
        }
        foreach($record5 as $row) {
            $d5 = (int) $row->count;
        }
        foreach($record6 as $row) {
            $d6 = (int) $row->count;
        }
        foreach($record7 as $row) {
            $d7 = (int) $row->count;
        }
        foreach($record8 as $row) {
            $d8 = (int) $row->count;
        }
        foreach($record9 as $row) {
            $d9 = (int) $row->count;
        }
        $this->datas['data'][0] = $d1;
        $this->datas['data'][1] = $d2;
        $this->datas['data'][2] = $d3;
        $this->datas['data'][3] = $d4;
        $this->datas['data'][4] = $d5;
        $this->datas['data'][5] = $d6;
        $this->datas['data'][6] = $d7;
        $this->datas['data'][7] = $d8;
        $this->datas['data'][8] = $d9;
    
        $this->datas['chart_data_semana'] = json_encode($this->datas);
    }
    public function origenmensual(){
        $record1 = DB::table('inspi_documental.solicitudes')->join('inspi_documental.asignaciones','inspi_documental.solicitudes.id','=','inspi_documental.asignaciones.solicitud_id')->select(\DB::raw("COUNT(*) as count"), 'origen_id as origen')
            ->where('origen_id','=',1)
            ->where('inspi_documental.asignaciones.created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('origen')
            ->orderBy('origen')
            ->get();
        $record2 = DB::table('inspi_documental.solicitudes')->join('inspi_documental.asignaciones','inspi_documental.solicitudes.id','=','inspi_documental.asignaciones.solicitud_id')->select(\DB::raw("COUNT(*) as count"), 'origen_id as origen')
            ->where('origen_id','=',2)
            ->where('inspi_documental.asignaciones.created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('origen')
            ->orderBy('origen')
            ->get();
        $d1=0;   $d2=0;  

        $this->dataom['label'][0] = 'Externo';
        $this->dataom['label'][1] = 'Interno';
        
        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }
        
        $this->dataom['data'][0] = $d1;
        $this->dataom['data'][1] = $d2;
    
        $this->dataom['chart_data_origen_mes'] = json_encode($this->dataom);

    }
    public function mensual(){
        $record1 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',1)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get();
        $record2 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',2)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get();
        $record3 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',3)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record4 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',4)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get();  
        $record5 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',5)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record6 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',6)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record7 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',7)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record8 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',8)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $record9 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'area_id as area')
            ->where('area_id','=',9)
            ->where('created_at', '>', Carbon::today()->subDay(30))
            ->groupBy('area')
            ->orderBy('area')
            ->get(); 
        $d1=0;   $d2=0;   $d3=0;   $d4=0;   $d5=0;   $d6=0;   $d7=0;   $d8=0;   $d9=0;
        
        $this->datam['label'][0] = 'Dir. Eje.';
        $this->datam['label'][1] = 'Pla. GEs.';
        $this->datam['label'][2] = 'Ase. Jur.';
        $this->datam['label'][3] = 'Com. Soc.';
        $this->datam['label'][4] = 'Tal. Hum.';
        $this->datam['label'][5] = 'Adm. Fin.';
        $this->datam['label'][6] = 'Gen. Tec.';
        $this->datam['label'][7] = 'Crd. Zon6';
        $this->datam['label'][8] = 'Crd. Zon9';
        
        foreach($record1 as $row) {
            $d1 = (int) $row->count;
        }
        foreach($record2 as $row) {
            $d2 = (int) $row->count;
        }
        foreach($record3 as $row) {
            $d3 = (int) $row->count;
        }
        foreach($record4 as $row) {
            $d4 = (int) $row->count;
        }
        foreach($record5 as $row) {
            $d5 = (int) $row->count;
        }
        foreach($record6 as $row) {
            $d6 = (int) $row->count;
        }
        foreach($record7 as $row) {
            $d7 = (int) $row->count;
        }
        foreach($record8 as $row) {
            $d8 = (int) $row->count;
        }
        foreach($record9 as $row) {
            $d9 = (int) $row->count;
        }
        $this->datam['data'][0] = $d1;
        $this->datam['data'][1] = $d2;
        $this->datam['data'][2] = $d3;
        $this->datam['data'][3] = $d4;
        $this->datam['data'][4] = $d5;
        $this->datam['data'][5] = $d6;
        $this->datam['data'][6] = $d7;
        $this->datam['data'][7] = $d8;
        $this->datam['data'][8] = $d9;
    
        $this->datam['chart_data_mes'] = json_encode($this->datam);
    }
    public function acumulado(){
        $record1 = Seguimiento::select(\DB::raw("COUNT(*) as count"), 'fechaasignacionde as fecha')
            ->where('fechaasignacionde', '>', Carbon::today()->subDay(30))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        $d1=0;          
        
        foreach($record1 as $row) {
            $this->datat['label'][] = $row->fecha;
            $this->datat['data'][] = (int) $row->count;
        }
                  
        $this->datat['chart_data_total'] = json_encode($this->datat);

    }

    public function index(){
        $this->origendiario();
        $this->diario();
        $this->origensemanal();
        $this->semanal();
        $this->origenmensual();
        $this->mensual();
        $this->acumulado();
        return view('gestiondocumental.reporte.index')->with($this->datao)->with($this->datad)->with($this->dataos)->with($this->datas)->with($this->dataom)->with($this->datam)->with($this->datat);
    }
}
