<?php

namespace App\Http\Controllers\CentrosReferencia\Resultadogerencial;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;

class ResultadogerencialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:resultadosgerencial']);
    }

    public function index(){
        return view('centrosreferencia.resultadogerencial.index');
    }

    public function create(){
        $resultado = new Resultado();
        return view('centrosreferencia.resultadogerencial.create', compact('resultado'));
    }

    public function show(Resultado $resultado){
        return view('centrosreferencia.resultadogerencial.show', compact('resultado'));
    }

    public function edit(Resultado $resultado){
        return view('centrosreferencia.resultadogerencial.edit', compact('resultado'));
    }
}
