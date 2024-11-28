<?php

namespace App\Http\Controllers\CentrosReferencia\Resultado;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:resultados']);
    }

    public function index(){
        return view('centrosreferencia.resultado.index');
    }

    public function create(){
        $resultado = new Resultado();
        return view('centrosreferencia.resultado.create', compact('resultado'));
    }

    public function show(Resultado $resultado){
        return view('centrosreferencia.resultado.show', compact('resultado'));
    }

    public function edit(Resultado $resultado){
        return view('centrosreferencia.resultado.edit', compact('resultado'));
    }
}
