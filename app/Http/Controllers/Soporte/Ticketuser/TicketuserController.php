<?php

namespace App\Http\Controllers\Soporte\Ticketuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketuserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketuser']);
    }

    public function index(){
        return view('soporte.ticketuser.index');
    }
}
