<?php

namespace App\Http\Controllers\CentrosReferencia\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:responsables']);
    }

    public function index(){
        return view('centrosreferencia.responsable.index');
    }

}
