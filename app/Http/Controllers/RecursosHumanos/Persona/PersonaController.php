<?php

namespace App\Http\Controllers\RecursosHumanos\Persona;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:personas']);
    }

    public function index(){
        return view('recursoshumanos.persona.index');
    }

}
