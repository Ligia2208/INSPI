<?php

namespace App\Http\Controllers\CentrosReferencia\Analiticatoxico;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

use App\phpqrcode\phpqrcode;
use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analiticatoxico;
use App\Models\CentrosReferencia\Paciente;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use QrCode;

class AnaliticatoxicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:analiticastoxico']);
    }

    public function index(){
        return view('centrosreferencia.analiticatoxico.index');
    }

    public function create(){
        $analiticatoxico = new Analiticatoxico();
        return view('centrosreferencia.analiticatoxico.create', compact('analiticatoxico'));
    }

    public function show(Analiticatoxico $analiticatoxico){
        return view('centrosreferencia.analiticatoxico.show', compact('analiticatoxico'));
    }

    public function edit(Analiticatoxico $analiticatoxico){
        return view('centrosreferencia.analiticatoxico.edit', compact('analiticatoxico'));
    }

}
