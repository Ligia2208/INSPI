<?php

namespace App\Http\Controllers\CoreBase\Direccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:direcciones']);
    }

    public function index(){
        return view('corebase.direccion.index');
    }
}
