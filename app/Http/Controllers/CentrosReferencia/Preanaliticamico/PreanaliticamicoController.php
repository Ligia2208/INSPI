<?php

namespace App\Http\Controllers\CentrosReferencia\Preanaliticamico;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Preanaliticamico;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;

class PreanaliticamicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:preanaliticamico']);
    }

    public function index(){
        return view('centrosreferencia.preanaliticamico.index');
    }

    public function create(){
        $preanalitica = new Preanaliticamico();
        return view('centrosreferencia.preanaliticamico.create', compact('preanalitica'));
    }

    public function show(Preanaliticamico $Preanaliticasmico){
        $analitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$Preanaliticasmico->id)->get();
        return view('centrosreferencia.preanaliticamico.show', compact('Preanaliticasmico','analitica'));
    }

    public function edit(Preanaliticamico $Preanaliticasmico){
        return view('centrosreferencia.preanaliticamico.edit', compact('Preanaliticasmico'));
    }
}
