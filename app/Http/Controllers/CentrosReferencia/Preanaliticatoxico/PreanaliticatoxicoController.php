<?php

namespace App\Http\Controllers\CentrosReferencia\Preanaliticatoxico;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Preanaliticatoxico;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;

class PreanaliticatoxicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:preanaliticatoxico']);
    }

    public function index(){
        return view('centrosreferencia.preanaliticatoxico.index');
    }

    public function create(){
        $preanalitica = new Preanaliticatoxico();
        return view('centrosreferencia.preanaliticatoxico.create', compact('preanalitica'));
    }

    public function show(Preanaliticatoxico $Preanaliticastoxico){
        $analitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$Preanaliticastoxico->id)->get();
        return view('centrosreferencia.preanaliticatoxico.show', compact('Preanaliticastoxico','analitica'));
    }

    public function edit(Preanaliticatoxico $Preanaliticastoxico){
        return view('centrosreferencia.preanaliticatoxico.edit', compact('Preanaliticastoxico'));
    }
}
