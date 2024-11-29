<?php

namespace App\Http\Controllers\GestionDocumental\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\GestionDocumental\Seguimiento;
use App\Models\User;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:seguimientos']);
    }

    public function index(){
        return view('gestiondocumental.seguimiento.index');
    }

    public function create(){
        $seguimiento = new Seguimiento();
        return view('gestiondocumental.seguimiento.create', compact('seguimiento'));
    }

    public function show(Seguimiento $seguimiento){
        
        if ($seguimiento->usuario_dirid>0){
            $control = User::where('id','=',$seguimiento->usuario_dirid)->firstOrFail();
            $tipo=1;
        }
        if ($seguimiento->dirtecnica_id>0){
            $control = Direccion::where('id','=',$seguimiento->dirtecnica_id)->firstOrFail();
            $tipo=2;
        }
        
        if ($seguimiento->usuario_tecid>0){
            $userTec = User::where('id','=',$seguimiento->usuario_tecid)->firstOrFail();
            $tipo=3;
            return view('gestiondocumental.seguimiento.show', compact('seguimiento','control','tipo','userTec'));    
        }
        else{
            return view('gestiondocumental.seguimiento.show', compact('seguimiento','control','tipo'));
        }        
    }

    public function edit(Seguimiento $seguimiento){
        return view('gestiondocumental.seguimiento.edit', compact('seguimiento'));
    }
}
