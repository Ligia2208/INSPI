<?php

namespace App\Http\Controllers\Planificacion;

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

//PLANIFICACION
use App\Models\Planificacion\TipoMonto\TipoMonto;
use App\Models\Planificacion\TipoPoa\TipoPoa;
use App\Models\Planificacion\Poa1\Poa;
use App\Models\Planificacion\TipoProceso\TipoProceso;

//Czonal y area
use App\Models\Czonal\Czonal;


use App\Models\Planificacion\ObjetivoOperativo\ObjetivoOperativo;
use App\Models\Planificacion\SubActividad\SubActividad;
use App\Models\Planificacion\ActividadOperativa\ActividadOperativa;
use App\Models\Planificacion\Calendario\Calendario;

use App\Models\Planificacion\Comentario\Comentario;

//ITEM PRESUPUESTARIO
use App\Models\Planificacion\ItemPresupuestario\ItemPresupuestario;
use App\Models\ConsumoItem\ConsumoItem;
use App\Models\Planificacion\Comentario\ComentarioReforma;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

//ESTRUCTURA PRESUPUESTARIA
use App\Models\Planificacion\UnidadEjecutora\UnidadEjecutora;
use App\Models\Planificacion\Programa\Programa;
use App\Models\Planificacion\Proyecto\Proyecto;
use App\Models\Planificacion\ActividadPre\ActividadPre;
use App\Models\Planificacion\Fuente\Fuente;

//PDF
use Barryvdh\DomPDF\Facade as PDF;

// REFORMA
use App\Models\Planificacion\Reforma\Actividad;
use App\Models\Planificacion\Reforma\Reforma;
use App\Models\Planificacion\Reforma\CalendarioReforma;
use App\Models\Planificacion\Solicitud\Solicitud;

//nuevos
use App\Models\RecursosHumanos\Filiacion;
use App\Models\Planificacion\MontoDireccion\MontoDireccion;
use App\Models\Planificacion\ItemDireccion\ItemDireccion;

//use App\Models\Area\Area;
use App\Models\CoreBase\Area;


use App\Models\RecursosHumanos\Persona;
use App\Imports\ActividadImport;

use App\Exports\ReportDetalleExport;
//use Maatwebsite\Excel\Facades\Excel;

class PlanificacionController extends Controller
{

    public function index(Request $request){

        if(request()->ajax()) {

            return datatables()->of(Poa::select('pla_poa1.id as id', 'pla_poa1.departamento as coordinacion', 'pla_poa1.nro_poa as numero',
                DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'tipo_poa.nombre as POA',
                'objOpe.nombre as obj_operativo', 'actOpe.nombre as act_operativa', 'pro.nombre as proceso',
                'subAct.nombre as sub_actividad', 'pla_poa1.estado as estado', )
                ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
                ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
                ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
                ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
                ->join('pla_tipo_proceso as pro', 'pro.id', '=', 'db_inspi_planificacion.pla_poa1.id_proceso')
                ->whereIn('pla_poa1.estado', ['A','O','R','C', 'S'])
                ->groupBy('id', 'pla_poa1.departamento', 'pla_poa1.nro_poa', 'pla_poa1.created_at', 'pro.nombre',
                'tipo_poa.nombre' ,'obj_operativo','act_operativa','sub_actividad', 'pla_poa1.estado')
                ->get()
                )

                ->addIndexColumn()
                ->make(true);
        }

        $tipo_Poa = TipoPoa::where('estado', 'A')->get();
        $obj_Operativo = ObjetivoOperativo::where('estado', 'A')->get();
        $act_Operativa = ActividadOperativa::where('estado', 'A')->get();
        $sub_Act  = SubActividad::where('estado', 'A')->get();

        $direcciones  = Poa::select('departamento')->distinct()->get();
        //respuesta para la vista
        return view('planificacion.index', compact('tipo_Poa','obj_Operativo', 'direcciones',
            'act_Operativa','sub_Act'));
    }

// -----------------------------------------------------------------------------------------------------------

    /* VISTA - CREAR NUEVO EGRESO */
    public function crearPlanificacion($id_direccion){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $tipos   = TipoPoa::select('id', 'nombre')->where('estado', 'A')->get();
        $proceso = TipoProceso::select('id', 'nombre')->where('estado', 'A')->get();

        $objExistente = ObjetivoOperativo::where('id_area', $id_direccion)->get();

        $item_presupuestario = ItemPresupuestario::select('itemdir.id_item as id_item', 'itemdir.id as id', 'pla_item_presupuestario.nombre', 
            'pla_item_presupuestario.descripcion', 'itemdir.monto')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('itemdir.estado', 'A')
            ->where('itemdir.id_direcciones', $id_direccion)->get();

        $direccion  = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id', $id_direccion)->first();
        $montoTotal = ItemDireccion::where('id_direcciones', $id_direccion)->where('estado', 'A')->sum('monto');
        $id_fuente  = $direccion->id_fuente;
        $nombre     = $direccion->nombre;
        $montoDir   = $direccion->monto;

        $monto = $montoDir - $montoTotal;
        if($monto == 0){
            $monto = true;
        }else{
            $monto = false;
        }

        //respuesta para la vista
        return view('planificacion.create_planificacion', compact('tipos', 'item_presupuestario', 'id_fuente', 'nombre', 'objExistente', 'proceso', 'monto', 'montoDir'));
    }
    /* VISTA - CREAR NUEVO EGRESO */


//------------------------------------------------------------------------------------------------------------
    /* GUARDA LOS DATOS DEL POA INGRESADO */
    public function savePlanificacion(Request $request)
    {
        $data = $request->validate([

            'obOpera'    => 'required|numeric',
            'actOpera'   => 'required|string',
            'subActi'    => 'required|string',
            'item_presupuestario'    => 'required|string',
            'id_item_dir'=> 'required|string',
            'monto'      => 'required|string',
            //'presupuesto_proyectado' => 'required|string',
            'unidad_ejecutora'  => 'required|string',
            'programa'   => 'required|string',
            'proyecto'   => 'required|string',
            'actividad'  => 'required|string',
            'fuente_financiamiento'  => 'required|string',
            'coordina'   => 'required|string',
            'fecha'      => 'required|string',
            'poa'        => 'required|string',
            'anio'       => 'required|string',

            'frecuencia' => 'required|string',
            'meses'      => 'required|array',
            'plurianual' => 'required|boolean',
            'proceso'    => 'required|numeric',
            //'justifi'    => 'required|string',

        ]);

        $obOpera  = $request->input('obOpera');
        $id_obj_operativo = $obOpera;
        $actOpera = $request->input('actOpera');
        $subActi  = $request->input('subActi');

        $item_presupuestario  = $request->input('item_presupuestario');
        $id_item_dir  = $request->input('id_item_dir');
        $monto      = $request->input('monto');
        //$presupuesto_proyectado = $request->input('presupuesto_proyectado');
        $unidad_ejecutora = $request->input('unidad_ejecutora');
        $programa   = $request->input('programa');
        $proyecto   = $request->input('proyecto');
        $actividad  = $request->input('actividad');
        $fuente_financiamiento = $request->input('fuente_financiamiento');
        $coordina   = $request->input('coordina');
        $fecha      = $request->input('fecha');
        $anio       = $request->input('anio');
        $poa        = $request->input('poa');
        $frecuencia = $request->input('frecuencia');
        $meses      = $request->input('meses');
        $plurianual = $request->input('plurianual');
        $justifi    = $request->input('justifi');
        $id_proceso = $request->input('proceso');

        $id_usuario = Auth::user()->id;
        $filiacion  = Filiacion::with('area')->where('user_id', $id_usuario)->first();
        $id_area    = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_area   = $direccion->id;
            $monto_dir = $direccion->monto;

        }else{
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_area   = $direccion->id;
            $monto_dir = $direccion->monto;
        }

        //valida montos
        $total_act = Poa::selectRaw('SUM(monto) as total_monto')
            ->where('id_area', $id_area)
            ->where('estado', 'A')
            ->first();

        $total_act = $total_act->total_monto ?? 0;

        $monto_act = $monto + $total_act;
        $monto_sob = $monto_dir - $total_act;

