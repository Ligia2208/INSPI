<?php

namespace App\Http\Controllers\CentrosReferencia\Preanaliticacd4;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Analitica;
use Illuminate\Http\Request;
use App\Imports\PacientesImport;
use Maatwebsite\Excel\Facades\Excel;
use Libraries\Services\Complement;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Session;

class Preanaliticacd4Controller extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:preanalitica']);
    }

    public function index(){
        return view('centrosreferencia.preanaliticacd4.index');
    }

    public function create(){
        $preanalitica = new Preanalitica();
        return view('centrosreferencia.preanaliticacd4.create', compact('preanalitica'));
    }

    public function show(Preanalitica $preanalitica){
        $analitica = Analitica::where('estado','=','A')->where('preanalitica_id','=',$preanalitica->id)->get();
        return view('centrosreferencia.preanaliticacd4.show', compact('preanalitica','analitica'));
    }

    public function edit(Preanalitica $preanalitica){
        return view('centrosreferencia.preanaliticacd4.edit', compact('preanalitica'));
    }

    public function importar(Request $request){
        Excel::import(new PacientesImport,$request->file('file')->store('files'));
        return redirect()->back();
    }
}
