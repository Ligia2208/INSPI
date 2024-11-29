<?php

namespace App\Http\Controllers\Intranet\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tickets']);
    }

    public function index(){
        return view('intranet.ticket.index');
    }

    public function create(){
        $ticket = new Ticket();
        return view('intranet.ticket.create', compact('ticket'));
    }

    public function show(Ticket $ticket){
        return view('intranet.ticket.show', compact('ticket'));
    }

    public function edit(Ticket $ticket){
        return view('intranet.ticket.edit', compact('ticket'));
    }
}
