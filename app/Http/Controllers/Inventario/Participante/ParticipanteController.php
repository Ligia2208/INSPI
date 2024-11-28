<?php

namespace App\Http\Controllers\Inventario\Participante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:participantes']);
    }

    public function index(){
        return view('inventario.participante.index');
    }
}
