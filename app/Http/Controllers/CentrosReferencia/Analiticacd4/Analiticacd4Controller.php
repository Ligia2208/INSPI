<?php

namespace App\Http\Controllers\CentrosReferencia\Analiticacd4;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

use App\phpqrcode\phpqrcode;
use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Responsable;
use Illuminate\Http\Request;
use Libraries\Services\Complement;
use Illuminate\Support\Facades\Session;
use Codedge\Fpdf\Fpdf\Fpdf;
use QrCode;

class Analiticacd4Controller extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:analiticas']);
    }

    public function index(){
        return view('centrosreferencia.analiticacd4.index');
    }

    public function create(){
        $analitica = new Analitica();
        return view('centrosreferencia.analiticacd4.create', compact('analitica'));
    }

    public function show(Analitica $analitica){
        return view('centrosreferencia.analiticacd4.show', compact('analitica'));
    }

    public function edit(Analitica $analitica){
        return view('centrosreferencia.analiticacd4.edit', compact('analitica'));
    }

    public function guardar_validar(Request $request){
        $user = auth()->user()->id;
        $tam = count($request->codes);
        $i = 0;
        $conterror = 0;
        $contvalidos = 0;
        while($i<$tam){
            if($request->resultados[$i]==0){
                $conterror++;
            }
            else{
                $contvalidos++;
                $objAnalitica = Analitica::findOrFail($request->codes[$i]);
                $crns_responsable = Responsable::where('estado','=','A')->where('tipo_id','=',2)->where('sedes_id','=',$objAnalitica->sedes_id)->where('crns_id','=',$objAnalitica->crns_id)->where('vigente_hasta','=',null)->pluck('usuario_id')->first();

                $objAnalitica->tecnica_id = 112;
                $objAnalitica->resultado_id = 82;
                $objAnalitica->carga_viral = $request->resultados[$i];
                $objAnalitica->unidades_id = 1;
                $objAnalitica->fecha_llegada_lab = $request->idfinicio;
                $objAnalitica->fecha_procesamiento = $request->idffin;
                $objAnalitica->fecha_resultado = date("Y-m-d");
                $objAnalitica->usuarior_id = $user;
                $objAnalitica->estado = 'A';
                $objAnalitica->usuariop_id = $crns_responsable;
                $objAnalitica->fecha_publicacion = date("Y-m-d");
                $objAnalitica->validado = 'S';
                $objAnalitica->update();

                $objPreanalitica = Preanalitica::findOrFail($objAnalitica->preanalitica_id);
                $objPreanalitica->validado = 'S';
                $objPreanalitica->resultado_id = 280;
                $objPreanalitica->fecha_resultado = date("Y-m-d");
                $objPreanalitica->usuarior_id = $crns_responsable;
                $objPreanalitica->update();

            }
            $i=$i+1;
        }
        if($conterror==0){
            \Session::flash('message', 'Se procesaron '.$tam.' muestras con éxito', array('timeout' => 3000), 'error');
            return redirect()->back();
        }
        else{
            \Session::flash('message', 'Faltan '.$conterror.' valores, se procesaron '.$contvalidos.' muestras.', array('timeout' => 3000), 'error');
        }
        return redirect()->back();

    }

}
