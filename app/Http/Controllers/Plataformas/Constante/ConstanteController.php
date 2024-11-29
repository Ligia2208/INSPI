<?php

namespace App\Http\Controllers\Plataformas\Constante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Constante;
use App\Models\Plataformas\Especimen;

class ConstanteController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;
    

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.constante.index');
    }

    public function mostrar(){
        return view('plataformas.constante.mostrar');
    }

    public function agregar($id){
        $constante = new Constante();
        $constante->especimen_id = $id;
        return view('plataformas.constante.agregar', compact('constante'));
    }

    public function show($id){
        $count = Constante::count();
        $Constantes = Constante::orderBy('id', 'asc');
        

        if($this->search){
            $Constantes = $Constantes->where('codigo_nombre', 'LIKE', "%{$this->search}%");
        }

        $Constantes = $Constantes->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.constante.show', compact('id','count', 'Constantes','Especimenes'));
    }
}
