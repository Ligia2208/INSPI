<?php

namespace App\Http\Controllers\Soporte\Ticketusertramite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soporte\Ticketusertramite;
use App\Models\Soporte\Detallesticket;


class TicketusertramiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketusertramite']);
    }

    public function index(){
        return view('soporte.ticketusertramite.index');
    }

    public function show(Ticketusertramite $ticketusertramite){

        $detalles = Detallesticket::where('status','=','A')->where('ticket_id','=',$ticketusertramite->id)->get();
        return view('soporte.ticketusertramite.show', compact('ticketusertramite','detalles'));
    }
}
