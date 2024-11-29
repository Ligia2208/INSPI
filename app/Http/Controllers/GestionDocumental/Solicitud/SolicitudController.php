<?php

namespace App\Http\Controllers\GestionDocumental\Solicitud;

use App\Http\Controllers\Controller;
use App\Models\GestionDocumental\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:solicitudes']);
    }

    public function index(){
        return view('gestiondocumental.solicitud.index');
    }

    public function create(){
        $solicitud = new Solicitud();
        return view('gestiondocumental.solicitud.create', compact('solicitud'));
    }

    public function show(Solicitud $solicitud){
        return view('gestiondocumental.solicitud.show', compact('solicitud'));
    }

    public function edit(Solicitud $solicitud){
        return view('gestiondocumental.solicitud.edit', compact('solicitud'));
    }
}
