<?php

namespace App\Http\Controllers\Intranet\Convenio;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Convenio;
use Illuminate\Http\Request;

class EstadisticaConvenioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:convenios']);
    }

    public function index(){
        return view('intranet.estadisticaconvenio.index');
    }
}
