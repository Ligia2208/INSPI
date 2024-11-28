<?php

namespace App\Http\Controllers\CentrosReferencia\Resultadocrn;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;

class ResultadocrnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:resultadoscrn']);
    }

    public function index(){
        return view('centrosreferencia.resultadocrn.index');
    }

    public function create(){
        $resultado = new Resultado();
        return view('centrosreferencia.resultadocrn.create', compact('resultado'));
    }

    public function show(Resultado $resultado){
        return view('centrosreferencia.resultadocrn.show', compact('resultado'));
    }

    public function edit(Resultado $resultado){
        return view('centrosreferencia.resultadocrn.edit', compact('resultado'));
    }
}
