<?php

namespace App\Http\Controllers\Soporte\Ticketurgente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketurgenteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketurgente']);
    }

    public function index(){
        return view('soporte.ticketurgente.index');
    }
}
