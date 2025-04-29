<?php

namespace App\Http\Controllers\CentrosReferencia\Preanaliticagen;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Preanaliticagen;
use App\Models\CentrosReferencia\Preanaliticamico;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;
use App\Models\CentrosReferencia\Sexo;
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Crn;
use Illuminate\Support\Facades\DB;




class PreanaliticagenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:preanaliticagen']);
    }

    public function index(){
        return view('centrosreferencia.preanaliticagen.index');
    }

    public function create(){
        $preanalitica = new Preanaliticagen();
        return view('centrosreferencia.preanaliticagen.create', compact('preanalitica'));
    }

    public function show(Preanaliticagen $Preanaliticastoxico){
        $analitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$Preanaliticastoxico->id)->get();
        return view('centrosreferencia.preanaliticagen.show', compact('Preanaliticastoxico','analitica'));
    }

    public function edit(Preanaliticagen $Preanaliticastoxico){
        //dd($Preanaliticastoxico->getKey());
        return view('centrosreferencia.preanaliticagen.edit', compact('Preanaliticastoxico'));
    }

    public function registro_muestra(Preanaliticagen $Preanaliticastoxico)
    {
        
        try {

            $datos = DB::table('inspi_crns.pre_analitica as pre')
            ->join('inspi_crns.analiticas as ana', 'ana.preanalitica_id', '=', 'pre.id')
            ->join('inspi_crns.crns as crn', 'pre.crns_id', '=', 'crn.id')
            ->join('inspi_crns.clase_muestra as clase', 'ana.clase_id', '=', 'clase.id')
            ->join('inspi_crns.tipo_muestras as tipo', 'ana.muestra_id', '=', 'tipo.id')
            ->join('inspi_crns.genotificacion as gen', 'gen.id_analitica', '=', 'ana.id')
            ->join('inspi_crns.tipo_organismo as org', 'org.id', '=', 'gen.id_organismo')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'pre.instituciones_id') 
            ->join('inspi_crns.cantones as can', 'can.id', '=', 'ins.canton_id')
            ->join('inspi_crns.sexos as sex', 'sex.id', '=', 'ana.sexo')
            ->select(
                'crn.abreviatura as codigo_procedencia',
                'ana.observacion_muestra as observaciones',
                'clase.descripcion as organismo',
                'tipo.descripcion as tipo_muestra',
                'ana.fecha_toma as fecha_colecta', 
                'org.nombre as nombre_organismo',
                'ana.codigo_calidad as codigo_calidad',
                'ins.descripcion as institucion',
                'can.descripcion as canton',
                'sex.descripcion as sexo',
                'ana.edad as edad',
                'ana.ct as ct'
            )
            ->where('pre.id', $Preanaliticastoxico->id)
            ->where('pre.estado', 'A')
            ->get();

            $eventos = DB::table('inspi_crns.eventos as eve')->where('eve.crns_id', $Preanaliticastoxico->crns_id)->get();
            $cantidadEventos = $eventos->count();
            $anchoPorEvento = 100 / ($cantidadEventos > 0 ? $cantidadEventos : 1);
        
            return \PDF::loadView('pdf.registros.pdfRegistro_Muestra', [
                'datos'   => $datos, 
                'eventos' => $eventos,
            ])
            ->setPaper('A4', 'portrait')
            ->stream('Registro_Muestra.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }


    public function registro_solicitud(Preanaliticagen $Preanaliticastoxico)
    {
        //dd($Preanaliticastoxico);
        try {

            $datos = Preanaliticagen::select('inspi_crns.pre_analitica.nombre_solicitante as solicitante', 'ins.descripcion as unidad_salud',
                'pre_analitica.correo_solicitante as correo', 'pre_analitica.otras_observaciones as otras_observaciones', 'pre_analitica.evento_id as evento_id',)
            ->where('inspi_crns.pre_analitica.id', $Preanaliticastoxico->id)
            ->join('inspi_crns.analiticas as ana', 'ana.preanalitica_id', '=', 'pre_analitica.id')   
            //->join('inspi_crns.crns as crn', 'pre_analitica.crns_id', '=', 'crn.id')
            //->join('inspi_crns.clase_muestra as clase', 'ana.clase_id', '=', 'clase.id')
            ->join('inspi_crns.tipo_muestras as tipo', 'ana.muestra_id', '=', 'tipo.id')
            ->join('inspi_crns.instituciones_salud as ins', 'pre_analitica.instituciones_id', '=', 'ins.id')
            ->first();

            $eventos = DB::table('inspi_crns.eventos as eve')->where('eve.crns_id', $Preanaliticastoxico->crns_id)->where('estado', 'A')->get();
            $cantidadEventos = $eventos->count();
            $anchoPorEvento = 100 / ($cantidadEventos > 0 ? $cantidadEventos : 1);

            return \PDF::loadView('pdf.registros.pdfRegistro_Solicitud', [
                'datos'           => $datos,
                'eventos'         => $eventos,
                'anchoPorEvento'  => $anchoPorEvento,
                'cantidadEventos' => $cantidadEventos,
            ])
            ->setPaper('A4', 'portrait')
            ->download('Registro_Solicitud.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }


    
}
