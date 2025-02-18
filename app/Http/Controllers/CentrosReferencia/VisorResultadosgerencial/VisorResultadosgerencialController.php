<?php

namespace App\Http\Controllers\CentrosReferencia\VisorResultadosgerencial;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;

class VisorResultadosgerencialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:visorresultadosgerencial']);
    }

    public function index(){
        return view('centrosreferencia.visorresultadosgerencial.index');
    }

}
