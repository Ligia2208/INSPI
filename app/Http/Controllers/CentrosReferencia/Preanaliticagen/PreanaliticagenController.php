<?php

namespace App\Http\Controllers\CentrosReferencia\Preanaliticagen;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Preanaliticagen;
use App\Models\CentrosReferencia\Preanaliticamico;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;

class PreanaliticagenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:preanaliticagen']);
    }

    public function index(){
        return view('centrosreferencia.preanaliticagen.index');
    }

    public function create(){
        $preanalitica = new Preanaliticagen();
        return view('centrosreferencia.preanaliticagen.create', compact('preanalitica'));
    }

    public function show(Preanaliticagen $Preanaliticasmico){
        $analitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$Preanaliticasmico->id)->get();
        return view('centrosreferencia.preanaliticagen.show', compact('Preanaliticasmico','analitica'));
    }

    public function edit(Preanaliticagen $Preanaliticastoxico){
        //dd($Preanaliticastoxico->getKey());
        return view('centrosreferencia.preanaliticagen.edit', compact('Preanaliticastoxico'));
    }

    
}
