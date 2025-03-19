<?php

namespace App\Http\Controllers\CentrosReferencia\Analiticatoxicop;
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

class AnaliticatoxicopController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:analiticastoxicop']);
    }

    public function index(){
        return view('centrosreferencia.analiticatoxicop.index');
    }

    public function create(){
        $analiticatoxico = new Analiticatoxico();
        return view('centrosreferencia.analiticatoxicop.create', compact('analiticatoxico'));
    }

    public function show(Analiticatoxico $analiticatoxico){
        return view('centrosreferencia.analiticatoxicop.show', compact('analiticatoxico'));
    }

    public function edit(Analiticatoxico $analiticatoxico){
        return view('centrosreferencia.analiticatoxicop.edit', compact('analiticatoxico'));
    }

}
