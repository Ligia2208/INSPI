<?php

namespace App\Http\Controllers\CentrosReferencia\VisorResultados;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;

class VisorResultadosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:visorresultados']);
    }

    public function index(){
        return view('centrosreferencia.visorresultados.index');
    }

}