        if($monto_act > $monto_dir){

            $monto = number_format($monto, 2, '.', ',');
            $monto_sob = number_format($monto_sob, 2, '.', ',');

            return response()->json(['message' 
                => 'El monto de esta actividad excede el monto tope de su dirección. Usted tiene un monto sobrante de $'.$monto_sob. ' Y su actividad tiene un monto de $'.$monto, 
                'data' => false], 500);

        }else{

            // Verificar si existe la actividad
            $nombreActExistente = ActividadOperativa::where('nombre', $actOpera)->first();
            if ($nombreActExistente) {
                // Si existe, usar su ID
                $id_actividad = $nombreActExistente->id;
            } else {
                // Si no existe, crear una nueva
                $actop = new ActividadOperativa;
                $actop->id_area = $id_area;
                $actop->nombre  = $actOpera;
                $actop->estado  = 'A';
                $actop->save();
                $id_actividad   = $actop->id;
            }

            // Verificar si existe la subactividad
            $nombreSubActExistente = SubActividad::where('nombre', $subActi)->first();
            if ($nombreSubActExistente) {
                // Si existe, usar su ID
                $id_sub_actividad = $nombreSubActExistente->id;
            } else {
                // Si no existe, crear una nueva
                $sub = new SubActividad;
                $sub->id_area = $id_area;
                $sub->nombre  = $subActi;
                $sub->estado  = 'A';
                $sub->save();
                $id_sub_actividad = $sub->id;
            }

            $datos = [
                'departamento'     => $coordina,
                'id_area'          => $id_area,
                'id_usuario'       => $id_usuario,
                'id_obj_operativo' => $id_obj_operativo,
                'id_actividad'     => $id_actividad,
                'id_sub_actividad' => $id_sub_actividad,
                'id_tipo_monto'    => $frecuencia,
                'id_tipo_poa'      => $poa,
                'id_item'          => $item_presupuestario,
                'id_item_dir'      => $id_item_dir,
                'monto'            => $monto,
                //'presupuesto_proyectado' => $presupuesto_proyectado,
                'u_ejecutora'      => $unidad_ejecutora,
                'programa'         => $programa,
                'proyecto'         => $proyecto,
                'actividad'        => $actividad,
                'fuente'           => $fuente_financiamiento,
                'fecha'            => $fecha,
                'año'              => $anio,
                'plurianual'       => $plurianual,
                'id_proceso'       => $id_proceso,
            ];
            $poas = Poa::create($datos);

            //se crea el calendario
            $calendario = new Calendario([
                'id_poa'     => $poas->id,
                'enero'      => $meses['Enero'],
                'febrero'    => $meses['Febrero'],
                'marzo'      => $meses['Marzo'],
                'abril'      => $meses['Abril'],
                'mayo'       => $meses['Mayo'],
                'junio'      => $meses['Junio'],
                'julio'      => $meses['Julio'],
                'agosto'     => $meses['Agosto'],
                'septiembre' => $meses['Septiembre'],
                'octubre'    => $meses['Octubre'],
                'noviembre'  => $meses['Noviembre'],
                'diciembre'  => $meses['Diciembre'],
                'total'      => $monto,
                'justificacion_area' =>$justifi,
            ]);
            $calendario->save();

            //se reduce el monto al item presupuestado
            $item = ItemDireccion::where('id', $id_item_dir)->first();
            $item->presupuesto  = $item->presupuesto - $monto;
            $item->save();

            if ($poa) {

                return response()->json(['message' => 'Actividad creada exitosamente', 'data' => true], 200);

            } else {
                return response()->json(['message' => 'Error al guardar la Actividad', 'data' => false], 500);
            }

        }

    }
    /* GUARDA LOS DATOS DEL POA INGRESADO */
    // -------------------------------------------------------------------------------------------------------

    //Mostrar la tabla de POA por área
    public function vistaUser(Request $request)
    {
        $id_user = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $area = $filiacion?->area?->nombre;
        $id_area = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;
    
        if ($id_area == 7) {
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $monto = number_format($direccion->monto, 2);
            $id_fuente = $direccion->id_fuente;
        } else {
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $monto = number_format($direccion->monto, 2);
            $id_fuente = $direccion->id_fuente;
        }
    
        $totalItems = Poa::selectRaw('SUM(monto) as total_monto')
            ->where('id_area', $id_direccion)
            ->where('estado', '!=', 'E')
            ->first();
        $totalOcupado = $totalItems->total_monto ?? 0;
        $totalOcupado = number_format($totalOcupado, 2);
    
        $items = ItemPresupuestario::select('pla_item_presupuestario.*')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_item_presupuestario.estado', 'A')
            ->where('itemdir.id_direcciones', $id_direccion)
            ->get();

    
        if (request()->ajax()) {
            $query = Poa::select('pla_poa1.id as id', 'pla_poa1.departamento as coordinacion', 'pla_poa1.nro_poa as numero',
                DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'tipo_poa.nombre as POA', 'pro.nombre as proceso',
                'objOpe.nombre as obj_operativo', 'actOpe.nombre as act_operativa', 'sp.estado_solicitud as estado_solicitud', 'item.nombre as item',
                'subAct.nombre as sub_actividad', 'pla_poa1.monto as monto', 'pla_poa1.estado as estado', 'sp.id as id_solicitud')
                ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
                ->join('pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
                ->join('pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
                ->join('pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
                ->join('pla_tipo_proceso as pro', 'pro.id', '=', 'db_inspi_planificacion.pla_poa1.id_proceso')
                ->join('pla_item_presupuestario as item', 'pla_poa1.id_item', '=', 'item.id')
                ->leftJoin('db_inspi_planificacion.pla_solicitud as sp', 'pla_poa1.id', '=', 'sp.id_actividad')
                ->whereIn('pla_poa1.estado', ['A', 'R', 'O', 'C', 'S'])
                ->where('pla_poa1.id_area', '=', $id_direccion);
    
            // Aplicar filtro por item si es que se seleccionó uno
            if ($request->has('item') && $request->item != '') {
                $query->where('pla_poa1.id_item', $request->item);
            }
    
            return datatables()->of($query->get())
                ->addIndexColumn()
                ->make(true);
        }
    
        return view('planificacion.vista_user', compact('id_direccion', 'monto', 'area', 'totalOcupado', 'items'));
    }
    


    //Eliminar registro de POA
    public function deletePoa(Request $request)
    {
        $poa = Poa::find($request->id); //Busca el registro por el ID

        if ($poa) {

            $poa->update([
                'estado' => 'E', //Asigna el estado "E" para no mostrarlo en la tabla
            ]);

            return response()->json(['message' => 'Registro eliminado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el registro', 'data' => false], 500);

        }

    }
    //Eliminar registro de POA

    //--------------------------------------------------------------------------------------------------------
    //Detalle del POA en base al calendario
    public function detalle(Request $request)
    {
        $id_usuario = Auth::user()->id;
    
        $anio = $request->input('anio') ?? date('Y'); // Por defecto, el año actual
        $direccion = $request->input('direccion');   // Dirección seleccionada
        $item = $request->input('item');             // Item seleccionado
        $sub_actividad = $request->input('sub_actividad'); // Sub actividad seleccionada
    
        if (request()->ajax()) {
            $query = Poa::select(
                'pla_poa1.id as id', 'area.nombre as Area', 'tipo_poa.nombre as POA',
                'actOpe.nombre as act_operativa', 'itep.nombre as item',
                'objOpe.nombre as obj_operativo', 'subAct.nombre as sub_actividad',
                'cal.enero as enero', 'cal.febrero as febrero', 'cal.marzo as marzo', 
                'cal.abril as abril', 'cal.mayo as mayo', 'cal.junio as junio',
                'cal.julio as julio', 'cal.agosto as agosto', 'cal.septiembre as septiembre', 
                'cal.octubre as octubre', 'cal.noviembre as noviembre', 'cal.diciembre as diciembre', 'pla_poa1.monto'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
            ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
            ->join('db_inspi_planificacion.pla_calendario as cal', 'cal.id_poa', '=', 'db_inspi_planificacion.pla_poa1.id')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'db_inspi_planificacion.pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_items_direcciones as ite', 'ite.id', '=', 'db_inspi_planificacion.pla_poa1.id_item_dir')
            ->join('db_inspi_planificacion.pla_item_presupuestario as itep', 'itep.id', '=', 'ite.id_item')
            ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
            ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
            ->where('pla_poa1.estado', '!=', 'E')
            ->where('pla_poa1.año', $anio);
    
            // Filtros dinámicos
            if ($direccion) {
                $query->where('area.id', $direccion);
            }
            if ($item) {
                $query->where('itep.id', $item);
            }
            if ($sub_actividad) {
                $query->where('subAct.id', $sub_actividad);
            }
    
            $data = $query->groupBy(
                'id', 'Area', 'POA', 'obj_operativo', 'act_operativa', 'sub_actividad', 'itep.nombre',
                'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 
                'septiembre', 'octubre', 'noviembre', 'diciembre', 'monto'
            )->get();
    
            return datatables()->of($data)->addIndexColumn()->make(true);
        }
    
        $tipo_Poa = TipoPoa::where('estado', 'A')->get();
        $act_Operativa = ActividadOperativa::where('estado', 'A')->get();
        $calendario = Calendario::where('estado', 'A')->get();
        $direcciones = MontoDireccion::where('estado', 'A')->get();
        $items = ItemPresupuestario::where('estado', 'A')->get();
        $sub_actividades = SubActividad::where('estado', 'A')->get();

        $sumaMontos = ItemDireccion::where('estado', 'A')->sum('monto');

        $sumaActividades = Poa::where('estado', 'O')
            ->where('año', $anio)
            ->sum('monto');
    
        return view('planificacion.detalle_poa', compact(
            'tipo_Poa', 'act_Operativa', 'calendario', 'direcciones', 'items', 'sub_actividades',
            'sumaMontos', 'sumaActividades'
        ));
    }
    


    //Detalle del POA en base al calendario
    public function detalleUser(Request $request){
        //respuesta para la vista
        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
            $monto        = number_format($monto, 2);
            $id_fuente    = $direccion->id_fuente;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
            $monto        = number_format($monto, 2);
            $id_fuente    = $direccion->id_fuente;
        }

        $anio = $request->input('anio');
        if (isset($anio)) {
            $anio = $request->input('anio');
        }else{
            $anio = date('Y');
        }

        if(request()->ajax()) {

                return datatables()->of(Poa::select('pla_poa1.id as id', 'area.nombre as Area',
                    'tipo_poa.nombre as POA','actOpe.nombre as act_operativa',
                    'objOpe.nombre as obj_operativo','subAct.nombre as sub_actividad',
                    'cal.enero as enero', 'cal.febrero as febrero','cal.marzo as marzo','cal.abril as abril',
                    'cal.mayo as mayo','cal.junio as junio','cal.julio as julio','cal.agosto as agosto',
                    'cal.septiembre as septiembre','cal.octubre as octubre','cal.noviembre as noviembre','cal.diciembre as diciembre')
                    ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
                    ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
                    ->join('db_inspi_planificacion.pla_calendario as cal', 'cal.id_poa', '=', 'db_inspi_planificacion.pla_poa1.id')
                    ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'db_inspi_planificacion.pla_poa1.id_area')
                    ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
                    ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
                    ->where('pla_poa1.estado', '!=', 'E')
                    ->where('pla_poa1.id_area', '=', $id_direccion)
                    ->where('pla_poa1.año', $anio)
                    ->groupBy('id', 'Area', 'POA', 'obj_operativo','act_operativa','sub_actividad',
                    'enero' ,'febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre')
                    ->get()

                )

                ->addIndexColumn()
                ->make(true);

        }

        $sumaActividades = Poa::where('estado', '!=', 'E')
            ->where('año', $anio)
            ->where('pla_poa1.id_area', '=', $id_direccion)
            ->sum('monto');

        $sumaActividades = number_format($sumaActividades, 2, '.', ',');

        //respuesta para la vista
        return view('planificacion.detalleUser_poa', compact('sumaActividades', 'id_direccion'));

    }



    /* TRAER COMENTARIO POR POA */
    public function obtenerComentarios($id)
    {
        // Busca el POA por su ID
        $poa = Poa::find($id);

        if (!$poa) {
            return response()->json(['message' => 'POA no encontrado'], 404);
        }

        $comentarios = Comentario::select('users.name as id_usuario', 'pla_comentario.comentario', 'pla_comentario.estado_planificacion',
            DB::raw('DATE_FORMAT(pla_comentario.created_at, "%Y-%m-%d %H:%i:%s") as fecha'),
            'pla_comentario.id_poa')
            ->where('id_poa', $id)
            ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario.id_usuario')
            // ->where('id_usuario', $id_usuario)
            ->orderBy('fecha', 'asc')
            // ->where()
            ->get();

        return response()->json(['poa' => $poa, 'comentarios' => $comentarios]);
    }
    /* TRAER COMENTARIO POR POA */


    //------------------------------------------------------------------------------------------------------------
    //AQUÍ COMIENZA LO DE LUIS


    public function editarEstadoPlanificacion(Request $request, $id){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $Poa        = Poa::where('id', $id)->first();
        $tipos      = TipoPoa::select('id', 'nombre')->where('estado', 'A')->get();
        $calendario = Calendario::where('id_poa', $id)->first();
        $tipoMonto  = TipoMonto::select('id', 'nombre')->where('estado', 'A')->get();

        $unidad_eje = UnidadEjecutora::select('id', 'nombre')->where('estado', 'A')->get();
        $programa   = Programa::select('id', 'nombre')->where('estado', 'A')->get();
        $proyecto   = Proyecto::select('id', 'nombre')->where('estado', 'A')->get();
        $actividad  = ActividadPre::select('id', 'nombre')->where('estado', 'A')->get();
        $fuente     = Fuente::select('id', 'nombre')->where('estado', 'A')->get();

        $comentarios = Comentario::select('users.name as id_usuario', 'pla_comentario.comentario', 'pla_comentario.id_poa', 'pla_comentario.created_at',
        'pla_comentario.estado_planificacion as estado_planificacion')
        ->where('id_poa', $id)
        ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario.id_usuario')
        ->orderBy('created_at', 'asc')
        ->get();

            //VERSION3 DEL QUERY GENERAL (FINAL)
            //VERSION2 DEL QUERY GENERAL
            $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero', 'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa',
            'pla_calendario.justificacion_area as justificacion','pla_poa1.plurianual as plurianual', 'pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
            'pla_poa1.u_ejecutora as u_ejecutora', 'pla_poa1.programa as programa', 'pla_poa1.proyecto as proyecto',
            'pla_poa1.actividad as actividad', 'pla_poa1.fuente as fuente', 'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.presupuesto_proyectado as presupuesto_proyectado', 'pla_poa1.id_tipo_monto as idTipoMonto',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
            'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
            'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->leftJoin('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_poa1.id', $id)
            //->whereIn('pla_poa1.estado', ['A','R','O','C'])
            ->first();

            $item_presupuestario = ItemPresupuestario::where('estado', 'A')->get();

        return view('planificacion.edit_estado_planificacion', compact('Poa', 'tipos', 'calendario', 'atributos', 'tipoMonto',
        'comentarios', 'item_presupuestario', 'unidad_eje', 'programa', 'proyecto', 'actividad', 'fuente'));
    }

    //------------------------------------------------------------------------------------------------------------


    public function agregarComentarioEstado(Request $request)
    {
        $data = $request->validate([
            'id_poa'    => 'required|string',
            'estadoPoa' => 'required|string',
            'justificacionPoa'  => 'required|string',
        ]);
    
        $id_poa    = $request->input('id_poa');
        $estadoPoa = $request->input('estadoPoa');
        $justificacionPoa  = $request->input('justificacionPoa');
    
        $estados = [
            'R' => 'Rechazado',
            'O' => 'Aprobado',
            'C' => 'Corregido',
        ];
    
        $estadoTexto = $estados[$estadoPoa] ?? 'Desconocido';
    
        $id_usuario = Auth::user()->id;
    
        DB::beginTransaction(); // Inicia la transacción
    
        try {
            $datos = [
                'id_poa'     => $id_poa,
                'id_usuario' => $id_usuario,
                'comentario' => $justificacionPoa,
                'estado_planificacion' => $estadoTexto
            ];
            $comentario = Comentario::create($datos);
    
            $Poa = Poa::where('id', $id_poa)->first();
            $calendario = Calendario::where('id_poa', $id_poa)->first();
    
            if ($estadoPoa == 'O') {
                $itemPre = ItemDireccion::where('id', $Poa->id_item_dir)
                    ->where('estado', 'A')
                    ->first();
    
                if ($itemPre) {
                    $monto = $itemPre->monto - $calendario->total;
                    $tipo = 'I';
    
                    $itemPre->monto = $monto;
                    $itemPre->save();
    
                    ConsumoItem::actualizarEstadosPorIdItem($Poa->id_item);
    
                    $fecha = date('Y-m-d H:i:s');
                    $anio = date('Y');
    
                    $consumo = ConsumoItem::create([
                        'id_item'         => $itemPre->id,
                        'id_actividad'    => $id_poa,
                        'monto_consumido' => $calendario->total,
                        'monto'           => $monto,
                        'fecha'           => $fecha,
                        'anio'            => $anio,
                        'tipo'            => $tipo,
                    ]);
    
                    $id_consumo = $consumo->id;
                }
    
                $ultimoNroPoa = Poa::where('estado', 'O')->max('nro_poa');
                $nuevoNroPoa = $ultimoNroPoa ? $ultimoNroPoa + 1 : 1;
    
                $Poa->update([
                    'estado' => $estadoPoa,
                    'nro_poa' => $nuevoNroPoa,
                    'id_consumo' => $id_consumo ?? null,
                ]);
            } else {
                $Poa->update([
                    'estado' => $estadoPoa,
                ]);
            }
    
            DB::commit(); // Confirma la transacción
    
            return response()->json(['message' => 'La actividad se ha revisado exitosamente', 'data' => true], 200);
    
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
    
            return response()->json(['message' => 'Error al validar la actividad: ' . $e->getMessage(), 'data' => false], 500);
        }
    }

    //------------------------------------------------------------------------------------------------------------


    public function agregarComentario(Request $request)
    {

        $data = $request->validate([
             'id_poa'    => 'required|string',
             'estadoPoa' => 'required|string',
             'justificacionPoa'  => 'required|string',
         ]);

         $id_poa    = $request->input('id_poa');
         $estadoPoa = $request->input('estadoPoa');
         $justificacionPoa  = $request->input('justificacionPoa');

        // Verificar si existen comentarios previos para el id_poa dado
        $comentarioExistente = Comentario::where('id_poa', $id_poa)->exists();

        // Obtener el estado anterior solo si hay comentarios previos para este id_poa
        if ($comentarioExistente) {
            $ultimoComentario = Comentario::where('id_poa', $id_poa)->orderBy('created_at', 'desc')->first();
            $estadoAnterior = $ultimoComentario->estado_planificacion;
        } else {
            $estadoAnterior = 'Ingresado'; // Estado por defecto si no hay comentarios previos
        }

        $id_usuario = Auth::user()->id;

        $datos = [
            'id_poa'     => $id_poa,
            'id_usuario' => $id_usuario,
            'comentario' => $justificacionPoa,
            'estado_planificacion' => $estadoAnterior,
         ];
        $comentario = Comentario::create($datos);

        $Poa = Poa::where('id', $id_poa)->first();

        $Poa->update([
            'estado' => $estadoPoa,
        ]);

        if ($comentario) {
            return response()->json(['message' => 'La actividad se ha validado exitosamente', 'data' => true], 200);

        } else {
            return response()->json(['message' => 'Error al validar la actividad', 'data' => false], 500);
        }

    }

    //------------------------------------------------------------------------------------------------------------

    public function editarPlanificacion(Request $request, $id){

        // ====== para traer la estructura presupuestaria
        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
        }

        $estrutura = Fuente::select('pla_fuente.id as id_fuente', 'act.id as id_actividad', 'pro.id as id_proyecto',
                'proy.id as id_programa', 'uni.id as id_unidad')
            ->join('pla_actividad_act as act', 'act.id', '=', 'pla_fuente.id_actividad')
            ->join('pla_proyecto as pro', 'pro.id', '=', 'act.id_proyecto')
            ->join('pla_programa as proy', 'proy.id', '=', 'pro.id_programa')
            ->join('pla_unidad_ejecutora as uni', 'uni.id', '=', 'proy.id_unidad')
            ->where('pla_fuente.id', $id_fuente)->first();

        $tipos      = TipoPoa::select('id', 'nombre')->where('estado', 'A')->get();
        $proceso    = TipoProceso::select('id', 'nombre')->where('estado', 'A')->get();
        $unidad_eje = UnidadEjecutora::select('id', 'nombre')->where('estado', 'A')->get();
        $programa   = Programa::where('estado', 'A')->where('id_unidad', $estrutura->id_unidad)->get();
        $proyecto   = Proyecto::where('estado', 'A')->where('id_programa', $estrutura->id_programa)->get();
        $actividad  = ActividadPre::where('estado', 'A')->where('id_proyecto', $estrutura->id_proyecto)->get();
        $fuente     = Fuente::where('estado', 'A')->where('id_actividad', $estrutura->id_actividad)->get();
        $tipoMonto  = TipoMonto::select('id', 'nombre')->where('estado', 'A')->get();
        $objExistente = ObjetivoOperativo::where('id_area', $id_direccion)->get();
        // ====== para traer la estructura presupuestaria


        //El where hace que se asocie con el Id_poa. Tenía otro where para que se asocie con el id_usuario pero creo que no es la finalidad de la vista.
        $comentarios = Comentario::select('users.name as id_usuario', 'pla_comentario.comentario', 'pla_comentario.id_poa', 'pla_comentario.created_at',
            'pla_comentario.estado_planificacion as estado_planificacion')
            ->where('id_poa', $id)
            ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario.id_usuario')
            // ->where('id_usuario', $id_usuario)
            ->orderBy('created_at', 'asc')
            // ->where()
            ->get();

        $atributos_operativos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id', 'pla_obj_operativo.id as id_objetivo_operativo', 'pla_actividad_operativa.id as id_actividad_operativa',
            'pla_sub_actividad.id as id_sub_actividad')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->where('pla_poa1.id', $id)
            ->whereIn('pla_poa1.estado', ['A','R','O', 'C'])
            ->first();

        //$item_presupuestario = ItemPresupuestario::where('estado', 'A')->get();

        $item_presupuestario = ItemPresupuestario::select('itemdir.id_item as id_item', 'itemdir.id as id', 'pla_item_presupuestario.nombre', 
            'pla_item_presupuestario.descripcion', 'itemdir.monto')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('itemdir.estado', 'A')
            ->where('itemdir.id_direcciones', $id_direccion)->get();


        //VERSION2 DEL QUERY GENERAL
        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero', 'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa',
            'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual','pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.presupuesto_proyectado as presupuesto_proyectado',
            'pla_poa1.u_ejecutora as u_ejecutora', 'pla_poa1.programa as programa', 'pla_poa1.proyecto as proyecto', 'pla_poa1.id_proceso',
            'pla_poa1.actividad as actividad', 'pla_poa1.fuente as fuente', 'pla_poa1.id_tipo_monto as idTipoMonto', 'pla_poa1.id_obj_operativo',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
            'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
            'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item_dir as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            // ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->leftJoin('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_poa1.id', $id)
            ->whereIn('pla_poa1.estado', ['A','R','O', 'C'])
            ->first();
            
            return view('planificacion.edit_planificacion', compact('tipos', 'atributos', 'tipoMonto', 'comentarios', 'item_presupuestario', 'atributos_operativos',
            'unidad_eje', 'programa', 'proyecto', 'actividad', 'fuente', 'proceso', 'objExistente'));

    }


    public function visualizarPlanificacion(Request $request, $id){

        // ====== para traer la estructura presupuestaria
        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
        }

        $estrutura = Fuente::select('pla_fuente.id as id_fuente', 'act.id as id_actividad', 'pro.id as id_proyecto',
                'proy.id as id_programa', 'uni.id as id_unidad')
            ->join('pla_actividad_act as act', 'act.id', '=', 'pla_fuente.id_actividad')
            ->join('pla_proyecto as pro', 'pro.id', '=', 'act.id_proyecto')
            ->join('pla_programa as proy', 'proy.id', '=', 'pro.id_programa')
            ->join('pla_unidad_ejecutora as uni', 'uni.id', '=', 'proy.id_unidad')
            ->where('pla_fuente.id', $id_fuente)->first();

        $tipos      = TipoPoa::select('id', 'nombre')->where('estado', 'A')->get();
        $unidad_eje = UnidadEjecutora::select('id', 'nombre')->where('estado', 'A')->get();
        $programa   = Programa::where('estado', 'A')->where('id_unidad', $estrutura->id_unidad)->get();
        $proyecto   = Proyecto::where('estado', 'A')->where('id_programa', $estrutura->id_programa)->get();
        $actividad  = ActividadPre::where('estado', 'A')->where('id_proyecto', $estrutura->id_proyecto)->get();
        $fuente     = Fuente::where('estado', 'A')->where('id_actividad', $estrutura->id_actividad)->get();
        $tipoMonto  = TipoMonto::select('id', 'nombre')->where('estado', 'A')->get();
        // ====== para traer la estructura presupuestaria


        //El where hace que se asocie con el Id_poa. Tenía otro where para que se asocie con el id_usuario pero creo que no es la finalidad de la vista.
        $comentarios = Comentario::select('users.name as id_usuario', 'pla_comentario.comentario', 'pla_comentario.id_poa', 'pla_comentario.created_at',
            'pla_comentario.estado_planificacion as estado_planificacion')
            ->where('id_poa', $id)
            ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario.id_usuario')
            // ->where('id_usuario', $id_usuario)
            ->orderBy('created_at', 'asc')
            // ->where()
            ->get();

        $atributos_operativos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id', 'pla_obj_operativo.id as id_objetivo_operativo', 'pla_actividad_operativa.id as id_actividad_operativa',
            'pla_sub_actividad.id as id_sub_actividad')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->where('pla_poa1.id', $id)
            ->whereIn('pla_poa1.estado', ['A','R','O', 'C'])
            ->first();

        $item_presupuestario = ItemPresupuestario::where('estado', 'A')->get();


        //VERSION2 DEL QUERY GENERAL
        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero', 'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa',
            'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual','pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.presupuesto_proyectado as presupuesto_proyectado',
            'pla_poa1.u_ejecutora as u_ejecutora', 'pla_poa1.programa as programa', 'pla_poa1.proyecto as proyecto',
            'pla_poa1.actividad as actividad', 'pla_poa1.fuente as fuente', 'pla_poa1.id_tipo_monto as idTipoMonto',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
            'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
            'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item_dir as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            // ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->leftJoin('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_poa1.id', $id)
            ->whereIn('pla_poa1.estado', ['A','R','O', 'C'])
            ->first();

            return view('planificacion.view_planificacion', compact('tipos', 'atributos', 'tipoMonto', 'comentarios', 'item_presupuestario', 'atributos_operativos',
            'unidad_eje', 'programa', 'proyecto', 'actividad', 'fuente'));

    }


    public function actualizarPlanificacion(Request $request, $id){
        $poa = Poa::find($id);

        $poa->departamento = $request->input('coordina');
        $poa->fecha        = $request->input('fecha');
        $poa->id_item      = $request->input('item_presupuestario');
        $poa->id_item_dir  = $request->input('id_item_dir');
        $poa->monto        = $request->input('monto');
        $poa->id_tipo_monto = $request->input('frecuencia');
        $poa->id_proceso    = $request->input('proceso');

        //$poa->presupuesto_proyectado = $request->input('presupuesto_proyectado');

        $poa->u_ejecutora  = $request->input('unidad_ejecutora');
        $poa->programa     = $request->input('programa');
        $poa->proyecto     = $request->input('proyecto');
        $poa->actividad    = $request->input('actividad');
        $poa->fuente       = $request->input('fuente_financiamiento');

        $poa->plurianual   = $request->input('plurianual');
        $poa->id_obj_operativo    = $request->input('obOpera');

        // Verificar si el estado actual es "Rechazado"
        if ($poa->estado === 'R') {
            // Cambiar el estado a "Corregido"
            $poa->estado = 'C';
        }

        $poa->save();

        $poa_ = Poa::findOrFail($id);
        /*
        if ($poa_->id_obj_operativo) {
            $objetivoOperativo = ObjetivoOperativo::find($poa->id_obj_operativo);
            if ($objetivoOperativo) {
                $objetivoOperativo->nombre = $request->input('obOpera');
                $objetivoOperativo->save();
            }
        }
        */

        // Actualizar la actividad operativa si existe
        if ($poa_->id_actividad) {
            $actividadOperativa = ActividadOperativa::find($poa->id_actividad);
            if ($actividadOperativa) {
                $actividadOperativa->nombre = $request->input('actOpera');
                $actividadOperativa->save();
            }
        }

        // Actualizar la subactividad si existe
        if ($poa_->id_sub_actividad) {
            $subActividad = SubActividad::find($poa->id_sub_actividad);
            if ($subActividad) {
                $subActividad->nombre = $request->input('subActi');
                $subActividad->save();
            }
        }

        $calendario = Calendario::where('id_poa', $id)->first();

        $calendario->justificacion_area = $request->input('justifi');

        $meses = $request->input('meses');
        $calendario->enero      = $meses['Enero'];
        $calendario->febrero    = $meses['Febrero'];
        $calendario->marzo      = $meses['Marzo'];
        $calendario->abril      = $meses['Abril'];
        $calendario->mayo       = $meses['Mayo'];
        $calendario->junio      = $meses['Junio'];
        $calendario->julio      = $meses['Julio'];
        $calendario->agosto     = $meses['Agosto'];
        $calendario->septiembre = $meses['Septiembre'];
        $calendario->octubre    = $meses['Octubre'];
        $calendario->noviembre  = $meses['Noviembre'];
        $calendario->diciembre  = $meses['Diciembre'];
        $calendario->save();

        //GUARDAR EL COMENTARIO EN LA TABLA DE COMENTARIO2
        $id_poa = $id;
        $comentarioRetro = $request->input('comentario');
        $id_usuario      = Auth::user()->id;

        // Verificar si hay comentarios previos para este id_poa
        $comentarioExistente = Comentario::where('id_poa', $id_poa)->exists();

        // Obtener el estado anterior si hay comentarios previos
        if ($comentarioExistente) {
            $ultimoComentario = Comentario::where('id_poa', $id_poa)->orderBy('created_at', 'desc')->first();
            $estadoAnterior   = $ultimoComentario->estado_planificacion;
        } else {
            $estadoAnterior = 'Ingresado'; // Estado por defecto si no hay comentarios previos
        }

        // Verificar si el estado de $poa es "Rechazado" y ha sido editado
        if ($poa->estado === 'C') {
            $estadoAnterior = 'Corregido'; // Cambiar el estado a "Editado" en el comentario
        }

        // Crear datos del comentario
        $datosComentario = [
            'id_poa'     => $id_poa,
            'id_usuario' => $id_usuario,
            'comentario' => $comentarioRetro,
            'estado_planificacion' => $estadoAnterior, // Asignar el estado determinado
        ];

        // Intentar crear el comentario
        try {
            $comentario = Comentario::create($datosComentario);

            if ($comentario) {
                return response()->json(['message' => 'La actividad se ha actualizado exitosamente', 'data' => true], 200);
            } else {
                return response()->json(['message' => 'Error al actualizar la actividad', 'data' => false], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la actividad: ' . $e->getMessage(), 'data' => false], 500);
        }


        // return response()->json(['success' => true, 'message' => 'La planificación se ha actualizado correctamente']);

    }

    public function obtenerDatosItem($id) {

        $item = ItemPresupuestario::select('itemdir.id', 'pla_item_presupuestario.nombre', 'pla_item_presupuestario.descripcion',
                'itemdir.monto')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('itemdir.estado', 'A')
            ->where('itemdir.id', $id)->first();

        //$item = ItemPresupuestario::findOrFail($id);

        // Retornar los datos como JSON
        return response()->json([
            'monto'       => $item->monto,
            'descripcion' => $item->descripcion,
        ]);

    }
    //========================================Aquí inicia PDF===============================================



    /* GENERAR PDF  */
    public function reportHexa(Request $request)
    {
        $id_poa  = $request->query('id_poa');

        $usuarios = [
            'creado'     => ['name' => $request->input('id_creado'),'cargo' => $request->input('cargo_creado')],
            'autorizado' => ['name' => $request->input('id_autorizado'),'cargo' => $request->input('cargo_autorizado')],
            'reporta'    => ['name' => $request->input('id_reporta'),'cargo' => $request->input('cargo_reporta')],
            'areaReq'    => ['name' => $request->input('id_areaReq'),'cargo' => $request->input('cargo_areaReq')],
            'planificacionYG' => ['name' => $request->input('id_planificacionYG'),'cargo' => $request->input('cargo_planificacionYG')],
        ];

        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero',
            DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_poa1.updated_at, "%Y-%m-%d") as fecha_apr'),
            DB::raw('SUM(pla_consumo_item.monto + pla_consumo_item.monto_consumido) as consumoItem'),
            'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa',
            'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual','pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.id_tipo_monto as idTipoMonto', 'pla_calendario.justificacion_area as justificacion_area',
            'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
            'pla_fuente.nombre as fuente', 'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
            'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
            'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_consumo_item', 'pla_poa1.id_consumo', '=', 'pla_consumo_item.id')

        ->where('pla_poa1.id',"=", $id_poa)
        ->whereIn('pla_poa1.estado', ['A','R','O','C'])
        ->groupBy('id', 'pla_poa1.departamento', 'pla_poa1.nro_poa', 'pla_poa1.created_at', 'pla_poa1.updated_at',
        'pla_poa1.fecha', 'pla_poa1.id_tipo_poa', 'pla_calendario.justificacion_area', 'pla_poa1.plurianual',
        'pla_obj_operativo.nombre', 'pla_actividad_operativa.nombre', 'pla_sub_actividad.nombre', 'pla_poa1.monto',
        'pla_poa1.id_tipo_monto', 'pla_calendario.justificacion_area', 'pla_unidad_ejecutora.nombre',
        'pla_programa.nombre', 'pla_proyecto.nombre', 'pla_actividad_act.nombre', 'pla_fuente.nombre',
        'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo',
        'pla_calendario.abril', 'pla_calendario.mayo', 'pla_calendario.junio',
        'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre',
        'pla_calendario.octubre', 'pla_calendario.noviembre', 'pla_calendario.diciembre',
        'pla_poa1.id_item', 'pla_item_presupuestario.nombre', 'pla_item_presupuestario.descripcion',
        'pla_item_presupuestario.monto')
        ->first();

        $comentarios = Comentario::select('pla_comentario.comentario', 'pla_comentario.id_poa',
        'pla_comentario.created_at', 'pla_comentario.estado_planificacion as estado_planificacion')
        ->where('id_poa', $id_poa)
        ->where('estado_planificacion', 'Aprobado')
        ->orderBy('created_at', 'desc')
        ->first();

        $pdf = \PDF::loadView('pdf.pdfPOA', ['usuarios' => $usuarios, 'atributos' => $atributos,'comentarios'=>$comentarios])->setPaper('A3', 'landscape');
        $pdfFileName = 'pdf_' . time() . '.pdf';
        $pdf->save(public_path("pdf/{$pdfFileName}"));
        $pdfUrl = asset("pdf/{$pdfFileName}");

        //return response()->json(['pdf_url' => $atributos]);
        return $pdf->download('reporte_poa.pdf');
    }

    /* GENERAR PDF  */
    //========================================Aquí inicia REFORMA===============================================


    public function reformaIndex(Request $request){ // VISTA DEL USUARIO AL CREAR REFORMA

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
        }

        if(request()->ajax()) {

            return datatables()->of(Reforma::select('pla_reforma.nro_solicitud as nro_solicitud', 'pla_direcciones.nombre as area', 'pla_reforma.justificacion as justificacion',
                DB::raw('DATE_FORMAT(pla_reforma.created_at, "%Y-%m-%d") as fecha'),
                'pla_reforma.id as id_reforma', 'pla_reforma.estado as estado')
                ->join('pla_direcciones', 'pla_reforma.area_id', '=', 'pla_direcciones.id')
                ->where('pla_reforma.area_id', '=', $id_direccion)
                ->whereNotIn('pla_reforma.estado', ['E'])
                ->get()
        )
                ->addIndexColumn()
                ->make(true);
        }

        //Aquí comienza lo que creo que es nececesario para el pdf de la reforma
        $tipo_Poa = TipoPoa::where('estado', 'A')->get();
        $obj_Operativo = ObjetivoOperativo::where('estado', 'A')->get();
        $act_Operativa = ActividadOperativa::where('estado', 'A')->get();
        $sub_Act = SubActividad::where('estado', 'A')->get();
        $usuarios = User::where('status', '=', 'A')->get();

        //$area = Area::select('nombre')->where('estado', '=', 'A')->where('id', '=', $id_area)->first();

        return view('planificacion.index_reforma', compact('usuarios'));
    }



    public function reformaPrincipal(Request $request){

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;

        if(request()->ajax()) {

            return datatables()->of(Reforma::select('pla_reforma.nro_solicitud as nro_solicitud', 'area.nombre as area', 'pla_reforma.justificacion as justificacion',
                DB::raw('DATE_FORMAT(pla_reforma.created_at, "%Y-%m-%d") as fecha'),
                'pla_reforma.id as id_reforma', 'pla_reforma.estado as estado')
                ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_reforma.area_id')
                // ->where('pla_poa1.id_area', '=', $id_area)
                ->whereNotIn('pla_reforma.estado', ['E']))
                ->addIndexColumn()
                ->make(true);
        }

        return view('planificacion.index_reforma_principal');
    }

    //===============================================================================================

    public function crearReforma(Request $request){

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
            $nombre       = $direccion->nombre;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
            $nombre       = $direccion->nombre;
        }

        //$anio = date('Y');

        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero',
            DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_poa1.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa', 'pla_poa1.id_area as id_areaS',
            'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual','pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.id_tipo_monto as idTipoMonto',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
            'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
            'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem', 'pla_calendario.total')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_poa1.id_area', '=', $id_direccion)
            //->where('pla_poa1.año', '=', $anio)
            ->whereNotIn('pla_poa1.estado', ['E'])
            ->get();

        $tipo_Poa      = TipoPoa::where('estado', 'A')->get();
        $obj_Operativo = ObjetivoOperativo::where('estado', 'A')->where('id_area', $id_direccion)->get();
      
        $usuarios      = User::where('status', '=', 'A')->get();
        $tipos         = TipoPoa::select('id', 'nombre')->where('estado', 'A')->get();
        $direcciones   = MontoDireccion::select('*')->whereIn('estado', ['A'])->get();

        //$item_presupuestario = ItemPresupuestario::where('estado', 'A')->get();
        $item_presupuestario = ItemPresupuestario::select('itemdir.id_item as id_item', 'itemdir.id as id', 'pla_item_presupuestario.nombre', 
            'pla_item_presupuestario.descripcion', 'itemdir.monto')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('itemdir.estado', 'A')
            ->where('itemdir.id_direcciones', $id_direccion)->get();


        $proceso = TipoProceso::select('id', 'nombre')->where('estado', 'A')->get();

        //respuesta para la vista
        return view('planificacion.crear_reforma', compact('tipo_Poa','obj_Operativo', 'nombre', 'proceso'
        ,'usuarios','atributos', 'tipos', 'item_presupuestario', 'id_fuente', 'direcciones'));
    }



    public function getAreas($czonal_id){
        // Obtener áreas asociadas con el czonal_id
        $areas = Area::where('czonal_id', $czonal_id)->get();

        // Devolver las áreas en formato JSON
        return response()->json($areas);
    }



    public function TblActArea(Request $request){

        $anio = date('Y');

        $area_id = $request->input('id'); // Obtener el id del área de la solicitud}
        $id_poa  = $request->input('id_poa'); //Obtener el id de la actividad (POA) de la solicitud

        if(isset($id_poa)){

            $atributostblArea = DB::table('db_inspi_planificacion.pla_poa1')
                ->select('pla_poa1.id as id', 'pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero',
                DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d") as fecha_sol'),
                DB::raw('DATE_FORMAT(pla_poa1.updated_at, "%Y-%m-%d") as fecha_apr'),
                'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa', 'pla_poa1.id_area as id_areaS',
                'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual',
                'pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
                'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.id_tipo_monto as idTipoMonto',
                'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
                'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
                'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_calendario.total' ,'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
                'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            //->where('pla_poa1.id_area', '=', $area_id)
            ->where('pla_poa1.id', '=', $id_poa)
            ->where('pla_poa1.año', '=', $anio)
            ->whereIn('pla_poa1.estado', '!=', ['E'])
            ->first();

            //$atributostblArea = 'funciona';

        }else{

            $atributostblArea = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id', 'pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero',
                DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d") as fecha_sol'),
                DB::raw('DATE_FORMAT(pla_poa1.updated_at, "%Y-%m-%d") as fecha_apr'),
                'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa', 'pla_poa1.id_area as id_areaS',
                'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual',
                'pla_obj_operativo.nombre as nombreObjOperativo', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
                'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.id_tipo_monto as idTipoMonto',
                'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
                'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
                'pla_calendario.noviembre', 'pla_calendario.diciembre','pla_calendario.total', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
                'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_poa1.id_area', '=', $area_id)
            ->where('pla_poa1.año', '=', $anio)
            ->whereIn('pla_poa1.estado', ['O'])
            ->get();

        }

        // Aquí debes ajustar la consulta para obtener los datos según el área seleccionada

        return response()->json($atributostblArea);
    }






    public function saveReforma(Request $request){
        $data = $request->validate([
            'formData'      => 'required|array', // Validar que 'datos' sea un array requerido
            'justificacion' => 'required|string', // Validar que 'justificacion' sea una cadena requerida
            'justifi'       => 'required|string' // Validar que 'justificacion del área requirente' sea una cadena requerida
        ]);

        $formData      = $request->input('formData');
        $justificacion = $data['justificacion']; // Obtener la justificación del formulario
        $justifi       = $data['justifi']; // Obtener la justificación del área requirente del formulario

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
            $nombre       = $direccion->nombre;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
            $nombre       = $direccion->nombre;
        }

        $fecha = date('Y-m-d H:i:s');

        try {
            // Calcular el siguiente número de solicitud
            $ultimoNroSolicitud = Reforma::max('nro_solicitud');
            $nro_solicitud = $ultimoNroSolicitud ? $ultimoNroSolicitud + 1 : 1;

            $reforma = new Reforma();
            $reforma->nro_solicitud = $nro_solicitud;
            $reforma->justificacion = $justificacion;
            $reforma->justificacion_area = $justifi;
            $reforma->area_id       = $id_direccion;
            $reforma->estado        = 'A';
            $reforma->save();

            $id_reforma = $reforma->id;

            // Iterar sobre los datos recibidos para guardar cada fila en la base de datos
            foreach ($formData as $datos) {

                $id_poa = $datos['id_poa']; // Obtener el id_poa de la fila actual

                //crear actividad
                $act                = new Actividad;
                $act->id_poa1       = $id_poa;
                $act->id_reforma    = $id_reforma;
                $act->estado        = $datos['estado'];
                $act->sub_actividad = $datos['subActividad'];
                $act->save();

                $id_actividad = $act->id;


                $calendario = new CalendarioReforma([
                    'id_poa'       => $id_poa,
                    'id_actividad' => $id_actividad ,
                    'tipo'         => $datos['tipo'],
                    'enero'        => $datos['enero'],
                    'febrero'      => $datos['febrero'],
                    'marzo'        => $datos['marzo'],
                    'abril'        => $datos['abril'],
                    'mayo'         => $datos['mayo'],
                    'junio'        => $datos['junio'],
                    'julio'        => $datos['julio'],
                    'agosto'       => $datos['agosto'],
                    'septiembre'   => $datos['septiembre'],
                    'octubre'      => $datos['octubre'],
                    'noviembre'    => $datos['noviembre'],
                    'diciembre'    => $datos['diciembre'],
                    'total'        => $datos['total'],
                    'estado'       => $datos['estado'],
                    // 'estado' => 'A', // Suponiendo que 'A' es para estado activo
                ]);

                // Guardar el calendario de reforma
                $calendario->save();

                $poa = Poa::find($act->id_poa1);
                if ($poa && $poa->monto == 0) {
                    $poa->monto = $datos['total'];
                    $poa->save();
                }

                //si la actividad es prestada, se crea una solicitud
                if($datos['solicitud'] == 'false'){

                    $sol = new Solicitud;
                    $sol->id_actividad        = $id_poa;
                    $sol->id_area_solicitante = $id_direccion;
                    $sol->id_area_propietaria = $datos['id_area_soli'];
                    $sol->estado_solicitud    = 'pendiente';
                    $sol->fecha_solicitud     = $fecha;
                    $sol->save();

                }

            }

            // Agregar comentario a la tabla pla_comentarios_reforma
            $comentario = new ComentarioReforma();
            $comentario->id_reforma = $id_reforma;
            $comentario->id_usuario = Auth::id();
            $comentario->comentario = $justificacion;
            $comentario->estado_planificacion = 'Ingresado'; // Estado inicial para una nueva reforma
            $comentario->save();

            // Retornar una respuesta de éxito
            return response()->json(['message' => 'Reforma guardada correctamente', 'success' => true], 200);
        } catch (\Exception $e) {
            // En caso de error, retornar un mensaje de error
            return response()->json(['message' => 'Error al guardar la reforma. '.$e->getMessage(), 'success' => false], 500);
        }
    }




    public function crearReformaConActividades(Request $request) //CREAR NUEVA ACTIVIDAD EN LA VENTANA DE NUEVA REFORMA
    {
        try {

            $id_usuario = Auth::user()->id;
            $filiacion  = Filiacion::with('area')->where('user_id', $id_usuario)->first();
            $id_area    = $filiacion->area_id;
            $direccion_id = $filiacion->direccion_id;
    
            if($id_area == 7){
                $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir_tec', $direccion_id)->first();
                $id_direccion = $direccion->id;
                $id_fuente    = $direccion->id_fuente;
                $nombre       = $direccion->nombre;
            }else{
                $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir', $id_area)->first();
                $id_direccion = $direccion->id;
                $id_fuente    = $direccion->id_fuente;
                $nombre       = $direccion->nombre;
            }

            $obOpera = $request->input('obOpera');

            /*
            // Crear objetivo operativo
            $op = new ObjetivoOperativo;
            $op->id_area = $id_area;
            $op->nombre  = $request->obOpera;
            $op->estado  = 'A';
            $op->save();
            */

            // Crear actividad operativa
            $actop = new ActividadOperativa;
            $actop->id_area = $id_direccion;
            $actop->nombre  = $request->actOpera;
            $actop->estado  = 'A';
            $actop->save();

            // Crear subactividad
            $sub = new SubActividad;
            $sub->id_area = $id_direccion;
            $sub->nombre  = $request->subActi;
            $sub->save();

            // Crear POA
            $poa = new Poa();
            $poa->departamento  = $request->coordina;
            $poa->id_area       = $id_direccion;
            $poa->id_usuario    = $id_usuario;
            $poa->id_obj_operativo = $obOpera;
            $poa->id_actividad  = $actop->id;
            $poa->id_sub_actividad = $sub->id;
            $poa->id_tipo_monto = '1';
            $poa->id_tipo_poa   = $request->poa;
            $poa->u_ejecutora   = $request->input('unidad_ejecutora');
            $poa->programa      = $request->input('programa');
            $poa->proyecto      = $request->input('proyecto');
            $poa->actividad     = $request->input('actividad');
            $poa->fuente        = $request->input('fuente_financiamiento');
            $poa->id_item       = $request->item_presupuestario;
            $poa->fecha         = $request->fecha;
            $poa->año           = date('Y', strtotime($request->fecha));
            $poa->plurianual    = $request->plurianual ? 1 : 0;
            $poa->monto         = $request->total;
            $poa->id_proceso    = $request->input('proceso');
            $poa->id_item_dir   = $request->input('id_item_dir');

            $poa->estado = 'A';
            $poa->save();

            // Crear Calendario normal
            $calendario = new Calendario();
            $calendario->id_poa     = $poa->id;
            $calendario->enero      = 0;
            $calendario->febrero    = 0;
            $calendario->marzo      = 0;
            $calendario->abril      = 0;
            $calendario->mayo       = 0;
            $calendario->junio      = 0;
            $calendario->julio      = 0;
            $calendario->agosto     = 0;
            $calendario->septiembre = 0;
            $calendario->octubre    = 0;
            $calendario->noviembre  = 0;
            $calendario->diciembre  = 0;
            $calendario->total      = 0;
            // $calendario->justificacion_area = $request->input('justifi2');
            // $calendario->estado = 'N';
            $calendario->save();

            $comentario = new Comentario();
            $comentario->id_poa     = $poa->id;
            $comentario->id_usuario = Auth::id();
            $comentario->comentario = 'Nueva actividad creada en reforma';
            $comentario->estado_planificacion = 'Ingresado'; // Estado inicial para una nueva reforma
            $comentario->save();


            $item = ItemPresupuestario::find($request->item_presupuestario);

            // DB::commit();

            // return response()->json(['success' => true, 'message' => 'Actividad creada con éxito']);
            return response()->json([
                'success' => true,
                'poa' => [
                    'id' => $poa->id,
                    'nombreActividadOperativa' => $actop->nombre,
                    'nombreSubActividad'       => $sub->nombre,
                    'nombreItem'               => $item->nombre,
                    'descripcionItem'          => $item->descripcion,
                    'id_area'                  => $id_direccion,
                ]
            ]);
        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al crear la actividad: ' . $e->getMessage()], 500);
        }
    }


    public function reformaActArea(Request $request){

        $czonal = Czonal::select('*')->whereIn('estado', ['A'])->get();

        //respuesta para la vista
        return view('planificacion.reformaActArea', compact('czonal','area'));


    }


    public function cargarArea(Request $request){
        $area = Area::select('*')->whereIn('estado', ['A'])->get();

        return $area;
    }

    public function crearActArea(Request $request){

        // Valida los datos entrantes (opcional, pero recomendado)
        $datos = $request->validate([
            'id_poa'     => 'required|integer',
            'id_reforma' => 'required|integer',
        ]);

        $id_poa     = $datos['id_poa']; // Obtener el id_poa de la fila actual
        $id_reforma = $datos['id_reforma'];

        $sub_Actividad = DB::table('db_inspi_planificacion.pla_poa1')
        ->select('inspi_sub_actividad.nombre as nombreSubActividad')
        ->join('db_inspi.inspi_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'inspi_sub_actividad.id')
        ->where('pla_poa1.id','=',$id_poa)
        ->first();

        // Crear Actividad de Reforma
        $actividad = new Actividad();
        $actividad->id_reforma = $request->id_reforma;
        $actividad->id_poa1    = $id_poa;
        $actividad->estado     = 'A';
        $actividad->sub_actividad = $sub_Actividad-> nombreSubActividad;
        $actividad->save();

        // Crear Calendario de Reforma
        $calendario = new CalendarioReforma();
        $calendario->id_actividad = $actividad->id;
        $calendario->id_poa     = $id_poa;
        $calendario->tipo       = 'AUMENTA';
        $calendario->enero      = 0;
        $calendario->febrero    = 0;
        $calendario->marzo      = 0;
        $calendario->abril      = 0;
        $calendario->mayo       = 0;
        $calendario->junio      = 0;
        $calendario->julio      = 0;
        $calendario->agosto     = 0;
        $calendario->septiembre = 0;
        $calendario->octubre    = 0;
        $calendario->noviembre  = 0;
        $calendario->diciembre  = 0;
        $calendario->total      = 0;
        // $calendario->estado = 'A';
        $calendario->save();

        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id', 'inspi_actividad_operativa.nombre as nombreActividadOperativa',
            'inspi_sub_actividad.nombre as nombreSubActividad', 'inspi_item_presupuestario.nombre as nombreItem',
            'inspi_item_presupuestario.descripcion as descripcionItem','pla_poa1.id_area as id_areaS',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 
            'pla_calendario.mayo', 'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 
            'pla_calendario.septiembre', 'pla_calendario.octubre', 'pla_calendario.noviembre', 'pla_calendario.diciembre',
            'pla_calendario.total'
            )
            ->join('db_inspi.inspi_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'inspi_obj_operativo.id')
            ->join('db_inspi.inspi_actividad_operativa', 'pla_poa1.id_actividad', '=', 'inspi_actividad_operativa.id')
            ->join('db_inspi.inspi_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'inspi_sub_actividad.id')
            ->join('db_inspi.inspi_item_presupuestario', 'pla_poa1.id_item', '=', 'inspi_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')

            ->where('pla_poa1.id','=',$id_poa)
            ->first();
 

        // (Opcional) Puedes retornar una respuesta o hacer algo más con el objeto Poa
        return response()->json([
            'success' => true,
            'actividadPoa' => [
                'id' => $actividad->id,
                'nombreActividadOperativa' => $atributos -> nombreActividadOperativa,
                'nombreSubActividad'       => $atributos -> nombreSubActividad,
                'nombreItem'      => $atributos -> nombreItem,
                'descripcionItem' => $atributos -> descripcionItem,
                'id_areaS'   => $atributos -> id_areaS,
                'enero'      => $atributos -> enero,
                'febrero'    => $atributos -> febrero,
                'marzo'      => $atributos -> marzo,
                'abril'      => $atributos -> abril,
                'mayo'       => $atributos -> mayo,
                'junio'      => $atributos -> junio,
                'julio'      => $atributos -> julio,
                'agosto'     => $atributos -> agosto,
                'septiembre' => $atributos -> septiembre,
                'octubre'    => $atributos -> octubre,
                'noviembre'  => $atributos -> noviembre,
                'diciembre'  => $atributos -> diciembre,
                'total'      => $atributos -> total,

            ]
        ]);

    }

    //===============================================================================================


    public function editarReforma(Request $request, $id){

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
            $nombre       = $direccion->nombre;
        }else{
            $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $id_fuente    = $direccion->id_fuente;
            $nombre       = $direccion->nombre;
        }

        $anio = date('Y');

        $reforma = Reforma::find($id);
        $justificacion_area = $reforma->justificacion_area;

        $atributos = DB::table('db_inspi_planificacion.pla_actividad')
            ->select('pla_actividad.id as id_actividad',
            'pla_poa1.id as id_poa' ,'pla_poa1.id_area as id_areaS', 'pla_poa1.departamento as departamento', //DATA PARA LLENAR ACTIVIDAD DE OTRA ÁREA
            'pla_actividad_operativa.nombre as nombreActividadOperativa', 'pla_sub_actividad.nombre as nombreSubActividad',
            'pla_item_presupuestario.nombre as nombreItem', 'pla_item_presupuestario.descripcion as descripcionItem',

            DB::raw('DATE_FORMAT(pla_actividad.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_actividad.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_actividad.created_at as fecha', 'pla_calendario_ref.tipo',
            'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_calendario_ref.marzo', 
            //CALENDARIO REFORMA
            'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio', 'pla_calendario_ref.julio', 'pla_calendario_ref.agosto',
            'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre', 'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre',
            'pla_calendario_ref.total',
            //CALENDARIO POA
            // 'pla_calendario.enero as calEnero', 'pla_calendario.febrero as calFebrero', 'pla_calendario.marzo as calMarzo', 
            // 'pla_calendario.abril as calAbril', 'pla_calendario.mayo as calMayo', 'pla_calendario.junio as calJunio', 
            // 'pla_calendario.julio as calJulio', 'pla_calendario.agosto as calAgosto', 'pla_calendario.septiembre as calSeptiembre', 
            // 'pla_calendario.octubre as calOctubre', 'pla_calendario.noviembre as calNoviembre', 'pla_calendario.diciembre as calDiciembre',
            // 'pla_calendario.total as calTotal',
            //Item presupuestario
            'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem',
            'pla_reforma.justificacion as justificacion_reforma')
            ->join('db_inspi_planificacion.pla_reforma', 'pla_actividad.id_reforma', '=', 'pla_reforma.id')
            // ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
            ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_reforma.id', '=', $id)
            ->where('pla_poa1.año', '=', $anio)
            ->where('pla_actividad.estado', 'A')
        ->get();       

        $tipo_Poa      = TipoPoa::where('estado', 'A')->get();
        $obj_Operativo = ObjetivoOperativo::where('estado', 'A')->where('id_area', $id_direccion)->get();
        $usuarios      = User::where('status', '=', 'A')->get();

        $tipos         = TipoPoa::select('id', 'nombre')->where('estado', 'A')->get();
        //$czonal        = Czonal::select('*')->whereIn('estado', ['A'])->get();

        //$item_presupuestario = ItemPresupuestario::where('estado', 'A')->get();
        $item_presupuestario = ItemPresupuestario::select('itemdir.id_item as id_item', 'itemdir.id as id', 'pla_item_presupuestario.nombre', 
            'pla_item_presupuestario.descripcion', 'itemdir.monto')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('itemdir.estado', 'A')
            ->where('itemdir.id_direcciones', $id_direccion)->get();

        $proceso = TipoProceso::select('id', 'nombre')->where('estado', 'A')->get();

        $comentarios = ComentarioReforma::select('users.name as id_usuario', 'pla_comentario_reforma.comentario', 'pla_comentario_reforma.id_reforma', 'pla_comentario_reforma.created_at',
            'pla_comentario_reforma.estado_planificacion as estado_planificacion')
            ->where('id_reforma', $id)
            ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario_reforma.id_usuario')
            // ->where('id_usuario', $id_usuario)
            ->orderBy('created_at', 'asc')
            // ->where()
            ->get();

        //respuesta para la vista
        return view('planificacion.editar_reforma', compact('tipo_Poa','obj_Operativo', 'id_fuente', 'proceso'
            ,'usuarios','atributos', 'id', 'item_presupuestario', 'tipos', 'nombre', 'justificacion_area'
            , 'comentarios'));
    }



    public function actualizarReforma(Request $request, $id){
        $data = $request->validate([
            'formData'      => 'required|array',
            'justificacion' => 'required|string',
            'justifi'       => 'required|string'
        ]);

        $formData      = $request->input('formData');
        $justificacion = $data['justificacion'];
        $justifi       = $data['justifi']; 


        try {
            // DB::beginTransaction();

            // Actualizar la reforma principal
            $reforma = Reforma::findOrFail($id);
            $reforma->justificacion      = $justificacion;
            $reforma->justificacion_area = $justifi;


            if ($reforma->estado === 'R') {
                // Cambiar el estado a "Corregido"
                $reforma->estado = 'C';
            }
            $reforma->save();

            // Actualizar o crear actividades y calendario de reforma
            foreach ($formData as $datos) {

                $actividad = Actividad::where('id_reforma', $id)
                                    ->where('id', $datos['id_actividad'])
                                    ->first();

                // if (!$actividad) {
                //     $actividad = new Actividad();
                //     $actividad->id_reforma = $id;
                //     $actividad->id_poa1 = $datos['id_poa'];
                // }
                $actividad->sub_actividad = $datos['subActividad'];
                $actividad->estado        = $datos['estado'];
                $actividad->save();

                $calendario = CalendarioReforma::updateOrCreate(
                    ['id_actividad'  => $actividad->id],
                    [
                        'tipo'       => $datos['tipo'],
                        'enero'      => $datos['enero'],
                        'febrero'    => $datos['febrero'],
                        'marzo'      => $datos['marzo'],
                        'abril'      => $datos['abril'],
                        'mayo'       => $datos['mayo'],
                        'junio'      => $datos['junio'],
                        'julio'      => $datos['julio'],
                        'agosto'     => $datos['agosto'],
                        'septiembre' => $datos['septiembre'],
                        'octubre'    => $datos['octubre'],
                        'noviembre'  => $datos['noviembre'],
                        'diciembre'  => $datos['diciembre'],
                        'total'      => $datos['total'],
                        'estado'     => $datos['estado'],
                    ]
                );

                $calendarioNormal = Calendario::where('id_poa', $actividad->id_poa1)->first();

                if ($calendarioNormal && $calendarioNormal->created_at->gte($reforma->created_at)) {
                    // Esta actividad fue creada después de la reforma, actualizamos el calendario normal
                    // solo si todos los valores son cero
                    if ($calendarioNormal->enero == 0      && $calendarioNormal->febrero == 0 &&
                        $calendarioNormal->marzo == 0      && $calendarioNormal->abril == 0 &&
                        $calendarioNormal->mayo == 0       && $calendarioNormal->junio == 0 &&
                        $calendarioNormal->julio == 0      && $calendarioNormal->agosto == 0 &&
                        $calendarioNormal->septiembre == 0 && $calendarioNormal->octubre == 0 &&
                        $calendarioNormal->noviembre == 0  && $calendarioNormal->diciembre == 0) {

                        $calendarioNormal->update([
                            'enero'      => $datos['enero'],
                            'febrero'    => $datos['febrero'],
                            'marzo'      => $datos['marzo'],
                            'abril'      => $datos['abril'],
                            'mayo'       => $datos['mayo'],
                            'junio'      => $datos['junio'],
                            'julio'      => $datos['julio'],
                            'agosto'     => $datos['agosto'],
                            'septiembre' => $datos['septiembre'],
                            'octubre'    => $datos['octubre'],
                            'noviembre'  => $datos['noviembre'],
                            'diciembre'  => $datos['diciembre'],
                            'total'      => $datos['total'],
                        ]);
                    }
                }

            $poa = Poa::find($actividad->id_poa1);
            if ($poa && $poa->monto == 0) {
                $poa->monto = $datos['total'];
                $poa->save();
            }
        }

        //Agregando comentarios a la tabla de pla_comentarios_reforma
        $id_reforma = $id;
        $comentarioRetro = $request->input('justificacion');
        $id_usuario = Auth::user()->id;

        // Verificar si hay comentarios previos para este id_poa
        $comentarioExistente = ComentarioReforma::where('id_reforma', $id_reforma)->exists();

        // Obtener el estado anterior si hay comentarios previos
        if ($comentarioExistente) {
            $ultimoComentario = ComentarioReforma::where('id_reforma', $id_reforma)->orderBy('created_at', 'desc')->first();
            $estadoAnterior = $ultimoComentario->estado_planificacion;
        } else {
            $estadoAnterior = 'Ingresado'; // Estado por defecto si no hay comentarios previos
        }

        // Verificar si el estado de $poa es "Rechazado" y ha sido editado
        if ($reforma->estado === 'C') {
            $estadoAnterior = 'Corregido'; // Cambiar el estado a "Editado" en el comentario
        }


        // Crear datos del comentario
        $datosComentario = [
            'id_reforma' => $id_reforma,
            'id_usuario' => $id_usuario,
            'comentario' => $comentarioRetro,
            'estado_planificacion' => $estadoAnterior, // Asignar el estado determinado
        ];

        $comentario = ComentarioReforma::create($datosComentario);

            // DB::commit();

            return response()->json(['message' => 'Reforma actualizada correctamente', 'success' => true], 200);
        } catch (\Exception $e) {

            // DB::rollBack();
            return response()->json(['message' => 'Error al actualizar la reforma: '.$e->getMessage(), 'success' => false], 500);

        }
    }

    public function guardarNuevaActividad(Request $request) //CREAR NUEVA ACTIVIDAD EN LA VENTANA DE EDITAR
    {
        try {

            $id_usuario = Auth::user()->id;
            $filiacion  = Filiacion::with('area')->where('user_id', $id_usuario)->first();
            $id_area    = $filiacion->area_id;
            $direccion_id = $filiacion->direccion_id;
    
            if($id_area == 7){
                $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir_tec', $direccion_id)->first();
                $id_direccion = $direccion->id;
                $id_fuente    = $direccion->id_fuente;
                $nombre       = $direccion->nombre;
            }else{
                $direccion    = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir', $id_area)->first();
                $id_direccion = $direccion->id;
                $id_fuente    = $direccion->id_fuente;
                $nombre       = $direccion->nombre;
            }


            $id_obj_operativo        = $request->input('obOpera');

            $actividadOperativa = ActividadOperativa::firstOrCreate(
                ['nombre' => $request->actOpera],
                [
                    'id_area' => $id_direccion,
                    'estado'  => 'A',
                ]
            );
            $id_actividad = $actividadOperativa->id;
            $nombreActividadOperativa = $actividadOperativa->nombre;

            // Subactividad
            $subActividad = SubActividad::firstOrCreate(
                ['nombre'  => $request->subActi],
                ['id_area' => $id_direccion]
            );
            $id_sub_actividad   = $subActividad->id;
            $nombreSubActividad = $subActividad->nombre;

            // Crear POA
            $poa = new Poa();
            $poa->departamento     = $request->coordina;
            $poa->id_area          = $id_direccion;
            $poa->id_usuario       = $id_usuario;
            $poa->id_obj_operativo = $id_obj_operativo;
            $poa->id_actividad     = $id_actividad;
            $poa->id_sub_actividad = $id_sub_actividad;
            $poa->id_tipo_poa      = $request->poa;
            $poa->id_tipo_monto    = '1';
            $poa->u_ejecutora      = $request->input('unidad_ejecutora');
            $poa->programa         = $request->input('programa');
            $poa->proyecto         = $request->input('proyecto');
            $poa->actividad        = $request->input('actividad');
            $poa->fuente           = $request->input('fuente_financiamiento');
            $poa->id_item          = $request->item_presupuestario;
            $poa->fecha            = $request->fecha;
            $poa->año              = date('Y', strtotime($request->fecha));
            $poa->plurianual       = $request->plurianual ? 1 : 0;
            $poa->id_proceso       = $request->input('proceso');
            $poa->id_item_dir      = $request->input('id_item_dir');
            $poa->estado           = 'A';
            $poa->save();

            // Crear Actividad de Reforma
            $actividad = new Actividad();
            $actividad->id_reforma = $request->id_reforma;
            $actividad->id_poa1    = $poa->id;
            $actividad->estado     = 'A';
            $actividad->save();

            // Crear Calendario de Reforma
            $calendario = new CalendarioReforma();
            $calendario->id_actividad = $actividad->id;
            $calendario->id_poa       = $poa->id;
            $calendario->tipo         = 'AUMENTA';
            $calendario->enero        = 0;
            $calendario->febrero      = 0;
            $calendario->marzo        = 0;
            $calendario->abril        = 0;
            $calendario->mayo         = 0;
            $calendario->junio        = 0;
            $calendario->julio        = 0;
            $calendario->agosto       = 0;
            $calendario->septiembre   = 0;
            $calendario->octubre      = 0;
            $calendario->noviembre    = 0;
            $calendario->diciembre    = 0;
            $calendario->total        = 0;
            // $calendario->estado = 'A';
            $calendario->save();

            // Crear Calendario normal
            $calendario = new Calendario();
            $calendario->id_poa     = $poa->id;
            $calendario->enero      = 0;
            $calendario->febrero    = 0;
            $calendario->marzo      = 0;
            $calendario->abril      = 0;
            $calendario->mayo       = 0;
            $calendario->junio      = 0;
            $calendario->julio      = 0;
            $calendario->agosto     = 0;
            $calendario->septiembre = 0;
            $calendario->octubre    = 0;
            $calendario->noviembre  = 0;
            $calendario->diciembre  = 0;
            $calendario->total      = 0;
            $calendario->justificacion_area = $request->input('justifi2');
            // $calendario->estado = 'N';
            $calendario->save();

            $item = ItemPresupuestario::find($request->item_presupuestario);

            return response()->json([
                'success' => true,
                'actividad' => [
                    'id'                       => $actividad->id,
                    'nombreActividadOperativa' => $nombreActividadOperativa,
                    'nombreSubActividad'       => $nombreSubActividad,
                    'nombreItem'               => $item->nombre,
                    'descripcionItem'          => $item->descripcion,
                ]
            ]);
        } catch (\Exception $e) {
                \Log::error('Error al guardar nueva actividad: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Error al guardar la actividad: ' . $e->getMessage()], 500);
        }
    }

//===========================================REVISIÓN REFORMA================================================

    public function revisionReforma(Request $request, $id){

        $atributos = DB::table('db_inspi_planificacion.pla_actividad')
            ->select('pla_actividad.id as id_actividad',
            DB::raw('DATE_FORMAT(pla_actividad.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_actividad.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_actividad.created_at as fecha', 'pla_actividad_operativa.nombre as nombreActividadOperativa', 'pla_calendario_ref.tipo',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_calendario_ref.marzo',
            'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio', 'pla_calendario_ref.julio', 'pla_calendario_ref.agosto',
            'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre', 'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre',
            'pla_calendario_ref.total', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem',
            'pla_reforma.justificacion as justificacion_reforma')
            ->join('db_inspi_planificacion.pla_reforma', 'pla_actividad.id_reforma', '=', 'pla_reforma.id')
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
            ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_reforma.id', '=', $id)
            ->where('pla_actividad.estado', 'A')
            ->get();

        $comentarios = ComentarioReforma::select('users.name as id_usuario', 'pla_comentario_reforma.comentario', 'pla_comentario_reforma.id_reforma', 'pla_comentario_reforma.created_at',
            'pla_comentario_reforma.estado_planificacion as estado_planificacion')
            ->where('id_reforma', $id)
            ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario_reforma.id_usuario')
            ->orderBy('created_at', 'asc')
            ->get();

        $justifi = Reforma::find($id);

        //respuesta para la vista
        return view('planificacion.revision_reforma', compact('atributos', 'id', 'comentarios', 'justifi'));

    }



    public function agregarComentarioReforma(Request $request){
        $data = $request->validate([

            'id_reforma'            => 'required|string',
            'estadoReforma'         => 'required|string',
            'justificacion_Reforma' => 'required|string',
        ]);

        $id_reforma            = $request->input('id_reforma');
        $estadoReforma         = $request->input('estadoReforma');
        $justificacion_Reforma = $request->input('justificacion_Reforma');


        $estados = [
            'R' => 'Rechazado',
            'O' => 'Aprobado',
            'C' => 'Corregido',
        ];

        if (isset($estados[$estadoReforma])) {
            $estadoTexto = $estados[$estadoReforma];
        } else {
            $estadoTexto = 'Desconocido';
        }

        $id_usuario = Auth::user()->id;

        $datos = [
            'id_reforma' => $id_reforma,
            'id_usuario' => $id_usuario,
            'comentario' => $justificacion_Reforma,
            'estado_planificacion' => $estadoTexto
         ];
        $comentario = ComentarioReforma::create($datos);

        $reforma = Reforma::where('id', $id_reforma)->first();
        $reforma->update([
            'estado' => $estadoReforma,
        ]);


        if ($comentario) {
            return response()->json(['message' => 'La reforma se ha validado exitosamente', 'data' => true], 200);

        } else {
            return response()->json(['message' => 'Error al validar la reforma', 'data' => false], 500);
        }

    }



    public function actualizarCalendarioPoa(Request $request){
        // Validar los datos de entrada
        $data = $request->validate([
            'id_reforma'    => 'required|string',
            'estadoReforma' => 'required|string',
            'justificacion' => 'required|string',
        ]);

        $estadoReforma = $request->input('estadoReforma');
        $id_reforma    = $data['id_reforma'];
        $justificacion = $request->input('justificacion');

        $id_usuario = Auth::user()->id;

        // Verificar si el estado de la reforma es 'O'
        if ($estadoReforma == 'O') {
            // Obtener el ID de todas las actividades asociadas a la reforma
            $actividades = Actividad::select('pla_actividad.id_poa1','pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_actividad.sub_actividad',
                'pla_calendario_ref.marzo', 'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio',
                'pla_calendario_ref.julio', 'pla_calendario_ref.agosto', 'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre',
                'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre', 'pla_calendario_ref.total', 'pla_actividad.estado', 'pla_calendario_ref.tipo')
                ->join('db_inspi_planificacion.pla_calendario_ref as pla_calendario_ref', 'pla_calendario_ref.id_actividad', '=', 'pla_actividad.id')
                ->where('pla_actividad.id_reforma', $id_reforma)
                ->get();


            $actividadesVal = Actividad::select('pla_actividad.id_poa1', 'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_actividad.sub_actividad',
                'pla_calendario_ref.marzo', 'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio',
                'pla_calendario_ref.julio', 'pla_calendario_ref.agosto', 'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre',
                'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre', 'pla_calendario_ref.total', 'pla_actividad.estado', 'pla_calendario_ref.tipo')
                ->join('db_inspi_planificacion.pla_calendario_ref as pla_calendario_ref', 'pla_calendario_ref.id_actividad', '=', 'pla_actividad.id')
                ->where('pla_actividad.id_reforma', $id_reforma)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('pla_solicitud')
                          ->whereColumn('pla_solicitud.id_actividad', 'pla_actividad.id_poa1')
                          ->whereIn('pla_solicitud.estado_solicitud', ['pendiente', 'rechazado']);
                })
                ->get();

            if ($actividadesVal->isNotEmpty()) {
                return response()->json(['message' => 'No se puede validar la reforma porque una actividad no fue aprobada por el área requirente.', 'valor' => false], 200);
            }else{

                foreach ($actividades as $actividad) {
                    $id_poa = $actividad->id_poa1;  // Asumimos que id_poa1 es la relación con POA
                    $tipo   = $actividad->tipo;

                    // Obtener los registros de la tabla pla_calendario para este id_poa
                    $calendarioPoa = Calendario::where('id_poa', $id_poa)->first();
                    $poaActividad  = Poa::where('id', $id_poa)->first();
                    $comentarioPOA = Comentario::where('id', $id_poa)->first();
                    $subActividad  = SubActividad::where('id', $poaActividad->id_sub_actividad)->first();


                    if ($calendarioPoa) {

                        if($actividad->estado == 'E'){

                            $poaActividad->update([
                                'estado' => $actividad->estado,
                            ]);
                            $calendarioPoa->update([
                                'estado' => $actividad->estado,
                            ]);

                        }else{

                            //actualiza item y historial
                            $itemPre = ItemPresupuestario::find($poaActividad->id_item);
                            if ($itemPre) {

                                if($tipo == 'AUMENTA'){
                                    $tipo = 'I';
                                    $monto = $itemPre->monto + $actividad->total;

                                    // Actualizar el calendario con los datos de formData
                                    $calendarioPoa->update([
                                        'enero'      => $calendarioPoa->enero      + $actividad->enero,
                                        'febrero'    => $calendarioPoa->febrero    + $actividad->febrero,
                                        'marzo'      => $calendarioPoa->marzo      + $actividad->marzo,
                                        'abril'      => $calendarioPoa->abril      + $actividad->abril,
                                        'mayo'       => $calendarioPoa->mayo       + $actividad->mayo,
                                        'junio'      => $calendarioPoa->junio      + $actividad->junio,
                                        'julio'      => $calendarioPoa->julio      + $actividad->julio,
                                        'agosto'     => $calendarioPoa->agosto     + $actividad->agosto,
                                        'septiembre' => $calendarioPoa->septiembre + $actividad->septiembre,
                                        'octubre'    => $calendarioPoa->octubre    + $actividad->octubre,
                                        'noviembre'  => $calendarioPoa->noviembre  + $actividad->noviembre,
                                        'diciembre'  => $calendarioPoa->diciembre  + $actividad->diciembre,
                                        'total'      => $actividad->total,
                                    ]);

                                    $calendarioPoa->actualizaTotal();

                                }else{
                                    $tipo = 'E';
                                    $monto = $itemPre->monto - $actividad->total;

                                    // Actualizar el calendario con los datos de formData
                                    $calendarioPoa->update([
                                        'enero'      => $calendarioPoa->enero      - $actividad->enero,
                                        'febrero'    => $calendarioPoa->febrero    - $actividad->febrero,
                                        'marzo'      => $calendarioPoa->marzo      - $actividad->marzo,
                                        'abril'      => $calendarioPoa->abril      - $actividad->abril,
                                        'mayo'       => $calendarioPoa->mayo       - $actividad->mayo,
                                        'junio'      => $calendarioPoa->junio      - $actividad->junio,
                                        'julio'      => $calendarioPoa->julio      - $actividad->julio,
                                        'agosto'     => $calendarioPoa->agosto     - $actividad->agosto,
                                        'septiembre' => $calendarioPoa->septiembre - $actividad->septiembre,
                                        'octubre'    => $calendarioPoa->octubre    - $actividad->octubre,
                                        'noviembre'  => $calendarioPoa->noviembre  - $actividad->noviembre,
                                        'diciembre'  => $calendarioPoa->diciembre  - $actividad->diciembre,
                                        'total'      => $actividad->total,
                                    ]);

                                    $calendarioPoa->actualizaTotal();
                                }

                                $itemPre->monto = $monto;
                                $itemPre->save();

                                //actualizo los estados anteriores
                                ConsumoItem::actualizarEstadosPorIdItem($poaActividad->id_item);

                                $fecha = date('Y-m-d H:i:s');
                                $anio = date('Y');

                                // Crear un nuevo registro en ConsumoItem
                                ConsumoItem::create([
                                    'id_item'         => $itemPre->id,
                                    'id_actividad'    => $poaActividad->id,
                                    'monto_consumido' => $actividad->total,
                                    'monto'           => $monto,
                                    'fecha'           => $fecha,
                                    'anio'            => $anio,
                                    'tipo'            => $tipo,
                                ]);

                            }

                            // Si el estado es "O" (Aprobado), asignar el siguiente número de POA secuencial
                            $ultimoNroPoa = Poa::where('estado', 'O')->max('nro_poa');
                            $nuevoNroPoa = $ultimoNroPoa ? $ultimoNroPoa + 1 : 1;
                            $poaActividad->update([
                                'estado'  => 'O',
                                'monto'   => $actividad->total,
                                'nro_poa' => $nuevoNroPoa,
                            ]);

                            //actualiza la sup-actividad
                            $subActividad->update([
                                'nombre'  => $actividad->sub_actividad,
                            ]);

                            $datos = [
                                'id_poa'     => $id_poa,
                                'id_usuario' => $id_usuario,
                                'comentario' => $justificacion,
                                'estado_planificacion' => 'Validado',
                             ];
                            $comentario = Comentario::create($datos);

                        }

                    }
                }

                $reforma = Reforma::where('id', $id_reforma)->first();
                $reforma->update([
                    'estado' => 'V',
                ]);

                return response()->json(['message' => 'Calendario actualizado exitosamente', 'valor' => true], 200);

            }

        }else{
            return response()->json(['message' => 'El estado de la reformar no es el indicado para ser validada.', 'valor' => false], 500);
        }

    }


    /* TRAER COMENTARIO POR REFORMA */
    public function obtenerComentariosReforma($id)
    {
        // Busca el POA por su ID
        $reforma = Reforma::find($id);

        if (!$reforma) {
            return response()->json(['message' => 'Reforma no encontrada'], 404);
        }

        $comentariosRef = ComentarioReforma::select('users.name as id_usuario', 'pla_comentario_reforma.comentario', 'pla_comentario_reforma.estado_planificacion',
        DB::raw('DATE_FORMAT(pla_comentario_reforma.created_at, "%Y-%m-%d %H:%i:%s") as fecha'),
        'pla_comentario_reforma.id_reforma')
        ->where('id_reforma', $id)
        ->join('bdcoreinspi.users', 'users.id', '=', 'pla_comentario_reforma.id_usuario')
        // ->where('id_usuario', $id_usuario)
        ->orderBy('fecha', 'asc')
        // ->where()
        ->get();

        return response()->json(['reforma' => $reforma, 'comentariosRef' => $comentariosRef]);
    }
    /* TRAER COMENTARIO POR REFORMA */



    public function deleteReforma(Request $request)
    {
        $reforma = Reforma::find($request->id); //Busca el registro por el ID

        if ($reforma) {

            $reforma->update([
                'estado' => 'E', //Asigna el estado "E" para no mostrarlo en la tabla
            ]);

            return response()->json(['message' => 'Reforma eliminada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar la reforma', 'data' => false], 500);

        }
    }



    public function reportReforma(Request $request)
    {
        $id_reforma  = $request->query('id_reforma');

        $usuarios = [
            'creado'     => ['name' => $request->input('id_creado'),'cargo' => $request->input('cargo_creado')],
            'autorizado' => ['name' => $request->input('id_autorizado'),'cargo' => $request->input('cargo_autorizado')],
            'reporta'    => ['name' => $request->input('id_reporta'),'cargo' => $request->input('cargo_reporta')],
            'areaReq'    => ['name' => $request->input('id_areaReq'),'cargo' => $request->input('cargo_areaReq')],
            'planificacionYG' => ['name' => $request->input('id_planificacionYG'),'cargo' => $request->input('cargo_planificacionYG')],
        ];

        // Obtener el contenido del campo justifi desde la solicitud
        // $justifi = $request->input('justifi');
            // Actualizar la justificación en la tabla pla_calendario
        // $reforma = Reforma::where('id', $id_reforma)->first();
        // if ($reforma) {
        //     $reforma->justificacion = $justifi;
        //     $reforma->save();
        // }

        $atributos = DB::table('db_inspi_planificacion.pla_reforma')
        ->select('pla_reforma.id as id', 'pla_reforma.nro_solicitud as numero',
        DB::raw('DATE_FORMAT(pla_reforma.created_at, "%Y-%m-%d") as fecha_sol'),
        DB::raw('DATE_FORMAT(pla_reforma.updated_at, "%Y-%m-%d") as fecha_apr'),
        'pla_reforma.fecha as fecha', 'pla_reforma.justificacion as justificacion', 'pla_reforma.justificacion_area as justificacion_area',
        'pla_direcciones.nombre as area')
        ->join('db_inspi_planificacion.pla_direcciones', 'pla_reforma.area_id', '=', 'pla_direcciones.id')
        // ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
        // ->join('db_inspi.inspi_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'inspi_obj_operativo.id')
        // ->join('db_inspi.inspi_actividad_operativa', 'pla_poa1.id_actividad', '=', 'inspi_actividad_operativa.id')
        // ->join('db_inspi.inspi_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'inspi_sub_actividad.id')
        // ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
        // ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
        // ->join('db_inspi.inspi_item_presupuestario', 'pla_poa1.id_item', '=', 'inspi_item_presupuestario.id')
        ->where('pla_reforma.id',"=", $id_reforma)
        //->whereIn('pla_reforma.estado', ['O'])
        ->first();

        // Obtener todas las actividades relacionadas con esta reforma
        $actividades = DB::table('db_inspi_planificacion.pla_reforma')
        ->select(
            'pla_reforma.id as id', 'pla_actividad_operativa.nombre as actividad_operativa',
            'pla_sub_actividad.nombre as sub_actividad', 'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
            'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
            'pla_fuente.nombre as fuente', 'pla_calendario_ref.tipo as tipo', 'pla_calendario_ref.enero as enero', 'pla_calendario_ref.febrero as febrero', 'pla_calendario_ref.marzo as marzo', 'pla_calendario_ref.abril as abril',
            'pla_calendario_ref.mayo as mayo', 'pla_calendario_ref.junio as junio', 'pla_calendario_ref.julio as julio', 'pla_calendario_ref.agosto as agosto', 'pla_calendario_ref.septiembre as septiembre',
            'pla_calendario_ref.octubre as octubre', 'pla_calendario_ref.noviembre as noviembre', 'pla_calendario_ref.diciembre as diciembre', 'pla_calendario_ref.total as total')
        ->join('db_inspi_planificacion.pla_actividad', 'pla_reforma.id', '=', 'pla_actividad.id_reforma')
        ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
        ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
        ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
        ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
        ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
        ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
        ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
        ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
        ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
        ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
        ->where('pla_reforma.id', $id_reforma)
        ->whereIn('pla_actividad.estado', ['A'])

        ->get();

        // $comentarios = Comentario::select('pla_comentario.comentario', 'pla_comentario.id_poa',
        // 'pla_comentario.created_at', 'pla_comentario.estado_planificacion as estado_planificacion')
        // ->where('id_reforma', $id_reforma)
        // ->where('estado_planificacion', 'Aprobado')
        // ->orderBy('created_at', 'desc')
        // ->first();

        $pdf = \PDF::loadView('pdf.pdfReforma', ['usuarios' => $usuarios, 'atributos' => $atributos, 'actividades' => $actividades])->setPaper('A3', 'landscape');

        $pdfFileName = 'pdf_' . time() . '.pdf';

        $pdf->save(public_path("pdf/{$pdfFileName}"));

        $pdfUrl = asset("pdf/{$pdfFileName}");

        // return response()->json(['pdf_url' => $pdfUrl]);
        return $pdf->download('reporte_planificacion.pdf');
    }




    public function get_unidad(Request $request)
    {
        $valores = UnidadEjecutora::where('estado', 'A')->get();
        if ($valores) {

            return response()->json(['message' => 'La lista se cargo Correctamente', 'valores' => $valores, 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al cargar la lista de Unidades Ejecutoras', 'data' => false], 500);

        }
    }




    public function get_programa_id(Request $request)
    {
        $id_unidad  = $request->query('id_unidad');
        $valores    = Programa::where('estado', 'A')->where('id_unidad', $id_unidad)->get();
        if ($valores) {

            return response()->json(['message' => 'La lista se cargo Correctamente', 'valores' => $valores, 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al cargar la lista de los Programas', 'data' => false], 500);

        }
    }



    public function get_proyecto_id(Request $request)
    {
        $id_programa  = $request->query('id_programa');
        $valores      = Proyecto::where('estado', 'A')->where('id_programa', $id_programa)->get();
        if ($valores) {

            return response()->json(['message' => 'La lista se cargo Correctamente', 'valores' => $valores, 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al cargar la lista de los Proyectos', 'data' => false], 500);

        }
    }



    public function get_actividad_id(Request $request)
    {
        $id_proyecto  = $request->query('id_proyecto');
        $valores      = ActividadPre::where('estado', 'A')->where('id_proyecto', $id_proyecto)->get();
        if ($valores) {

            return response()->json(['message' => 'La lista se cargo Correctamente', 'valores' => $valores, 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al cargar la lista de las Actividades', 'data' => false], 500);

        }
    }



    public function get_fuente_id(Request $request)
    {
        $id_actividad  = $request->query('id_actividad');
        $valores       = Fuente::where('estado', 'A')->where('id_actividad', $id_actividad)->get();
        if ($valores) {

            return response()->json(['message' => 'La lista se cargo Correctamente', 'valores' => $valores, 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al cargar la lista de las Fuentes', 'data' => false], 500);

        }
    }



    public function get_actividades_id(Request $request){

        $id_solicitud  = $request->query('id_solicitud');

        $solicitud = Solicitud::select('area.nombre as solicitante', 'areaS.nombre as propietario', 'pla_solicitud.fecha_solicitud as fecha', 'pla_solicitud.id_actividad')
            ->join('db_inspi.inspi_area as area', 'area.id', '=', 'pla_solicitud.id_area_solicitante')
            ->join('db_inspi.inspi_area as areaS', 'areaS.id', '=', 'pla_solicitud.id_area_propietaria')
            ->where('pla_solicitud.id', $id_solicitud)->first();

        $valores = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero', 'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa',
            'pla_calendario.justificacion_area as justificacion', 'pla_poa1.plurianual as plurianual','inspi_obj_operativo.nombre as nombreObjOperativo', 'inspi_actividad_operativa.nombre as nombreActividadOperativa',
            'inspi_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.presupuesto_proyectado as presupuesto_proyectado',
            'pla_poa1.u_ejecutora as u_ejecutora', 'pla_poa1.programa as programa', 'pla_poa1.proyecto as proyecto',
            'pla_poa1.actividad as actividad', 'pla_poa1.fuente as fuente', 'pla_poa1.id_tipo_monto as idTipoMonto',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
            'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
            'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item as id_item', 'inspi_item_presupuestario.nombre as nombreItem',
            'inspi_item_presupuestario.descripcion as descripcionItem', 'inspi_item_presupuestario.monto as montoItem')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi.inspi_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'inspi_obj_operativo.id')
            ->join('db_inspi.inspi_actividad_operativa', 'pla_poa1.id_actividad', '=', 'inspi_actividad_operativa.id')
            ->join('db_inspi.inspi_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'inspi_sub_actividad.id')
            // ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->leftJoin('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi.inspi_item_presupuestario', 'pla_poa1.id_item', '=', 'inspi_item_presupuestario.id')
            ->where('pla_poa1.id', $solicitud->id_actividad)
            //->whereIn('pla_poa1.estado', ['A','R','O', 'C'])
            ->first();

        $valoresSoli = DB::table('db_inspi_planificacion.pla_actividad')
            ->select('pla_actividad.id as id', 'pla_actividad.sub_actividad as sub_actividad', 'pla_calendario_ref.tipo',
            'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_calendario_ref.marzo', 'pla_calendario_ref.abril', 'pla_calendario_ref.mayo',
            'pla_calendario_ref.junio', 'pla_calendario_ref.julio', 'pla_calendario_ref.agosto', 'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre',
            'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre')
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_poa')
            ->join('db_inspi_planificacion.pla_solicitud as sol', 'sol.id_actividad', '=', 'pla_actividad.id_poa1')
            ->where('pla_actividad.id_poa1', $solicitud->id_actividad)
            ->where('sol.estado_solicitud', 'pendiente')
            ->first();

        if ($valores) {

            return response()->json(['message' => 'La lista se cargo Correctamente', 'valores' => $valores, 'valoresSoli' => $valoresSoli, 'solicitud' => $solicitud, 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al cargar la lista de la Actividad', 'data' => false], 500);

        }

    }



    public function aproSolicitud(Request $request)
    {

        $id_solicitud  = $request->input('id_solicitud');
        $estado        = $request->input('estado');

        $solicitud = Solicitud::find($id_solicitud);

        if ($solicitud) {

            $solicitud->update([
                'estado_solicitud' => $estado,
            ]);

            return response()->json(['message' => 'Solicitud actalizada con exito', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al actualizar la reforma', 'data' => false], 500);

        }
    }



    public function reportDetalle(Request $request)
    {
        $filterAnio         = $request->input('filterAnio');
        $filterDireccion    = $request->input('filterDireccion');
        $filterItem         = $request->input('filterItem');
        $filterSubActividad = $request->input('filterSubActividad');

        $usuarios = [
            'elabora' => ['name' => $request->input('elabora'),'cargo' => $request->input('cargo_elabora')],
            'revisa'  => ['name' => $request->input('revisa'),'cargo' => $request->input('cargo_revisa')],
            'aprueba' => ['name' => $request->input('aprueba'),'cargo' => $request->input('cargo_aprueba')],
        ];

        // Construir el query base
        $query = DB::table('db_inspi_planificacion.pla_poa1')
            ->select(
                'pla_poa1.id as id', 'pla_actividad_operativa.nombre as actividad_operativa', 'pla_obj_operativo.nombre as objOperativo',
                'pla_sub_actividad.nombre as sub_actividad', 'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
                'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
                'pla_fuente.nombre as fuente', 'pla_calendario.enero as enero', 'pla_calendario.febrero as febrero', 'pla_calendario.marzo as marzo', 'pla_calendario.abril as abril',
                'pla_calendario.mayo as mayo', 'pla_calendario.junio as junio', 'pla_calendario.julio as julio', 'pla_calendario.agosto as agosto', 'pla_calendario.septiembre as septiembre',
                'pla_calendario.octubre as octubre', 'pla_calendario.noviembre as noviembre', 'pla_calendario.diciembre as diciembre', 'pla_poa1.monto as total', 'pla_tipo_monto.nombre as frecuencia',
                'pla_tipo_poa.nombre as tipoPoa', 'pro.nombre as proceso', 'area.nombre as direccion'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_tipo_proceso as pro', 'pro.id', '=', 'pla_poa1.id_proceso')
            
            ->whereNotIn('pla_poa1.estado', ['E']);

        // Aplicar los filtros condicionalmente
        if (!empty($filterAnio)) {
            $query->where('pla_poa1.año', $filterAnio);
        }

        if (!empty($filterDireccion)) {
            $query->where('pla_poa1.id_area', $filterDireccion);
        }

        if (!empty($filterItem)) {
            $query->where('pla_item_presupuestario.id', $filterItem);
        }

        if (!empty($filterSubActividad)) {
            $query->where('pla_sub_actividad.id', $filterSubActividad);
        }

        // Ejecutar el query
        $actividades = $query->get();

        

        $pdf = \PDF::loadView('pdf.pdfDetalle', ['usuarios' => $usuarios, 'actividades' => $actividades])->setPaper('A3', 'landscape');

        //$pdfFileName = 'pdf_' . time() . '.pdf';

        //$pdf->save(public_path("pdf/{$pdfFileName}"));

        //$pdfUrl = asset("pdf/{$pdfFileName}");
        

        //return response()->json(['pdf_url' => $actividades]);
        return $pdf->download('reporte_detalle.pdf');
    }



    /* USUARIOS */
    public function reportDetalleUser(Request $request)
    {
        $filterAnio   = $request->input('filterAnio');
        $id_direccion = $request->input('id_direccion');

        $usuarios = [
            'elabora' => ['name' => $request->input('elabora'),'cargo' => $request->input('cargo_elabora')],
            'revisa'  => ['name' => $request->input('revisa'),'cargo' => $request->input('cargo_revisa')],
            'aprueba' => ['name' => $request->input('aprueba'),'cargo' => $request->input('cargo_aprueba')],
        ];

        // Construir el query base
        $query = DB::table('db_inspi_planificacion.pla_poa1')
            ->select(
                'pla_poa1.id as id', 'pla_actividad_operativa.nombre as actividad_operativa', 'pla_obj_operativo.nombre as objOperativo',
                'pla_sub_actividad.nombre as sub_actividad', 'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
                'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
                'pla_fuente.nombre as fuente', 'pla_calendario.enero as enero', 'pla_calendario.febrero as febrero', 'pla_calendario.marzo as marzo', 'pla_calendario.abril as abril',
                'pla_calendario.mayo as mayo', 'pla_calendario.junio as junio', 'pla_calendario.julio as julio', 'pla_calendario.agosto as agosto', 'pla_calendario.septiembre as septiembre',
                'pla_calendario.octubre as octubre', 'pla_calendario.noviembre as noviembre', 'pla_calendario.diciembre as diciembre', 'pla_poa1.monto as total', 'pla_tipo_monto.nombre as frecuencia',
                'pla_tipo_poa.nombre as tipoPoa', 'pro.nombre as proceso', 'area.nombre as direccion'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_tipo_proceso as pro', 'pro.id', '=', 'pla_poa1.id_proceso')
            ->whereNotIn('pla_poa1.estado', ['E'])
            ->where('area.id', $id_direccion);

        // Aplicar los filtros condicionalmente
        if (!empty($filterAnio)) {
            $query->where('pla_poa1.año', $filterAnio);
        }

        // Ejecutar el query
        $actividades = $query->get();

        $pdf = \PDF::loadView('pdf.pdfDetalle', ['usuarios' => $usuarios, 'actividades' => $actividades])->setPaper('A3', 'landscape');

        $pdfFileName = 'pdf_' . time() . '.pdf';

        //$pdf->save(public_path("pdf/{$pdfFileName}"));

        //$pdfUrl = asset("pdf/{$pdfFileName}");

        // return response()->json(['pdf_url' => $pdfUrl]);
        return $pdf->download('reporte_detalle.pdf');
    }
    /* USUARIOS */



    //Excel
    public function reportDetalleExcel(Request $request)
    {
        $filterAnio         = $request->input('filterAnio');
        $filterDireccion    = $request->input('filterDireccion');
        $filterItem         = $request->input('filterItem');
        $filterSubActividad = $request->input('filterSubActividad');

        // Construir el query base
        $query = DB::table('db_inspi_planificacion.pla_poa1')
            ->select(
                'pla_poa1.id as id', 'pla_actividad_operativa.nombre as actividad_operativa', 'pla_obj_operativo.nombre as objOperativo',
                'pla_sub_actividad.nombre as sub_actividad', 'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
                'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
                'pla_fuente.nombre as fuente', 'pla_calendario.enero as enero', 'pla_calendario.febrero as febrero', 'pla_calendario.marzo as marzo', 'pla_calendario.abril as abril',
                'pla_calendario.mayo as mayo', 'pla_calendario.junio as junio', 'pla_calendario.julio as julio', 'pla_calendario.agosto as agosto', 'pla_calendario.septiembre as septiembre',
                'pla_calendario.octubre as octubre', 'pla_calendario.noviembre as noviembre', 'pla_calendario.diciembre as diciembre', 'pla_poa1.monto as total', 'pla_tipo_monto.nombre as frecuencia',
                'pla_tipo_poa.nombre as tipoPoa', 'pro.nombre as proceso', 'area.nombre as direccion'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_tipo_monto', 'pla_poa1.id_tipo_monto', '=', 'pla_tipo_monto.id')
            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')
            ->join('db_inspi_planificacion.pla_tipo_proceso as pro', 'pro.id', '=', 'pla_poa1.id_proceso')
            
            ->whereNotIn('pla_poa1.estado', ['E']);

        // Aplicar los filtros condicionalmente
        if (!empty($filterAnio)) {
            $query->where('pla_poa1.año', $filterAnio);
        }

        if (!empty($filterDireccion)) {
            $query->where('pla_poa1.id_area', $filterDireccion);
        }

        if (!empty($filterItem)) {
            $query->where('pla_item_presupuestario.id', $filterItem);
        }

        if (!empty($filterSubActividad)) {
            $query->where('pla_sub_actividad.id', $filterSubActividad);
        }

        // Ejecutar el query
        $actividades = $query->get();

        return Excel::download(new ReportDetalleExport($actividades), 'reporte_detalle.xlsx');

       // $pdf = \PDF::loadView('pdf.pdfDetalle', ['usuarios' => $usuarios, 'actividades' => $actividades])->setPaper('A3', 'landscape');

        //$pdfFileName = 'pdf_' . time() . '.pdf';

        //$pdf->save(public_path("pdf/{$pdfFileName}"));

        //$pdfUrl = asset("pdf/{$pdfFileName}");
        

        //return response()->json(['pdf_url' => $actividades]);
        //return $pdf->download('reporte_detalle.pdf');
    }



    public function import_actividad(){ //VISTA PARA CARGAR .CSV
        //respuesta para la vista
        return view('planificacion.import_actividad');
    }


 //===============================================================================================================

    public function import(Request $request)
    {
        try {
            // Obtener el archivo cargado
            $file = $request->file('file');
    
            // Obtener la extensión original del archivo
            $extension = $file->getClientOriginalExtension();
    
            // Generar un nombre único para el archivo con su extensión
            $fileName = 'Importacion_' . time() . '.' . $extension;
    
            // Mover el archivo a una ubicación específica
            $file->move(public_path('uploads'), $fileName);
    
            // Importar el archivo usando el nombre con la extensión
            Excel::import(new ActividadImport(), public_path('uploads') . '/' . $fileName);
    
            \DB::commit();
    
            return response()->json(['success' => true, 'message' => 'Datos importados correctamente']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al importar datos', 'error' => $e->getMessage()]);
        }
    }



    /*
    public function ejecutarPla(){

        $consultaPersonas = Persona::select('*')->where('status', 'A')->get();

        foreach ($consultaPersonas as $persona) {

            $nombre   = $persona->nombres;
            $apellido = $persona->apellidos;
            $correo   = $persona->correo;

            $nombre_comp = $nombre .' ' . $apellido;

            $datos = [
                'name'     => $nombre_comp,
                'email'    => $correo,
                'position' => 'Trabajador',
                'password' => '$10$YM0.FGtZ5yh.EJwJ1Iv8w.yb8reAS.Q4o4uzPPZdtEHfwRCKhi51C',
            ];

            $consultaUser = User::create($datos);
            $consultaUser->save();

        }



    }
    */



    /* TRAER DATOS DEL POA POR ID */
    public function obtenerPoa($id)
    {
        // Busca el POA por su ID
        $poa = Poa::select('pla_poa1.id', 'pla_poa1.departamento', 'pla_poa1.monto', 'act.nombre as actividad', 'sub.nombre as subactividad')
            ->join('pla_actividad_operativa as act', 'act.id', '=', 'pla_poa1.id_actividad')
            ->join('pla_sub_actividad as sub', 'sub.id', '=', 'pla_poa1.id_sub_actividad')
            //->where('pla_poa1.estado', 'A')
            ->where('pla_poa1.id', $id)
            ->first();


        if (!$poa) {
            return response()->json(['message' => 'POA no encontrado', 'success' => false], 404);
        }

        return response()->json(['poa' => $poa, 'success' => true]);
    }
    /* TRAER DATOS DEL POA POR ID */



    /* TRAER DATOS DEL POA POR ID */
    public function solicitadPOA(Request $request)
    {

        $data = $request->validate([
            'solicitud_id' => 'required|string',
            'justifi'      => 'required|string',
        ]);

        $id_poa  = $request->input('solicitud_id');
        $justifi = $request->input('justifi');

        $poa = Poa::find($id_poa);
        $poa->estado = 'S';
        $poa->save();

        $calendario = Calendario::where('id_poa', $id_poa)->first();
        $calendario->justificacion_area = $justifi;
        $calendario->save();

        $id_usuario = Auth::user()->id;

        $datos = [
            'id_poa' => $id_poa,
            'id_usuario' => $id_usuario,
            'comentario' => $justifi,
            'estado_planificacion' => 'Solicitado'
         ];
        $comentario = Comentario::create($datos);

        if ($comentario) {

            return response()->json(['message' => 'Solicitud POA enviada.', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al enviar la solicitud', 'data' => false], 500);

        }

    }
 

}
