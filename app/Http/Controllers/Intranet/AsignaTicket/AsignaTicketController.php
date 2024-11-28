<?php

namespace App\Http\Controllers\Intranet\AsignaTicket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsignaTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:asignatickets']);
    }

    public function index(){
        return view('intranet.asignaticket.index');
    }
}
