<?php

namespace App\Http\Controllers\CoreBase\Cargo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:cargos']);
    }

    public function index(){
        return view('corebase.cargo.index');
    }
}
