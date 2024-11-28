<?php

namespace App\Http\Controllers\CentrosReferencia\Analiticacrn;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;

class AnaliticacrnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:analiticacrn']);
    }

    public function index(){
        return view('centrosreferencia.analiticacrn.index');
    }

    public function create(){
        $resultado = new Analitica();
        return view('centrosreferencia.analiticacrn.create', compact('analitica'));
    }

    public function show(Analitica $analitica){
        return view('centrosreferencia.analiticacrn.show', compact('analitica'));
    }

    public function edit(Analitica $analitica){
        return view('centrosreferencia.analiticacrn.edit', compact('analitica'));
    }
}
