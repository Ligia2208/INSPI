<?php

namespace App\Http\Controllers\CentrosReferencia\Analiticamicolo;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

use App\phpqrcode\phpqrcode;
use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analiticamicolo;
use App\Models\CentrosReferencia\Paciente;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use QrCode;

class AnaliticamicoloController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:analiticasmicolo']);
    }

    public function index(){
        return view('centrosreferencia.analiticasmicolo.index');
    }

    public function create(){
        $analiticasmicolo = new Analiticamicolo();
        return view('centrosreferencia.analiticasmicolo.create', compact('analiticasmicolo'));
    }

    public function show(Analiticamicolo $analiticasmicolo){
        return view('centrosreferencia.analiticasmicolo.show', compact('analiticasmicolo'));
    }

    public function edit(Analiticamicolo $analiticasmicolo){
        return view('centrosreferencia.analiticasmicolo.edit', compact('analiticasmicolo'));
    }

}
