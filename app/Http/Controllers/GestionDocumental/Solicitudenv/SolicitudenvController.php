<?php

namespace App\Http\Controllers\GestionDocumental\Solicitudenv;

use App\Http\Controllers\Controller;
use App\Models\GestionDocumental\Solicitudenv;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class SolicitudenvController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:asigna_solicitud']);
    }

    public function index(){
        return view('gestiondocumental.solicitudenv.index');
    }

    public function create(){
        $solicitudenv = new Solicitudenv();
        return view('gestiondocumental.solicitudenv.create', compact('solicitudenv'));
    }

    public function show(Solicitudenv $solicitudenv){
        if ($solicitudenv->destino_id>0){
            $destino = Area::where('id','=',$solicitudenv->destino_id)->firstOrFail();
        }
        else{
            $destino = null;
        }
        return view('gestiondocumental.solicitudenv.show', compact('solicitudenv','destino'));
    }

    public function edit(Solicitudenv $solicitudenv){
       return view('gestiondocumental.solicitudenv.edit', compact('solicitudenv'));
    }
}
