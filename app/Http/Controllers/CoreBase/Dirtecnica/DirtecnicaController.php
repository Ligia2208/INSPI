<?php

namespace App\Http\Controllers\CoreBase\Dirtecnica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirtecnicaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:direccionestec']);
    }

    public function index(){
        return view('corebase.dirtecnica.index');
    }
}
