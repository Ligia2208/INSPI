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
            $datos = [
                'crns' => Crn::select('id', 'abreviatura')->get(),
                //'clases_muestra' => ClaseMuestra::select('id', 'descripcion')->get(),
               // 'tipos_muestra' => TipoMuestra::select('id', 'descripcion')->get(),
                'provincias' => Provincia::select('id', 'descripcion')->get(),
                'instituciones_salud' => Institucion::select('id', 'descripcion')->get(),
                'sexos' => Sexo::select('id', 'descripcion')->get(),
            ];
            
        
            return \PDF::loadView('pdf.registros.pdfRegistro_Muestra', [
               // 'Preanaliticastoxico' => $Preanaliticastoxico,
                'datos' => $datos
            ])
            ->setPaper('A4', 'portrait')
            ->download('Registro_Muestra.pdf');
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
