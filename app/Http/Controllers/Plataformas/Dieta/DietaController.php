<?php

namespace App\Http\Controllers\Plataformas\Dieta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Dieta;
use App\Models\Plataformas\Especimen;

class DietaController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;
    

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.dieta.index');
    }

    public function mostrar(){
        return view('plataformas.dieta.mostrar');
    }

    public function agregar($id){
        $dieta = new Dieta();
        $dieta->especimen_id = $id;
        return view('plataformas.dieta.agregar', compact('dieta'));
    }

    public function show($id){
        $count = Dieta::count();
        $Dietas = Dieta::orderBy('id', 'asc');
        

        if($this->search){
            $Dietas = $Dietas->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Dietas = $Dietas->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.dieta.show', compact('id','count', 'Dietas','Especimenes'));
    }
}
