<?php

namespace App\Http\Controllers\Soporte\Tickettecnicocerrado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TickettecnicocerradoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tickettecnicocerrado']);
    }

    public function index(){
        return view('soporte.tickettecnicocerrado.index');
    }
}
