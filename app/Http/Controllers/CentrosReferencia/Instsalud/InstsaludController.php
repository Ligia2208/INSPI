<?php

namespace App\Http\Controllers\CentrosReferencia\Instsalud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstsaludController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:instituciones']);
    }

    public function index(){
        return view('centrosreferencia.instsalud.index');
    }

}
