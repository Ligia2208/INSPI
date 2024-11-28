<?php

namespace App\Http\Controllers\Soporte\Ticketseguimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soporte\Ticketseguimiento;
use App\Models\Soporte\Detallesticket;

class TicketseguimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketseguimiento']);
    }

    public function index(){
        return view('soporte.ticketseguimiento.index');
    }

    public function show(Ticketseguimiento $ticketseguimiento){
        
        $detalles = Detallesticket::where('status','=','A')->where('ticket_id','=',$ticketseguimiento->id)->get();
        return view('soporte.ticketseguimiento.show', compact('ticketseguimiento','detalles'));
    }
}
