<?php

namespace App\Http\Controllers\Plataformas\Parasito;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Parasito;
use App\Models\Plataformas\Especimen;

class ParasitoController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;
    

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.parasito.index');
    }

    public function mostrar(){
        return view('plataformas.parasito.mostrar');
    }

    public function agregar($id){
        $parasito = new Parasito();
        $parasito->especimen_id = $id;
        return view('plataformas.parasito.agregar', compact('parasito'));
    }

    public function show($id){
        $count = Parasito::count();
        $Parasitos = Parasito::orderBy('id', 'asc');
        

        if($this->search){
            $Parasitos = $Parasitos->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $Parasitos = $Parasitos->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.parasito.show', compact('id','count', 'Parasitos','Especimenes'));
    }
}
