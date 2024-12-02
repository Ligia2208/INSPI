<?php

namespace App\Http\Controllers\CentrosReferencia\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:pacientes']);
    }

    public function index(){
        return view('centrosreferencia.paciente.index');
    }

}
