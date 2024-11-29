<?php

namespace App\Http\Controllers\Soporte\Tecnico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tecnicos']);
    }

    public function index(){
        return view('soporte.tecnico.index');
    }
}
