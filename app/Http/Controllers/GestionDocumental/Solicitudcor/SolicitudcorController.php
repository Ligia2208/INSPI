<?php

namespace App\Http\Controllers\GestionDocumental\Solicitudcor;

use App\Http\Controllers\Controller;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\Solicitudcor;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class SolicitudcorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:solicitud_coordinador']);
    }

    public function index(){
        return view('gestiondocumental.solicitudcor.index');
    }

    public function create(){
        $solicitudcor = new Solicitudcor();
        return view('gestiondocumental.solicitudcor.create', compact('solicitudcor'));
    }

    public function show(Solicitudcor $solicitudcor){
        if ($solicitudcor->dirtecnica_id>0){
            $dirtec = Direccion::where('id','=',$solicitudcor->dirtecnica_id)->firstOrFail();
        }
        else{
            $dirtec = null;
        }
        return view('gestiondocumental.solicitudcor.show', compact('solicitudcor','dirtec'));
    }

    public function edit(Solicitudcor $solicitudcor){
        return view('gestiondocumental.solicitudcor.edit', compact('solicitudcor'));
    }
}
