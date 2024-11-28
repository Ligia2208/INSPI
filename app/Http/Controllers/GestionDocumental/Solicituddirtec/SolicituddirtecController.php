<?php

namespace App\Http\Controllers\GestionDocumental\Solicituddirtec;

use App\Http\Controllers\Controller;
use App\Models\GestionDocumental\Solicituddirtec;
use App\Models\User;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class SolicituddirtecController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:solicitud_director_tecnico']);
    }

    public function index(){
        return view('gestiondocumental.solicituddirtec.index');
    }

    public function create(){
        $solicituddirtec = new Solicituddirtec();
        return view('gestiondocumental.solicituddirtec.create', compact('solicituddirtec'));
    }

    public function show(Solicituddirtec $solicituddirtec){
        if ($solicituddirtec->usuario_dirid>0){
            $control = User::where('id','=',$solicituddirtec->usuario_dirid)->firstOrFail();
            $tipo=1;
        }
        if ($solicituddirtec->dirtecnica_id>0){
            $control = Direccion::where('id','=',$solicituddirtec->dirtecnica_id)->firstOrFail();
            $tipo=2;
        }

        if ($solicituddirtec->usuario_tecid>0){
            $usertec = User::where('id','=',$solicituddirtec->usuario_tecid)->firstOrFail();
            $tipo=3;
        }
        else{
            $usertec = null;
        }
        return view('gestiondocumental.solicituddirtec.show', compact('solicituddirtec','control','tipo','usertec'));    
    }

    public function edit(Solicituddirtec $solicituddirtec){
        return view('gestiondocumental.solicituddirtec.edit', compact('solicituddirtec'));
    }
}
