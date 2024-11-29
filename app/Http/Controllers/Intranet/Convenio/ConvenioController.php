<?php

namespace App\Http\Controllers\Intranet\Convenio;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Convenio;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:convenios']);
    }

    public function index(){
        return view('intranet.convenio.index');
    }

    public function create(){
        $convenio = new Convenio();
        return view('intranet.convenio.create', compact('convenio'));
    }

    public function show(Convenio $convenio){
        return view('intranet.convenio.show', compact('convenio'));
    }

    public function edit(Convenio $convenio){
        return view('intranet.convenio.edit', compact('convenio'));
    }
}
