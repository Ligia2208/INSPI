<?php

namespace App\Http\Controllers\Soporte\Ticketsupport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketsupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketsupport']);
    }

    public function index(){
        return view('soporte.ticketsupport.index');
    }
}
