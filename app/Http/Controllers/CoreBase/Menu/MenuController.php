<?php

namespace App\Http\Controllers\CoreBase\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:menues']);
    }

    public function index(){
        return view('corebase.menu.index');
    }
}
