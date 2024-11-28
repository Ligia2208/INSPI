<?php

namespace App\Http\Controllers\Plataformas\Tratamiento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Tratamiento;
use App\Models\Plataformas\Especimen;

class TratamientoController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.tratamiento.index');
    }

    public function mostrar(){
        return view('plataformas.tratamiento.mostrar');
    }

    public function agregar($id){
        $tratamiento = new Tratamiento();
        $tratamiento->especimen_id = $id;
        return view('plataformas.tratamiento.agregar', compact('tratamiento'));
    }

    public function show($id){
        $count = Tratamiento::count();
        $Tratamientos = Tratamiento::orderBy('id', 'asc');
        

        if($this->search){
            $Tratamientos = $Tratamientos->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Tratamientos = $Tratamientos->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.tratamiento.show', compact('id','count', 'Tratamientos','Especimenes'));
    }
}
