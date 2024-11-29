<?php

namespace App\Http\Controllers\Soporte\Ticketusercerrado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soporte\Ticketusercerrado;
use App\Models\Soporte\Detallesticket;


class TicketusercerradoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketusercerrado']);
    }

    public function index(){
        return view('soporte.ticketusercerrado.index');
    }

    public function show(Ticketusercerrado $ticketusercerrado){

        $detalles = Detallesticket::where('status','=','A')->where('ticket_id','=',$ticketusercerrado->id)->get();
        return view('soporte.ticketusercerrado.show', compact('ticketusercerrado','detalles'));
    }
}
