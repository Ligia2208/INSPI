<?php

namespace App\Http\Controllers\Plataformas\Vacuna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Vacuna;
use App\Models\Plataformas\Especimen;

class VacunaController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;
    

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.vacuna.index');
    }

    public function mostrar(){
        return view('plataformas.vacuna.mostrar');
    }

    public function agregar($id){
        $vacuna = new Vacuna();
        $vacuna->especimen_id = $id;
        return view('plataformas.vacuna.agregar', compact('vacuna'));
    }

    public function show($id){
        $count = Vacuna::count();
        $Vacunas = Vacuna::orderBy('id', 'asc');
        

        if($this->search){
            $Vacunas = $Vacunas->where('codigo_nombre', 'LIKE', "%{$this->search}%");
        }

        $Vacunas = $Vacunas->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.vacuna.show', compact('id','count', 'Vacunas','Especimenes'));
    }
}
