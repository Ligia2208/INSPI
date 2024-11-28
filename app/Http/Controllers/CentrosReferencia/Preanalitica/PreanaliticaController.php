<?php

namespace App\Http\Controllers\CentrosReferencia\Preanalitica;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;

class PreanaliticaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:preanalitica']);
    }

    public function index(){
        return view('centrosreferencia.preanalitica.index');
    }

    public function create(){
        $preanalitica = new Preanalitica();
        return view('centrosreferencia.preanalitica.create', compact('preanalitica'));
    }

    public function show(Preanalitica $preanalitica){
        $analitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$preanalitica->id)->get();
        return view('centrosreferencia.preanalitica.show', compact('preanalitica','analitica'));
    }

    public function edit(Preanalitica $preanalitica){
        return view('centrosreferencia.preanalitica.edit', compact('preanalitica'));
    }
}
