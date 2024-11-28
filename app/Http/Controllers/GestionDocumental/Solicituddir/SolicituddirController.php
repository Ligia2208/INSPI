<?php

namespace App\Http\Controllers\GestionDocumental\Solicituddir;

use App\Http\Controllers\Controller;
use App\Models\GestionDocumental\Solicituddir;
use App\Models\User;
use App\Models\GestionDocumental\Asignacion;
use Illuminate\Http\Request;

class SolicituddirController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:solicitud_director']);
    }

    public function index(){
        return view('gestiondocumental.solicituddir.index');
    }

    public function create(){
        $solicituddir = new Solicituddir();
        return view('gestiondocumental.solicituddir.create', compact('solicituddir'));
    }

    public function show(Solicituddir $solicituddir){
        if ($solicituddir->usuario_dirid>0){
            $userDir = User::where('id','=',$solicituddir->usuario_dirid)->firstOrFail();
        }
        else{
            $userDir = null;
        }
        return view('gestiondocumental.solicituddir.show', compact('solicituddir','userDir'));
        
    }

    public function edit(Solicituddir $solicituddir){
        return view('gestiondocumental.solicituddir.edit', compact('solicituddir'));
    }
}
