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
            ->leftJoin('inspi_crns.crns as crn', 'pre.crns_id', '=', 'crn.id')
            ->leftJoin('inspi_crns.clase_muestra as clase', 'ana.clase_id', '=', 'clase.id')
            ->leftJoin('inspi_crns.tipo_muestras as tipo', 'ana.muestra_id', '=', 'tipo.id')
            ->select(
                'crn.abreviatura as codigo_procedencia',
                'pre.observacion_primera as observaciones',
                'clase.descripcion as organismo',
                'tipo.descripcion as tipo_muestra',
                'ana.fecha_toma as fecha_colecta'
            )
            ->get();
        
            return \PDF::loadView('pdf.registros.pdfRegistro_Muestra', [
                'datos' => $datos
            ])
            ->setPaper('A4', 'portrait')
            ->stream('Registro_Muestra.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }


    public function registro_solicitud(Preanaliticagen $Preanaliticastoxico)
    {
        try {
            return \PDF::loadView('pdf.registros.pdfRegistro_Solicitud', [
                'Preanaliticastoxico' => $Preanaliticastoxico
            ])
            ->setPaper('A4', 'portrait')
            ->download('Registro_Solicitud.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }


    
}
