<?php

namespace App\Http\Controllers\Intranet\Evento;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:eventos']);
    }

    public function index(){
        return view('intranet.evento.index');
    }

    public function create(){
        $evento = new Evento();
        return view('intranet.evento.create', compact('evento'));
    }

    public function show(Evento $evento){
        return view('intranet.evento.show', compact('evento'));
    }

    public function edit(Evento $evento){
        return view('intranet.evento.edit', compact('evento'));
    }
}
