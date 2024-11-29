<?php

namespace App\Http\Controllers\Soporte\Tickettecnico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TickettecnicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tickettecnico']);
    }

    public function index(){
        return view('soporte.tickettecnico.index');
    }
}
