<?php

namespace App\Http\Controllers\Soporte\Ticketeliminado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketeliminadoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ticketeliminado']);
    }

    public function index(){
        return view('soporte.ticketeliminado.index');
    }
}
