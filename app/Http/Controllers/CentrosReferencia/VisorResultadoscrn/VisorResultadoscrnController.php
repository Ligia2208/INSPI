<?php

namespace App\Http\Controllers\CentrosReferencia\VisorResultadoscrn;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;

class VisorResultadoscrnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:visorresultadoscrn']);
    }

    public function index(){
        return view('centrosreferencia.visorresultadoscrn.index');
    }

}
