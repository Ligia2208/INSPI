<?php

namespace App\Http\Controllers\GestionDocumental\Historico;

use App\Http\Controllers\Controller;
use App\Models\GestionDocumental\Historico;
use App\Models\User;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:historicos']);
    }

    public function index(){
        return view('gestiondocumental.historico.index');
    }

    public function create(){
        $historico = new Historico();
        return view('gestiondocumental.historico.create', compact('historico'));
    }

    public function show(Historico $historico){
        
        if ($historico->usuario_dirid>0){
            $control = User::where('id','=',$historico->usuario_dirid)->firstOrFail();
            $tipo=1;
        }
        if ($historico->dirtecnica_id>0){
            $control = Direccion::where('id','=',$historico->dirtecnica_id)->firstOrFail();
            $tipo=2;
        }
        
        if ($historico->usuario_tecid>0){
            $userTec = User::where('id','=',$historico->usuario_tecid)->firstOrFail();
            $tipo=3;
            return view('gestiondocumental.historico.show', compact('historico','control','tipo','userTec'));    
        }
        else{
            return view('gestiondocumental.historico.show', compact('historico','control','tipo'));
        }        
    }

    public function edit(Historico $historico){
        return view('gestiondocumental.historico.edit', compact('historico'));
    }
}
