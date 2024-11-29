<?php

namespace App\Http\Controllers\Intranet\Revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intranet\Revision;
use App\Models\Intranet\Evidencia;
use App\Models\Intranet\Evento;

class RevisionController extends Controller
{
    public $search;
    public $perPage = 20;
    public function __construct()
    {
        $this->middleware(['permission:revisiones']);
    }

    public function index(){
        return view('intranet.revision.index');
    }

    public function show($id){
        
        $count = Evidencia::where('evento_id','=',$id)->count();
        $Evidencias = Evidencia::where('evento_id','=',$id)->orderBy('id', 'asc');
        

        if($this->search){
            $Evidencias = $Evidencias->where('evento_id','=',$id)->where('descripcion', 'LIKE', "%{$this->search}%");
        }

        $Evidencias = $Evidencias->paginate($this->perPage);
        $Evento = Evento::where('id','=',$id)->orderBy('id', 'asc')->get();
        
        return view('intranet.revision.show', compact('id','count', 'Evidencias', 'Evento'));
    }
}
