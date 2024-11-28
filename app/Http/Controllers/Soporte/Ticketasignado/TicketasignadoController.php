<?php

namespace App\Http\Controllers\Soporte\Ticketasignado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketasignadoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketasignado']);
    }

    public function index(){
        return view('soporte.ticketasignado.index');
    }
}
