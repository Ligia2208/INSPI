<?php

namespace App\Http\Controllers\CentrosLaminas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use App\Http\Requests\DocumentoRequest;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Models\User;
use App\Models\PermisoRolOpcion\PermisoRolOpcion;

use Datatables;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cache;
use League\CommonMark\Extension\Table\Table;


//Czonal y area
use App\Models\Czonal\Czonal;

//PDF
use Barryvdh\DomPDF\Facade as PDF;



//use App\Models\Area\Area;
use App\Models\CoreBase\Area;

use App\Traits\GetDireccionTrait;

class CentrosLaminasController extends Controller
{

    use GetDireccionTrait;

    public function index(Request $request){

        $estado = $request->input('estado');

        if(request()->ajax()) {

            $estado    = request()->get('estado');
            $direccion = request()->get('direccion');
            $item      = request()->get('item');
            $programa  = request()->get('programa');
            //$subactividad  = request()->get('subactividad');

            $query = Poa::select(
                'pla_poa1.id as id',
                'pla_poa1.departamento as coordinacion',
                'pla_poa1.nro_poa as numero',
                DB::raw('DATE_FORMAT(pla_poa1.updated_at, "%Y-%m-%d %H:%i:%s") as fecha'),
                'tipo_poa.nombre as POA',
                'objOpe.nombre as obj_operativo',
                'actOpe.nombre as act_operativa',
                'pro.nombre as proceso',
                'subAct.nombre as sub_actividad',
                'pla_poa1.estado as estado',
                'itep.nombre as item',
                'pla_poa1.monto',
                'pla_poa1.monto',
                'pla_tipo_subactividad.nombre as tipo_sub',
                'cal.justificacion_area as motivo'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
            ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
            ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
            ->join('pla_tipo_proceso as pro', 'pro.id', '=', 'db_inspi_planificacion.pla_poa1.id_proceso')
            ->join('db_inspi_planificacion.pla_item_presupuestario as itep', 'itep.id', '=', 'pla_poa1.id_item')
            ->join('db_inspi_planificacion.pla_calendario as cal', 'cal.id_poa', '=', 'pla_poa1.id')
            
            ->join('db_inspi_planificacion.pla_tipo_subactividad', 'pla_poa1.id_tipo_sub', '=', 'pla_tipo_subactividad.id')
            ->whereNotIn('pla_poa1.estado', ['E'])
            ->whereNotIn('pla_poa1.id_area', [17,18]);
        
            // **Aplicar filtros si se selecciona alguno**

            /*
            if (!empty($estado)) {
                $query->where('pla_poa1.estado', $estado);
            }
        
            if (!empty($direccion)) {
                $query->where('pla_poa1.id_area', $direccion);
            }
        
            if (!empty($item)) {
                $query->where('pla_poa1.id_item', $item);
            }

            if (!empty($programaIds)) {
                $query->whereIn('pla_poa1.programa', $programaIds);
            }
            */
        
            // **Devolver datos en formato JSON**
            return datatables()->of($query)->addIndexColumn()->make(true);
        }

        //respuesta para la vista
        return view('lamina.index', compact(1));

    }


    public function crear(){

        //respuesta para la vista
        return view('lamina.crear', compact(1));

    }


}




