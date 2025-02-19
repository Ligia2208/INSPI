<?php

namespace App\Http\Controllers\Intranet\Resolucion;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Resolucion;
use Illuminate\Http\Request;

class ResolucionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:resoluciones']);
    }

    public function index(){
        return view('intranet.resolucion.index');
    }

    public function create(){
        $resolucion = new Resolucion();
        return view('intranet.resolucion.create', compact('resolucion'));
    }

    public function show(Resolucion $objRes){
        return view('intranet.resolucion.show', compact('objRes'));
    }

    public function edit(Resolucion $objRes){
        return view('intranet.resolucion.edit', compact('objRes'));
    }
}
