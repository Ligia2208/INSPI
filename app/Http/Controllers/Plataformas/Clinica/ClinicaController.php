<?php

namespace App\Http\Controllers\Plataformas\Clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plataformas\Clinica;
use App\Models\Plataformas\Especimen;

class ClinicaController extends Controller
{
    //Tools
    public $perPage = 20;
    public $search;
    

    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.clinica.index');
    }

    public function mostrar(){
        return view('plataformas.clinica.mostrar');
    }

    public function agregar($id){
        $clinica = new Clinica();
        $clinica->especimen_id = $id;
        return view('plataformas.clinica.agregar', compact('clinica'));
    }

    public function show($id){
        $count = Clinica::count();
        $Clinicas = Clinica::orderBy('id', 'asc');
        

        if($this->search){
            $Clinicas = $Clinicas->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Clinicas = $Clinicas->paginate($this->perPage);
        $Especimenes = Especimen::where('id','=',$id)->orderBy('id', 'asc')->get();

        return view('plataformas.clinica.show', compact('id','count', 'Clinicas','Especimenes'));
    }
}
