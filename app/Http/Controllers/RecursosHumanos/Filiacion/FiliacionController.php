<?php

namespace App\Http\Controllers\RecursosHumanos\Filiacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FiliacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:contrataciones']);
    }

    public function index(){
        return view('recursoshumanos.filiacion.index');
    }

}
