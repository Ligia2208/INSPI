<?php

namespace App\Http\Controllers\CoreBase\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:areas']);
    }

    public function index(){
        return view('corebase.area.index');
    }
}
