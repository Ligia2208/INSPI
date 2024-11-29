<?php

namespace App\Http\Controllers\Intranet\Evidencia;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Evidencia;
use App\Models\Intranet\Evento;
use Illuminate\Http\Request;

class EvidenciaController extends Controller
{
    public $search;
    public $perPage = 20;
    public function __construct()
    {
        $this->middleware(['permission:evidencias']);
    }

    public function index(){
        return view('intranet.evidencia.index');
    }

    public function create(){
        $evidencia = new Evidencia();
        return view('intranet.evidencia.create', compact('evidencia'));
    }

    public function agregar($id){
        $evidencia = new Evidencia();
        $evidencia->evento_id = $id;
        return view('intranet.evidencia.agregar', compact('evidencia'));
    }

    public function show($id){
        $count = Evidencia::where('evento_id','=',$id)->count();
        $Evidencias = Evidencia::where('evento_id','=',$id)->orderBy('id', 'asc');
        

        if($this->search){
            $Evidencias = $Evidencias->where('evento_id','=',$id)->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Evidencias = $Evidencias->paginate($this->perPage);
        $Evento = Evento::where('id','=',$id)->orderBy('id', 'asc')->get();
        
        return view('intranet.evidencia.show', compact('id','count', 'Evidencias', 'Evento'));
    }
    


}
