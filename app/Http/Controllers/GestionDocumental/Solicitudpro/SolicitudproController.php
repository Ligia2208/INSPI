<?php

namespace App\Http\Controllers\GestionDocumental\Solicitudpro;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\Solicitudpro;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class SolicitudproController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:solicitud_final']);
    }

    public function index(){
        return view('gestiondocumental.solicitudpro.index');
    }

    public function create(){
        $solicitudpro = new Solicitudpro();
        return view('gestiondocumental.solicitudpro.create', compact('solicitudpro'));
    }

    public function show(Solicitudpro $solicitudpro){
        if ($solicitudpro->usuario_dirid>0){
            $control = User::where('id','=',$solicitudpro->usuario_dirid)->firstOrFail();
            $tipo=1;
        }
        if ($solicitudpro->dirtecnica_id>0){
            $control = Direccion::where('id','=',$solicitudpro->dirtecnica_id)->firstOrFail();
            $tipo=2;
        }

        if ($solicitudpro->usuario_tecid>0){
            $userTec = User::where('id','=',$solicitudpro->usuario_tecid)->firstOrFail();
            $control = Direccion::where('id','=',$solicitudpro->dirtecnica_id)->firstOrFail();
            $tipo=3;
            return view('gestiondocumental.solicitudpro.show', compact('solicitudpro','control','tipo','userTec'));    
        }
        else{
            return view('gestiondocumental.solicitudpro.show', compact('solicitudpro','control','tipo'));
        }
        
    }

    public function edit(Solicitudpro $solicitudpro){
        if ($solicitudpro->usuario_dirid>0){
            $control = User::where('id','=',$solicitudpro->usuario_dirid)->firstOrFail();
            $tipo=1;
        }
        if ($solicitudpro->dirtecnica_id>0){
            $control = Direccion::where('id','=',$solicitudpro->dirtecnica_id)->firstOrFail();
            $tipo=2;
        }

        if ($solicitudpro->usuario_tecid>0){
            $userTec = User::where('id','=',$solicitudpro->usuario_tecid)->firstOrFail();
            $control = Direccion::where('id','=',$solicitudpro->dirtecnica_id)->firstOrFail();
            $tipo=3;
            return view('gestiondocumental.solicitudpro.edit', compact('solicitudpro','control','tipo','userTec')); 
        }
        else{
            return view('gestiondocumental.solicitudpro.edit', compact('solicitudpro','control','tipo'));
        }
    }
}
