<?php

namespace App\Http\Controllers\GestionDocumental\Grafico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GestionDocumental\Seguimiento;
use Redirect,Response;
Use DB;
use Carbon\Carbon;
 
class ChartJSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
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
      $data = [];
      $data['label'][0] = 'Dirección Ejecutiva';
      $data['label'][1] = 'Planificación y Gestión Estratégica';
      $data['label'][2] = 'Asesoría Jurídica';
      $data['label'][3] = 'Comunicación Social';
      $data['label'][4] = 'Administración de Talento Humano';
      $data['label'][5] = 'Administrativa Financiera';
      $data['label'][6] = 'General Técnica';
      $data['label'][7] = 'Coordinación Zonal 6';
      $data['label'][8] = 'Coordinación Zonal 9';
      
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
      $data['data'][0] = $d1;
      $data['data'][1] = $d2;
      $data['data'][2] = $d3;
      $data['data'][3] = $d4;
      $data['data'][4] = $d5;
      $data['data'][5] = $d6;
      $data['data'][6] = $d7;
      $data['data'][7] = $d8;
      $data['data'][8] = $d9;
 
      $data['chart_data'] = json_encode($data);
      return view('chart-js', $data); 
   }
}
