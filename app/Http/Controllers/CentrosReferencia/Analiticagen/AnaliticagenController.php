<?php

namespace App\Http\Controllers\CentrosReferencia\Analiticagen;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

use App\phpqrcode\phpqrcode;
use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Paciente;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use QrCode;

class AnaliticagenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:analiticasgen']);
    }

    public function index(){
        return view('centrosreferencia.analiticasgen.index');
    }

    public function create(){
        $analiticasgen = new Analitica();
        return view('centrosreferencia.analiticasgen.create', compact('analiticasgen'));
    }

    public function show(Analitica $analiticasgen){
        return view('centrosreferencia.analiticasgen.show', compact('analiticasgen'));
    }

    public function edit(Analitica $analiticasgen){
        return view('centrosreferencia.analiticasgen.edit', compact('analiticasgen'));
    }

}
