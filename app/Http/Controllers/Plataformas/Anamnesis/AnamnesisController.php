<?php

namespace App\Http\Controllers\Plataformas\Anamnesis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Anamnesis;
use App\Models\Plataformas\Especimen;

class AnamnesisController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;
    

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.anamnesis.index');
    }

    public function mostrar(){
        return view('plataformas.anamnesis.mostrar');
    }

    public function agregar($id){
        $anamnesis = new Anamnesis();
        $anamnesis->especimen_id = $id;
        return view('plataformas.anamnesis.agregar', compact('anamnesis'));
    }

    public function show($id){
        $count = Anamnesis::count();
        $Anamnesiss = Anamnesis::orderBy('id', 'asc');
        

        if($this->search){
            $Anamnesiss = $Anamnesiss->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Anamnesiss = $Anamnesiss->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.anamnesis.show', compact('id','count', 'Anamnesiss','Especimenes'));
    }
}
