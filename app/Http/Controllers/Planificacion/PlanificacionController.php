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

//FORMULARIO
use App\Models\Planificacion\Formulario\Formulario;
use Illuminate\Support\Facades\Log;



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
use App\Models\Planificacion\Contador\Contador;
use App\Models\Planificacion\ContadorRef\ContadorRef;

//use App\Models\Area\Area;
use App\Models\CoreBase\Area;


use App\Models\RecursosHumanos\Persona;
use App\Imports\ActividadImport;

use App\Exports\ReportDetalleExport;
use App\Exports\ReportPOAExport;
//use Maatwebsite\Excel\Facades\Excel;

use App\Traits\GetDireccionTrait;

class PlanificacionController extends Controller
{

    use GetDireccionTrait;

    public function index(Request $request){

        $estado = $request->input('estado');

        if(request()->ajax()) {

            $estado    = request()->get('estado');
            $direccion = request()->get('direccion');
            $item      = request()->get('item');
            $programa  = request()->get('programa');

            if ($programa) {
                $programaIds = Programa::where('nombre', $programa)->pluck('id');
            } else {
                $programaIds = null;
            }

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
                'pla_poa1.monto'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
            ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
            ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
            ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
            ->join('pla_tipo_proceso as pro', 'pro.id', '=', 'db_inspi_planificacion.pla_poa1.id_proceso')
            ->join('db_inspi_planificacion.pla_item_presupuestario as itep', 'itep.id', '=', 'pla_poa1.id_item')
            ->whereIn('pla_poa1.estado', ['A', 'O', 'R', 'C', 'S'])// Solo estados válidos
            ->whereNotIn('pla_poa1.id_area', [17,18]);
        
            // **Aplicar filtros si se selecciona alguno**
            if (!empty($estado)) {
                $query->where('pla_poa1.estado', $estado);
            }
        
            if (!empty($direccion)) {
                $query->where('pla_poa1.departamento', $direccion);
            }
        
            if (!empty($item)) {
                $query->where('pla_poa1.id_item', $item);
            }

            if (!empty($programaIds)) {
                $query->whereIn('pla_poa1.programa', $programaIds);
            }
        
            // **Devolver datos en formato JSON**
            return datatables()->of($query)->addIndexColumn()->make(true);
        }

        $tipo_Poa = TipoPoa::where('estado', 'A')->get();
        $obj_Operativo = ObjetivoOperativo::where('estado', 'A')->get();
        $act_Operativa = ActividadOperativa::where('estado', 'A')->get();
        $sub_Act  = SubActividad::where('estado', 'A')->get();

        //$direcciones  = Poa::select('departamento')->distinct()->get();

        $direcciones  = MontoDireccion::select('nombre as departamento')->whereNotIn('id', [17,18])->get();

        $items = ItemPresupuestario::select('pla_item_presupuestario.*')
            //->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_item_presupuestario.estado', 'A')
            //->where('itemdir.id_direcciones', $id_direccion)
            ->get();

        $programas = Programa::select('nombre')->distinct()->get();

        //respuesta para la vista
        return view('planificacion.index', compact('tipo_Poa','obj_Operativo', 'direcciones', 'items',
            'act_Operativa','sub_Act', 'programas'));
    }

// -----------------------------------------------------------------------------------------------------------

    /* VISTA - CREAR NUEVA PLANIFICACION */
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
    /* VISTA - CREAR NUEVA PLANIFICACION */



    /* VISTA - CREAR NUEVA PLANIFICACION EN 0 */
    public function nuevaPlanificacion($id_direccion){

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
        $id_direccion = $direccion->id;

        $monto = $montoDir - $montoTotal;
        if($monto == 0){
            $monto = true;
        }else{
            $monto = false;
        }

        //respuesta para la vista
        return view('planificacion.nueva_planificacion', compact('tipos', 'item_presupuestario', 'id_fuente', 'nombre', 'objExistente', 'proceso', 'monto', 'montoDir', 'id_direccion'));
    }
    /* VISTA - CREAR NUEVA PLANIFICACION EN 0 */


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
            //$nombreActExistente = ActividadOperativa::where('nombre', $actOpera)->first();
            //if ($nombreActExistente) {
                // Si existe, usar su ID
                //$id_actividad = $nombreActExistente->id;
            //} else {
                // Si no existe, crear una nueva
                $actop = new ActividadOperativa;
                $actop->id_area = $id_area;
                $actop->nombre  = $actOpera;
                $actop->estado  = 'A';
                $actop->save();
                $id_actividad   = $actop->id;
            //}

            // Verificar si existe la subactividad
            //$nombreSubActExistente = SubActividad::where('nombre', $subActi)->first();
            //if ($nombreSubActExistente) {
                // Si existe, usar su ID
                //$id_sub_actividad = $nombreSubActExistente->id;
            //} else {
                // Si no existe, crear una nueva
                $sub = new SubActividad;
                $sub->id_area = $id_area;
                $sub->nombre  = $subActi;
                $sub->estado  = 'A';
                $sub->save();
                $id_sub_actividad = $sub->id;
            //}

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
        $id_area = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;
    
        if ($id_area == 7) {
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre', 'proceso_estado')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $monto        = number_format($direccion->monto, 2);
            $id_fuente    = $direccion->id_fuente;
            $area         = $direccion->nombre;
            $proestado    = $direccion->proceso_estado;
        } else {
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre', 'proceso_estado')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $monto        = number_format($direccion->monto, 2);
            $id_fuente    = $direccion->id_fuente;
            $area         = $direccion->nombre;
            $proestado    = $direccion->proceso_estado;
        }
    
        $totalItems = Poa::selectRaw('SUM(monto) as total_monto')
            ->where('id_area', $id_direccion)
            ->where('estado', '!=', 'E')
            ->first();
        $totalOcupado = $totalItems->total_monto ?? 0;
        $totalOcupado = number_format($totalOcupado, 2);

        $totalCertificado = ItemDireccion::where('estado', 'A')->where('id_direcciones', $id_direccion)->sum('certificado');   
        $totalCertificado = number_format($totalCertificado, 2);
    
        $items = ItemPresupuestario::select('pla_item_presupuestario.*')
            ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_item_presupuestario.estado', 'A')
            ->where('itemdir.id_direcciones', $id_direccion)
            ->get();

    
            if (request()->ajax()) {

                $estado    = request()->get('estado');
                $item      = request()->get('item');

                $query = Poa::select(
                    'pla_poa1.id as id',
                    'pla_poa1.departamento as coordinacion',
                    'pla_poa1.nro_poa as numero',
                    DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d %H:%i:%s") as fecha'),
                    'tipo_poa.nombre as POA',
                    'pro.nombre as proceso',
                    'objOpe.nombre as obj_operativo',
                    'actOpe.nombre as act_operativa',
                    'item.nombre as item',
                    'subAct.nombre as sub_actividad',
                    'pla_poa1.monto as monto',
                    'pla_poa1.estado as estado',

                    //'sp.id as id_solicitud',
                    // Subconsulta para obtener estado_solicitud o 'no solicitado' si no hay coincidencia
                    DB::raw("(SELECT sp.estado_solicitud FROM db_inspi_planificacion.pla_solicitud sp 
                    WHERE sp.id_poa = pla_poa1.id and sp.estado = 'A' and sp.estado_solicitud = 'pendiente'
                    LIMIT 1) AS estado_solicitud"),
                    //'sp.estado_solicitud as estado_solicitud',
                    // Subconsulta para obtener id de la solicitud o 0 si no hay coincidencia
                    DB::raw("(SELECT sp.id FROM db_inspi_planificacion.pla_solicitud sp 
                    WHERE sp.id_poa = pla_poa1.id and sp.estado = 'A' and sp.estado_solicitud = 'pendiente'
                    LIMIT 1) AS id_solicitud"),

                    'pla_poa1.id_area as id_area',
                    'dir.proceso_estado as estado_pro',
                    'pla_poa1.descargado as descargado'
                    //DB::raw('CASE WHEN act.id_poa1 = pla_poa1.id THEN true ELSE false END as reforma')
                )
                    ->join('db_inspi_planificacion.pla_direcciones as dir', 'dir.id', '=', 'db_inspi_planificacion.pla_poa1.id_area')
                    ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
                    ->join('pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
                    ->join('pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
                    ->join('pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
                    ->join('pla_tipo_proceso as pro', 'pro.id', '=', 'db_inspi_planificacion.pla_poa1.id_proceso')
                    ->join('pla_item_presupuestario as item', 'pla_poa1.id_item', '=', 'item.id')
                    //->leftJoin('db_inspi_planificacion.pla_actividad as act', 'act.id_poa1', '=', 'pla_poa1.id') // Unión con pla_actividad
                    //->leftJoin('db_inspi_planificacion.pla_solicitud as sp', 'pla_poa1.id', '=', 'sp.id_poa')
                    ->whereIn('pla_poa1.estado', ['A', 'R', 'O', 'C', 'S'])
                    ->where('pla_poa1.id_area', '=', $id_direccion);

                    //->where(function ($query) {
                        //$query->whereNull('sp.id') // Si no existe en pla_solicitud
                              //->orWhere('sp.estado_solicitud', 'A'); // O si existe y su estado es 'A'
                    //});
            
                // Aplicar filtro por item si es que se seleccionó uno
                if (!empty($item)) {
                    $query->where('pla_poa1.id_item', $item);
                }

                if (!empty($estado)) {
                    $query->where('pla_poa1.estado', $estado);
                }
            
                return datatables()->of($query->get())
                    ->addIndexColumn()
                    ->make(true);
            }
            
    
        return view('planificacion.vista_user', compact('id_direccion', 'monto', 'area', 'totalOcupado', 'items', 'totalCertificado', 'proestado'));
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



    //Eliminar certificacion del POA
    public function deleteCertificacion(Request $request)
    {
        $poa = Poa::find($request->id); //Busca el registro por el ID

        if ($poa) {

            $poa->update([
                'estado' => 'A', //Asigna el estado "E" para no mostrarlo en la tabla
                'descargado' => 0,
            ]);

            return response()->json(['message' => 'Certificación anulada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al anular la certificación', 'data' => false], 500);

        }

    }
    //Eliminar certificacion del POA



    //--------------------------------------------------------------------------------------------------------
    //Detalle del POA en base al calendario
    public function detalle(Request $request)
    {
        $id_usuario = Auth::user()->id;
    
        $anio = $request->input('anio') ?? date('Y'); // Por defecto, el año actual
        $direccion = $request->input('direccion');   // Dirección seleccionada
        $item = $request->input('item');             // Item seleccionado
        $sub_actividad = $request->input('sub_actividad'); // Sub actividad seleccionada
        $unidad = $request->input('unidad');
    
        if (request()->ajax()) {
            $query = Poa::select(
                'pla_poa1.id as id', 'area.nombre as Area', 'tipo_poa.nombre as POA',
                'actOpe.nombre as act_operativa', 'itep.nombre as item', 'ite.monto as monto_item',
                'objOpe.nombre as obj_operativo', 'subAct.nombre as sub_actividad',
                'cal.enero as enero', 'cal.febrero as febrero', 'cal.marzo as marzo', 
                'cal.abril as abril', 'cal.mayo as mayo', 'cal.junio as junio',
                'cal.julio as julio', 'cal.agosto as agosto', 'cal.septiembre as septiembre', 
                'cal.octubre as octubre', 'cal.noviembre as noviembre', 'cal.diciembre as diciembre', 'pla_poa1.monto',
                'uni.nombre as u_ejecutora', 'pro.nombre as programa', 'proy.nombre as proyecto', 
                'act.nombre as actividad', 'fue.nombre as fuente', 'proceso.nombre as proceso'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
            ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
            ->join('db_inspi_planificacion.pla_calendario as cal', 'cal.id_poa', '=', 'db_inspi_planificacion.pla_poa1.id')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'db_inspi_planificacion.pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_items_direcciones as ite', 'ite.id', '=', 'db_inspi_planificacion.pla_poa1.id_item_dir')
            ->join('db_inspi_planificacion.pla_item_presupuestario as itep', 'itep.id', '=', 'ite.id_item')
            ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
            ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
            ->join('db_inspi_planificacion.pla_tipo_proceso as proceso', 'proceso.id', '=', 'db_inspi_planificacion.pla_poa1.id_proceso')

            ->join('db_inspi_planificacion.pla_unidad_ejecutora as uni', 'pla_poa1.u_ejecutora', '=', 'uni.id')
            ->join('db_inspi_planificacion.pla_programa as pro', 'pla_poa1.programa', '=', 'pro.id')
            ->join('db_inspi_planificacion.pla_proyecto as proy', 'pla_poa1.proyecto', '=', 'proy.id')
            ->join('db_inspi_planificacion.pla_actividad_act as act', 'pla_poa1.actividad', '=', 'act.id')
            ->join('db_inspi_planificacion.pla_fuente as fue', 'pla_poa1.fuente', '=', 'fue.id')

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
            if ($unidad) {
                $query->where('uni.id', $unidad);
            }
    
            $data = $query->groupBy(
                'id', 'Area', 'POA', 'obj_operativo', 'act_operativa', 'sub_actividad', 'itep.nombre',
                'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 
                'septiembre', 'octubre', 'noviembre', 'diciembre', 'monto', 'uni.nombre', 'pro.nombre',
                'proy.nombre', 'act.nombre', 'fue.nombre', 'ite.monto', 'proceso.nombre'
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
        
        $unidades = UnidadEjecutora::where('estado', 'A')->get();
        //$unidades = UnidadEjecutora::where('estado', 'A')->get();

        $sumaActividades = Poa::where('estado', 'O')
            ->where('año', $anio)
            ->sum('monto');
    
        return view('planificacion.detalle_poa', compact(
            'tipo_Poa', 'act_Operativa', 'calendario', 'direcciones', 'items', 'sub_actividades',
            'sumaMontos', 'sumaActividades', 'unidades'
        ));
    }
    


    //Detalle del POA en base al calendario
    public function detalleUser(Request $request){

        // ========= Obtener datos de dirección usando la función del Trait(Inicio)
        $direccionData = $this->obtenerDireccion();

        if (!$direccionData) {
            return response()->json(['error' => 'No se encontró la dirección'], 404);
        }
        $id_direccion = $direccionData['id_direccion'];
        // ========= Obtener datos de dirección usando la función del Trait(Fin)
        

        // Capturar filtros desde la petición AJAX
        $anio = $request->input('anio', date('Y')); // Si no hay, usa el año actual
        $item = $request->input('item');
        $sub_actividad = $request->input('sub_actividad');

        if (request()->ajax()) {
            $query = Poa::select(
                'pla_poa1.id as id', 'area.nombre as Area', 'item.nombre as item',
                'tipo_poa.nombre as POA','actOpe.nombre as act_operativa',
                'objOpe.nombre as obj_operativo','subAct.nombre as sub_actividad',
                'cal.enero as enero', 'cal.febrero as febrero','cal.marzo as marzo','cal.abril as abril',
                'cal.mayo as mayo','cal.junio as junio','cal.julio as julio','cal.agosto as agosto',
                'cal.septiembre as septiembre','cal.octubre as octubre','cal.noviembre as noviembre','cal.diciembre as diciembre'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa as tipo_poa', 'tipo_poa.id', '=', 'db_inspi_planificacion.pla_poa1.id_tipo_poa')
            ->join('db_inspi_planificacion.pla_actividad_operativa as actOpe', 'actOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_actividad')
            ->join('db_inspi_planificacion.pla_calendario as cal', 'cal.id_poa', '=', 'db_inspi_planificacion.pla_poa1.id')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'db_inspi_planificacion.pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_obj_operativo as objOpe', 'objOpe.id', '=', 'db_inspi_planificacion.pla_poa1.id_obj_operativo')
            ->join('db_inspi_planificacion.pla_sub_actividad as subAct', 'subAct.id', '=', 'db_inspi_planificacion.pla_poa1.id_sub_actividad')
            ->join('db_inspi_planificacion.pla_item_presupuestario as item', 'pla_poa1.id_item', '=', 'item.id')
            ->where('pla_poa1.estado', '!=', 'E')
            ->where('pla_poa1.id_area', '=', $id_direccion)
            ->where('pla_poa1.año', $anio);
    
            // 🔹 Aplicar filtros solo si existen valores
            if (!empty($item)) {
                $query->where('pla_poa1.id_item', $item);
            }
    
            if (!empty($sub_actividad)) {
                $query->where('pla_poa1.id_sub_actividad', $sub_actividad);
            }
    
            return datatables()->of($query->get())->addIndexColumn()->make(true);
        }

        $sumaActividades = Poa::where('estado', '!=', 'E')
            ->where('año', $anio)
            ->where('pla_poa1.id_area', '=', $id_direccion)
            ->sum('monto');

        $sumaActividades = number_format($sumaActividades, 2, '.', ',');

        $items = ItemPresupuestario::select('pla_item_presupuestario.*')
            ->join('db_inspi_planificacion.pla_items_direcciones as item_dir', 'item_dir.id_item', '=', 'db_inspi_planificacion.pla_item_presupuestario.id')
            ->where('item_dir.estado', 'A')->where('item_dir.id_direcciones', $id_direccion)->get();

        $sub_actividades = SubActividad::select('pla_sub_actividad.*')
            ->join('db_inspi_planificacion.pla_poa1 as poa', 'poa.id_sub_actividad', '=', 'db_inspi_planificacion.pla_sub_actividad.id')
            ->where('poa.estado', 'A')->where('poa.id_area', $id_direccion)->get();

        //respuesta para la vista
        return view('planificacion.detalleUser_poa', compact('sumaActividades', 'id_direccion', 'items', 'sub_actividades'));

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
                'pla_poa1.u_ejecutora as u_ejecutora', 'pla_poa1.programa as programa', 'pla_poa1.proyecto as proyecto', 'pla_poa1.monto_certificado as certificado',
                'pla_poa1.actividad as actividad', 'pla_poa1.fuente as fuente', 'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.presupuesto_proyectado as presupuesto_proyectado', 'pla_poa1.id_tipo_monto as idTipoMonto',
                'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 'pla_calendario.mayo',
                'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 'pla_calendario.septiembre', 'pla_calendario.octubre',
                'pla_calendario.noviembre', 'pla_calendario.diciembre', 'pla_poa1.id_item_dir as id_item', 'pla_item_presupuestario.nombre as nombreItem',
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

            $item_presupuestario = ItemPresupuestario::select('itemdir.id_item as id_item', 'itemdir.id as id', 'pla_item_presupuestario.nombre', 
                'pla_item_presupuestario.descripcion', 'itemdir.monto')
                ->join('pla_items_direcciones as itemdir', 'itemdir.id_item', '=', 'pla_item_presupuestario.id')
                ->where('itemdir.estado', 'A')
                ->where('itemdir.id_direcciones', $Poa->id_area)->get();

            $item_suma = ItemPresupuestario::join(
                'db_inspi_planificacion.pla_items_direcciones as item_dir',
                'item_dir.id_item', '=', 'pla_item_presupuestario.id'
            )
            ->where('item_dir.estado', 'A')
            ->sum('item_dir.monto'); // Ahora el sum() está bien ubicado
        

        return view('planificacion.edit_estado_planificacion', compact('Poa', 'tipos', 'calendario', 'atributos', 'tipoMonto',
            'comentarios', 'item_presupuestario', 'unidad_eje', 'programa', 'proyecto', 'actividad', 'fuente', 'item_suma'));
    }
    //------------------------------------------------------------------------------------------------------------




    public function edit_estado_planificacion_zonal(Request $request, $id){

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
            'pla_poa1.u_ejecutora as u_ejecutora', 'pla_poa1.programa as programa', 'pla_poa1.proyecto as proyecto', 'pla_poa1.monto_certificado as certificado',
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

            $item_suma = ItemPresupuestario::join(
                'db_inspi_planificacion.pla_items_direcciones as item_dir',
                'item_dir.id_item', '=', 'pla_item_presupuestario.id'
                )
                ->where('item_dir.estado', 'A')
                ->sum('item_dir.monto'); // Ahora el sum() está bien ubicado

        return view('planificacion.edit_estado_planificacion_zonal', compact('Poa', 'tipos', 'calendario', 'atributos', 'tipoMonto',
        'comentarios', 'item_presupuestario', 'unidad_eje', 'programa', 'proyecto', 'actividad', 'fuente', 'item_suma'));
    }




    public function agregarComentarioEstado(Request $request)
    {
        $data = $request->validate([
            'id_poa'    => 'required|string',
            'estadoPoa' => 'required|string',
            'montoDis'  => 'required|string',
            'justificacionPoa'  => 'required|string',
        ]);
    
        $id_poa    = $request->input('id_poa');
        $estadoPoa = $request->input('estadoPoa');
        $montoDis  = $request->input('montoDis');
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

            //para saber a que dirección pertenece
            $zonal = '';
            if($Poa->id_area == 17){
                $zonal = 'CZ6';
            }else if($Poa->id_area == 18){
                $zonal = 'CZ9';
            }else{
                $zonal = 'CENTRAL';
            }
    
            if ($estadoPoa == 'O') {

                // ======  si se aprobo, se restara el monto certificado (inicio)
                $montoAnteri = $Poa->monto;
                $montoCertif = $Poa->monto_certificado;

                $montoActual = $montoAnteri - $montoCertif;
                // si queda un sobrante, se crea una nueva actividad 
                if($montoActual > 0){
                    $result = $Poa->crearNuevaActividad($Poa->id, $montoActual);
                    if (!$result) {
                        return response()->json(['success' => false, 'message' => 'Error al crear la actividad']);
                    }
                }
                

                // ======  si se aprobo, se restara el monto certificado (fin)

                $itemPre = ItemDireccion::where('id', $Poa->id_item_dir)
                    ->where('estado', 'A')
                    ->first();
    
                if ($itemPre) {
                    $monto = $itemPre->monto - $calendario->total; //monto restante
                    $montoCert = $calendario->total;
                    $tipo = 'I';
    
                    $itemPre->certificado += $montoCert;
                    $itemPre->save();
    
                    ConsumoItem::actualizarEstadosPorIdItem($Poa->id_item);
    
                    $fecha = date('Y-m-d H:i:s');
                    $anio = date('Y');
    
                    $consumo = ConsumoItem::create([
                        'id_item'         => $itemPre->id_item,
                        'id_actividad'    => $id_poa,
                        'monto_consumido' => $calendario->total,
                        'monto'           => $monto,
                        'fecha'           => $fecha,
                        'anio'            => $anio,
                        'tipo'            => $tipo,
                    ]);
    
                    $id_consumo = $consumo->id;
                }
    
                $nuevoNroPoa = $this->actualizarContador($zonal);
                //$ultimoNroPoa = Poa::where('estado', 'O')->max('nro_poa');
                //$nuevoNroPoa = $ultimoNroPoa ? $ultimoNroPoa + 1 : 1;
                $Poa->update([
                    'estado'     => $estadoPoa,
                    'nro_poa'    => $nuevoNroPoa,
                    'id_consumo' => $id_consumo ?? null,
                    'monto_item' => $montoDis,

                    'monto' => $montoCertif,
                    'monto_anterior' => $montoAnteri,
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


    public function editarPlanificacionRechazo(Request $request, $id){

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
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem', 'pla_poa1.monto_certificado as certificado')
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
            
            return view('planificacion.edit_planificacion_rechazo', compact('tipos', 'atributos', 'tipoMonto', 'comentarios', 'item_presupuestario', 'atributos_operativos',
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

        $certificado = $request->input('certificado');

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
        $poa->monto_certificado   = $certificado;

        // Verificar si el estado actual es "Rechazado"
        if ($poa->estado === 'R') {
            // Cambiar el estado a "Corregido"
            $poa->estado = 'S';
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
        $calendario->total      = $request->input('monto');
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
        if ($poa->estado === 'S') {
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


    public function obtenerObjetoContratacion($id_item_dir) {


        // ========= Obtener datos de dirección usando la función del Trait(Inicio)
        $direccionData = $this->obtenerDireccion();

        if (!$direccionData) {
            return response()->json(['error' => 'No se encontró la dirección'], 404);
        }
        $id_direccion = $direccionData['id_direccion'];
        // ========= Obtener datos de dirección usando la función del Trait(Fin)

        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id','pla_poa1.departamento as departamento', 'pla_poa1.nro_poa as numero',
            DB::raw('DATE_FORMAT(pla_poa1.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_poa1.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa', 'pla_poa1.id_area as id_areaS',
            'pla_poa1.plurianual as plurianual',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_poa1.monto as monto', 'pla_poa1.id_tipo_monto as idTipoMonto',
            'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem')

            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            
            ->where('pla_poa1.id_area', '=', $id_direccion)
            //->where('pla_poa1.año', '=', $anio)
            ->whereNotIn('pla_poa1.estado', ['E']);

            if ($id_item_dir != 0) {
                $atributos->where('pla_poa1.id_item_dir', '=', $id_item_dir);
            }

            $atributos = $atributos->get();

        // Retornar los datos como JSON
        return response()->json([
            'atributos'       => $atributos,
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
            'pla_poa1.fecha as fecha', 'pla_poa1.id_tipo_poa as idPoa', 'pla_poa1.monto_item as monto_item',
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
        'pla_item_presupuestario.monto', 'pla_poa1.monto_item')
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

        //return response()->json(['pdf_url' => $atributos, 'id' => $id_poa]);
        return $pdf->download('reporte_poa.pdf');
    }


    /* GENERAR PDF  */
    public function actualizaDescarga(Request $request)
    {
        $id_poa  = $request->query('id_poa');

        $poa = Poa::find($id_poa);
        if($poa){

            $poa->descargado = true;
            $poa->save();
            return response()->json(['message' => 'Se cambio el estado exitosamente', 'success' => true], 200);

        }else{

            return response()->json(['message' => 'Error al cambiar el estado de la descarga', 'success' => false], 500);

        }

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

            return datatables()->of(
                
                
                Reforma::with(['actividades.calendarioReformas'])
                    ->select('pla_reforma.id as id_reforma', 'pla_reforma.nro_solicitud', 'pla_reforma.area_id', 'pla_reforma.justificacion_area as justificacion', 
                        DB::raw('DATE_FORMAT(pla_reforma.created_at, "%Y-%m-%d") as fecha'), 'pla_reforma.estado', 'pla_reforma.tipo', 'pla_reforma.total as total_monto',
                        'pla_reforma.nro_reforma')
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

        $direcciones   = MontoDireccion::select('*')->whereIn('estado', ['A'])->get();

        if (request()->ajax()) {

            $estado = request()->get('estado');
            $tipo   = request()->get('tipo');
            $direccion = request()->get('direccion');
        
            $query = Reforma::with(['actividades.calendarioReformas'])
                ->select(
                    'pla_reforma.id as id_reforma', 
                    'pla_reforma.nro_solicitud', 
                    'pla_reforma.nro_reforma', 
                    'pla_reforma.area_id', 
                    'pla_reforma.justificacion_area as justificacion', 
                    DB::raw('DATE_FORMAT(pla_reforma.updated_at, "%Y-%m-%d") as fecha'), 
                    'pla_reforma.estado', 
                    'pla_reforma.tipo', 
                    'area.nombre as area',
                    'pla_reforma.total as total_monto'
                )
                ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_reforma.area_id')
                ->whereNotIn('pla_reforma.estado', ['E']);
        
            // Aplicar filtros si existen
            if (!empty($estado)) {
                $query->where('pla_reforma.estado', $estado);
            }
        
            if (!empty($tipo)) {
                $query->where('pla_reforma.tipo', $tipo); // Corregido alias de tabla
            }

            if (!empty($direccion)) {
                $query->where('pla_reforma.area_id', $direccion); // Corregido alias de tabla
            }
        
            return datatables()->of($query->get())
                ->addIndexColumn()
                ->make(true);
        }

        return view('planificacion.index_reforma_principal', compact('direcciones'));
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
        ,'usuarios','atributos', 'tipos', 'item_presupuestario', 'id_fuente', 'direcciones', 'id_direccion'));
    }



    public function getAreas($czonal_id){
        // Obtener áreas asociadas con el czonal_id
        $areas = Area::where('czonal_id', $czonal_id)->get();

        // Devolver las áreas en formato JSON
        return response()->json($areas);
    }



    public function TblActArea(Request $request){

        //$anio = date('Y');

        $area_id = $request->input('id'); // Obtener el id del área de la solicitud}
        $id_poa  = $request->input('id_poa'); //Obtener el id de la actividad (POA) de la solicitud
        $id_sub  = $request->input('id_sub'); 

        $actividades='';

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
                //->where('pla_poa1.año', '=', $anio)
                ->whereNotIn('pla_poa1.estado', ['E'])
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
                //->where('pla_poa1.año', '=', $anio)
                ->whereNotIn('pla_poa1.estado', ['E']);

            if (!empty($id_sub)) {
                $atributostblArea->where('pla_sub_actividad.id', $id_sub);
            }
            $atributostblArea = $atributostblArea->get();

            $actividades = DB::table('db_inspi_planificacion.pla_poa1')
                ->select('pla_sub_actividad.nombre as nombreSubActividad', 'pla_sub_actividad.id as id')
                ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
                ->where('pla_poa1.id_area', '=', $area_id)
                //->where('pla_poa1.año', '=', $anio)
                ->whereNotIn('pla_poa1.estado', ['E'])
                ->get();

        }

        // Aquí debes ajustar la consulta para obtener los datos según el área seleccionada
        return response()->json(['success' => true, 'data' => $atributostblArea, 'actividades' => $actividades], 200);
        //return response()->json($atributostblArea);
    }






    public function saveReforma(Request $request){
        $data = $request->validate([
            'formData'      => 'required|array', // Validar que 'datos' sea un array requerido
            //'justificacion' => 'required|string', // Validar que 'justificacion' sea una cadena requerida
            'justifi'       => 'required|string', // Validar que 'justificacion del área requirente' sea una cadena requerida
            'tipo_refor'    => 'required|string'
        ]);

        $formData      = $request->input('formData');
        //$justificacion = $data['justificacion']; // Obtener la justificación del formulario
        $justifi       = $request['justifi']; // Obtener la justificación del área requirente del formulario
        $tipo_refor    = $request['tipo_refor'];


        // ========= Obtener datos de dirección usando la función del Trait(Inicio)
        $direccionData = $this->obtenerDireccion();

        if (!$direccionData) {
            return response()->json(['error' => 'No se encontró la dirección'], 404);
        }
        $id_direccion = $direccionData['id_direccion'];
        // ========= Obtener datos de dirección usando la función del Trait(Fin)

        $fecha = date('Y-m-d H:i:s');

        try {

            $nro_reforma = $this->actualizarContadorRef($tipo_refor);
            // Calcular el siguiente número de solicitud
            $ultimoNroSolicitud = Reforma::max('nro_solicitud');
            $nro_solicitud = $ultimoNroSolicitud ? $ultimoNroSolicitud + 1 : 1;

            $reforma = new Reforma();
            $reforma->nro_solicitud = $nro_solicitud;
            $reforma->nro_reforma   = $nro_reforma;
            $reforma->justificacion = '';
            $reforma->justificacion_area = $justifi;
            $reforma->area_id       = $id_direccion;
            $reforma->estado        = 'A';
            $reforma->tipo          = $tipo_refor;
            $reforma->save();

            $id_reforma = $reforma->id;

            $contador_total = 0;

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

                if($datos['tipo'] == 'IGUAL'){

                    $calendario = new CalendarioReforma([
                        'id_poa'       => $id_poa,
                        'id_actividad' => $id_actividad ,
                        'tipo'         => $datos['tipo'],
                        'enero'        => 0,
                        'febrero'      => 0,
                        'marzo'        => 0,
                        'abril'        => 0,
                        'mayo'         => 0,
                        'junio'        => 0,
                        'julio'        => 0,
                        'agosto'       => 0,
                        'septiembre'   => 0,
                        'octubre'      => 0,
                        'noviembre'    => 0,
                        'diciembre'    => 0,
                        'total'        => 0,
                        'estado'       => $datos['estado'],
                        // 'estado' => 'A', // Suponiendo que 'A' es para estado activo
                    ]);

                    $contador_total = '0.00';

                }else{

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

                    if($datos['tipo'] == 'AUMENTA' || $datos['tipo'] == 'AJUSTE'|| $datos['tipo'] == 'AMPLIA'){
                        $contador_total += $datos['total'];
                    }

                }

                // Guardar el calendario de reforma
                $calendario->save();



                //$poa = Poa::find($act->id_poa1);
                /*
                if ($poa && $poa->monto == 0) {
                    $poa->monto = $datos['total'];
                    $poa->save();
                }
                */

                //si la actividad es prestada, se crea una solicitud
                if($datos['solicitud'] == 'false'){

                    $sol = new Solicitud;
                    $sol->id_poa              = $id_poa;
                    $sol->id_actividad        = $id_actividad;
                    $sol->id_area_solicitante = $id_direccion;
                    $sol->id_area_propietaria = $datos['id_area_soli'];
                    $sol->estado_solicitud    = 'pendiente';
                    $sol->fecha_solicitud     = $fecha;
                    $sol->save();

                }

            }


            //$reforma = Reforma::find($id_reforma);
            $reforma->total = $contador_total;
            $reforma->save();

            // Agregar comentario a la tabla pla_comentarios_reforma
            $comentario = new ComentarioReforma();
            $comentario->id_reforma = $id_reforma;
            $comentario->id_usuario = Auth::id();
            $comentario->comentario = $justifi;
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


    //trae la actividad en la ventana de edicción
    public function crearActArea(Request $request){

        // Valida los datos entrantes (opcional, pero recomendado)
        $datos = $request->validate([
            'id_poa'     => 'required|integer',
            'id_reforma' => 'required|integer',
        ]);

        $id_poa     = $datos['id_poa']; // Obtener el id_poa de la fila actual
        $id_reforma = $datos['id_reforma'];

        $sub_Actividad = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_sub_actividad.nombre as nombreSubActividad')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->where('pla_poa1.id','=',$id_poa)
            ->first();


        /*
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
        */

        $atributos = DB::table('db_inspi_planificacion.pla_poa1')
            ->select('pla_poa1.id as id', 'pla_actividad_operativa.nombre as nombreActividadOperativa',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem','pla_poa1.id_area as id_areaS',
            'pla_calendario.enero', 'pla_calendario.febrero', 'pla_calendario.marzo', 'pla_calendario.abril', 
            'pla_calendario.mayo', 'pla_calendario.junio', 'pla_calendario.julio', 'pla_calendario.agosto', 
            'pla_calendario.septiembre', 'pla_calendario.octubre', 'pla_calendario.noviembre', 'pla_calendario.diciembre',
            'pla_calendario.total'
            )
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_calendario', 'pla_poa1.id', '=', 'pla_calendario.id_poa')

            ->where('pla_poa1.id','=',$id_poa)
            ->first();
 

        // (Opcional) Puedes retornar una respuesta o hacer algo más con el objeto Poa
        return response()->json([
            'success' => true,
            'actividadPoa' => [
                //'id' => $actividad->id,
                'id' => 0,
                'id_poa' => $atributos->id,
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
        $tipo_refor = $reforma->tipo;

        $atributos = DB::table('db_inspi_planificacion.pla_actividad')
            ->select(
                'pla_actividad.id as id_actividad',
                'pla_poa1.id as id_poa',
                'pla_poa1.id_area as id_areaS',
                'pla_poa1.departamento as departamento',
                'pla_actividad_operativa.nombre as nombreActividadOperativa',
                'pla_actividad.sub_actividad as nombreSubActividad',
                'pla_item_presupuestario.nombre as nombreItem',
                'pla_item_presupuestario.descripcion as descripcionItem',
                DB::raw('DATE_FORMAT(pla_actividad.created_at, "%Y-%m-%d") as fecha_sol'),
                DB::raw('DATE_FORMAT(pla_actividad.updated_at, "%Y-%m-%d") as fecha_apr'),
                'pla_actividad.created_at as fecha',
                'pla_calendario_ref.tipo',
                'pla_actividad.id as id_actividad',
                'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_calendario_ref.marzo',
                'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio',
                'pla_calendario_ref.julio', 'pla_calendario_ref.agosto', 'pla_calendario_ref.septiembre',
                'pla_calendario_ref.octubre', 'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre',
                'pla_calendario_ref.total',
                'pla_poa1.id_item as id_item',
                'pla_item_presupuestario.nombre as nombreItem',
                'pla_item_presupuestario.descripcion as descripcionItem',
                'pla_item_presupuestario.monto as montoItem',
                'pla_reforma.justificacion as justificacion_reforma',
            )
            ->join('db_inspi_planificacion.pla_reforma', 'pla_actividad.id_reforma', '=', 'pla_reforma.id')
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
            ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_reforma.id', '=', $id)
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

        $direcciones   = MontoDireccion::select('*')->whereIn('estado', ['A'])->get();

        //respuesta para la vista
        return view('planificacion.editar_reforma', compact('tipo_Poa','obj_Operativo', 'id_fuente', 'proceso'
            ,'usuarios','atributos', 'id', 'item_presupuestario', 'tipos', 'nombre', 'justificacion_area'
            , 'comentarios', 'direcciones', 'id_direccion', 'tipo_refor'));
    }




    public function actualizaContadorRef($tipoAnterior, $tipoNuevo, $nroActual) {
        $anioActual = date('Y');
        $estadoActivo = 'A';
        $nuevoNumero = $nroActual; // Mantener el número actual por defecto
    
        // Si el tipo de reforma ha cambiado
        if ($tipoAnterior != $tipoNuevo) {
            if ($tipoAnterior == 'R' && $tipoNuevo == 'M') {
                // Si era R y ahora es M, disminuir en 1 y guardar en 0
                $contador = ContadorRef::where('tipo', 'R')
                    ->where('anio', $anioActual)
                    ->where('estado', $estadoActivo)
                    ->first();
    
                if ($contador && $contador->valor > 0) {
                    $contador->decrement('valor');
                }
    
                $nuevoNumero = 0; // Se guarda como 0
            } elseif ($tipoAnterior == 'M' && $tipoNuevo == 'R') {
                // Si era M y ahora es R, aumentar en 1
                $contador = ContadorRef::where('tipo', 'R')
                    ->where('anio', $anioActual)
                    ->where('estado', $estadoActivo)
                    ->first();
    
                if ($contador) {
                    $contador->increment('valor');
                    $nuevoNumero = $contador->valor;
                } else {
                    // Si no existe, se crea con valor 1
                    $contador = ContadorRef::create([
                        'tipo' => 'R',
                        'anio' => $anioActual,
                        'valor' => 1,
                        'estado' => $estadoActivo,
                    ]);
                    $nuevoNumero = 1;
                }
            }
        }
    
        return $nuevoNumero;
    }
    
    




    public function actualizarReforma(Request $request, $id){
        $data = $request->validate([
            'formData'      => 'required|array',
            'justificacion' => 'required|string',
            'justifi'       => 'required|string',
            'id_direccion'  => 'required|string',
            'tipo_refor'    => 'required|string'
        ]);

        $formData      = $request->input('formData');
        $justificacion = $data['justificacion'];
        $justifi       = $data['justifi']; 
        $id_direccion  = $data['id_direccion']; 
        $tipo_refor    = $data['tipo_refor'];
        $fecha         = date('Y-m-d H:i:s');

        try {
            // DB::beginTransaction();

            // Actualizar la reforma principal
            $reforma = Reforma::findOrFail($id);

            // Obtener el tipo anterior antes de actualizarlo
            $tipoAnterior = $reforma->tipo;
            $nroActual    = $reforma->nro_reforma;

            // Obtener el nuevo número de reforma sin perder el actual si el tipo sigue siendo 'R'
            $nro_reforma = $this->actualizaContadorRef($tipoAnterior, $tipo_refor, $nroActual);

            $reforma->justificacion      = $justificacion;
            $reforma->justificacion_area = $justifi;
            $reforma->tipo               = $tipo_refor;
            $reforma->nro_reforma        = $nro_reforma;

            if ($reforma->estado === 'R') {
                // Cambiar el estado a "Corregido"
                $reforma->estado = 'C';
            }
            $reforma->save();

            $contador_total = 0;

            // Actualizar o crear actividades y calendario de reforma
            foreach ($formData as $datos) {

                if($datos['estado'] == 'A'){

                    $actividad = Actividad::where('id_reforma', $id)
                        ->where('id', $datos['id_actividad'])
                        ->first();

                    if (!$actividad) {
                        $actividad = new Actividad();
                        $actividad->id_reforma    = $id;
                        $actividad->id_poa1       = $datos['id_poa'];
                        $actividad->sub_actividad = $datos['subActividad'];
                        $actividad->estado        = 'A';
                        $actividad->save();

                    }else{
                        $actividad->sub_actividad = $datos['subActividad'];
                        $actividad->estado        = $datos['estado'];
                        $actividad->save();
                    }

                    if($datos['tipo'] == 'IGUAL'){

                        $calendario = CalendarioReforma::updateOrCreate(
                            ['id_actividad'  => $actividad->id],
                            [
                                'tipo'       => $datos['tipo'],
                                'enero'      => 0,
                                'febrero'    => 0,
                                'marzo'      => 0,
                                'abril'      => 0,
                                'mayo'       => 0,
                                'junio'      => 0,
                                'julio'      => 0,
                                'agosto'     => 0,
                                'septiembre' => 0,
                                'octubre'    => 0,
                                'noviembre'  => 0,
                                'diciembre'  => 0,
                                'total'      => 0,
                                'estado'     => $datos['estado'],
                                'id_poa'     => $datos['id_poa'],
                            ]
                        );
    
                        $contador_total = '0.00';

                    }else{

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
                                'id_poa'     => $datos['id_poa'],
                            ]
                        );

                        if($datos['tipo'] == 'AUMENTA' || $datos['tipo'] == 'AJUSTE'){
                            $contador_total += $datos['total'];
                        }
    
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

                    }

    
                    $poa = Poa::find($actividad->id_poa1);
                    
                    if ($poa && $poa->monto == 0) {
                        $poa->monto = $datos['total'];
                        $poa->save();
                    }

                    //para las actividades solicitadas que fueron agregadas
                    if($datos['estado'] == 'A' && $datos['solicitud'] == 'false'){

                        $solicitudExistente = Solicitud::where('id_actividad', $actividad->id)->first();

                        //si la solicitud ya existe, no la vuelve a crear
                        if (!$solicitudExistente) {

                            $solicitudModel2 = new Solicitud();
                            $solicitudModel2->id_actividad        = $actividad->id;
                            $solicitudModel2->id_poa              = $actividad->id_poa1;
                            $solicitudModel2->id_area_solicitante = $id_direccion;
                            $solicitudModel2->id_area_propietaria = $datos['id_area_soli'];
                            $solicitudModel2->estado_solicitud    = 'pendiente';
                            $solicitudModel2->fecha_solicitud     = $fecha;
                            $solicitudModel2->save();

                        }

                    }

                }else{// en caso de que la actividad sea eliminada

                    if($datos['id_actividad'] != 0){

                        $actividad = Actividad::where('id_reforma', $id)
                            ->where('id', $datos['id_actividad'])
                            ->first();

                        if ($actividad) {
                            $actividad->sub_actividad = $datos['subActividad'];
                            $actividad->estado        = $datos['estado'];
                            $actividad->save();
                        }

                        if($datos['estado'] == 'E' && $datos['solicitud'] == 'false'){
                         
                            $solicitudModel1 = Solicitud::where('id_actividad', $datos['id_actividad'])->first();
                            if ($solicitudModel1) {
                                $solicitudModel1->estado = 'E';
                                $solicitudModel1->save();
                            }   
                            
                        }

                    }

                }

            }

            $reforma->total = $contador_total;
            $reforma->save();

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

            return response()->json(['message' => 'Reforma actualizada correctamente', 'success' => true ], 200);
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


            $id_obj_operativo   = $request->input('obOpera');

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
            $actividad->sub_actividad = $nombreSubActividad;
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
                    'id_area_soli'             => $id_direccion,
                    'id_poa'                   => $poa->id,
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
            ->select('pla_actividad.id as id_actividad', 'pla_actividad.sub_actividad', 'pla_direcciones.nombre as direccion',
            DB::raw('DATE_FORMAT(pla_actividad.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_actividad.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_actividad.created_at as fecha', 'pla_actividad_operativa.nombre as nombreActividadOperativa', 'pla_calendario_ref.tipo',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_calendario_ref.marzo',
            'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio', 'pla_calendario_ref.julio', 'pla_calendario_ref.agosto',
            'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre', 'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre',
            'pla_calendario_ref.total', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem',
            'pla_reforma.justificacion as justificacion_reforma', 'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 
            'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad', 'pla_fuente.nombre as fuente')
            ->join('db_inspi_planificacion.pla_reforma', 'pla_actividad.id_reforma', '=', 'pla_reforma.id')
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
            ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')

            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_direcciones', 'pla_poa1.id_area', '=', 'pla_direcciones.id')

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



    public function verReforma(Request $request, $id){

        $atributos = DB::table('db_inspi_planificacion.pla_actividad')
            ->select('pla_actividad.id as id_actividad', 'pla_actividad.sub_actividad', 'pla_direcciones.nombre as direccion',
            DB::raw('DATE_FORMAT(pla_actividad.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_actividad.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_actividad.created_at as fecha', 'pla_actividad_operativa.nombre as nombreActividadOperativa', 'pla_calendario_ref.tipo',
            'pla_sub_actividad.nombre as nombreSubActividad', 'pla_calendario_ref.enero', 'pla_calendario_ref.febrero', 'pla_calendario_ref.marzo',
            'pla_calendario_ref.abril', 'pla_calendario_ref.mayo', 'pla_calendario_ref.junio', 'pla_calendario_ref.julio', 'pla_calendario_ref.agosto',
            'pla_calendario_ref.septiembre', 'pla_calendario_ref.octubre', 'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre',
            'pla_calendario_ref.total', 'pla_poa1.id_item as id_item', 'pla_item_presupuestario.nombre as nombreItem',
            'pla_item_presupuestario.descripcion as descripcionItem', 'pla_item_presupuestario.monto as montoItem',
            'pla_reforma.justificacion as justificacion_reforma', 'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 
            'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad', 'pla_fuente.nombre as fuente')
            ->join('db_inspi_planificacion.pla_reforma', 'pla_actividad.id_reforma', '=', 'pla_reforma.id')
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
            ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')

            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_direcciones', 'pla_poa1.id_area', '=', 'pla_direcciones.id')

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
        return view('planificacion.ver_reforma', compact('atributos', 'id', 'comentarios', 'justifi'));

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


        // Llamar a actualizarCalendarioPoa si la reforma es aprobada ('O') y es una Modificación
        if ($estadoReforma == 'O' && $reforma->tipo == 'M') {
            $requestCalendario = new Request([
                'id_reforma'    => $id_reforma,
                'estadoReforma' => $estadoReforma,
                'justificacion' => $justificacion_Reforma
            ]);

            // Llamar a la función directamente dentro del mismo controlador
            $this->actualizarCalendarioPoa($requestCalendario);
        }


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
                'pla_calendario_ref.noviembre', 'pla_calendario_ref.diciembre', 'pla_calendario_ref.total', 'pla_actividad.estado', 'pla_calendario_ref.tipo',
                'poa.id_area')
                ->join('db_inspi_planificacion.pla_calendario_ref as pla_calendario_ref', 'pla_calendario_ref.id_actividad', '=', 'pla_actividad.id')
                ->join('db_inspi_planificacion.pla_poa1 as poa', 'poa.id', '=', 'pla_actividad.id_poa1')
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
                          ->whereColumn('pla_solicitud.id_actividad', 'pla_actividad.id')
                          ->whereIn('pla_solicitud.estado_solicitud', ['pendiente', 'rechazado'])
                          ->where('pla_solicitud.estado', 'A');
                })
                ->get();

            if ($actividadesVal->isNotEmpty()) {
                return response()->json(['message' => 'No se puede validar la reforma porque una actividad no fue aprobada por el área requirente.', 'valor' => false], 200);
            }else{

                foreach ($actividades as $actividad) {
                    $id_poa  = $actividad->id_poa1;  // Asumimos que id_poa1 es la relación con POA
                    $tipo    = $actividad->tipo;
                    $id_area = $actividad->id_area;

                    // Obtener los registros de la tabla pla_calendario para este id_poa
                    $calendarioPoa = Calendario::where('id_poa', $id_poa)->first();
                    $poaActividad  = Poa::where('id', $id_poa)->first();
                    $comentarioPOA = Comentario::where('id', $id_poa)->first();
                    $subActividad  = SubActividad::where('id', $poaActividad->id_sub_actividad)->first();

                    $numAreas = $actividades->pluck('id_area')->unique()->count();
                    $multipleAreas = $numAreas > 1;

                    if ($calendarioPoa) {

                        if($actividad->estado == 'E'){

                            /*
                            $poaActividad->update([
                                'estado' => $actividad->estado,
                            ]);
                            $calendarioPoa->update([
                                'estado' => $actividad->estado,
                            ]);
                            */

                        }else{

                            //actualiza item y historial
                            $itemPre = ItemPresupuestario::find($poaActividad->id_item);
                            $itemDir = ItemDireccion::find($poaActividad->id_item_dir);
                            if ($itemPre) {

                                if($tipo == 'AUMENTA'){
                                    $tipo = 'I';
                                    $monto = $itemDir->monto + $actividad->total;

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

                                    $poaActividad->update([
                                        //'estado'  => 'O',
                                        'monto'   => $poaActividad->monto + $actividad->total,
                                        //'nro_poa' => $nuevoNroPoa,
                                    ]);

                                    $calendarioPoa->actualizaTotal();

                                }else if($tipo == 'AJUSTE'){

                                    $tipo = 'A';
                                    $monto = $itemDir->monto - $actividad->total;

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

                                    $poaActividad->update([
                                        //'estado'  => 'O',
                                        'monto'   => $poaActividad->monto - $actividad->total,
                                        //'nro_poa' => $nuevoNroPoa,
                                    ]);

                                    $calendarioPoa->actualizaTotal();

                                }else if($tipo == 'AMPLIA'){

                                    $tipo = 'A';
                                    $monto = $itemDir->monto + $actividad->total;

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

                                    $poaActividad->update([
                                        //'estado'  => 'O',
                                        'monto'   => $poaActividad->monto + $actividad->total,
                                        //'nro_poa' => $nuevoNroPoa,
                                    ]);

                                    $calendarioPoa->actualizaTotal();

                                }else{
                                    $tipo = 'E';
                                    $monto = $itemDir->monto - $actividad->total;

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

                                    $poaActividad->update([
                                        //'estado'  => 'O',
                                        'monto'   => $poaActividad->monto - $actividad->total,
                                        //'nro_poa' => $nuevoNroPoa,
                                    ]);
                                }

                                $itemDir->monto = $monto;

                                //actualiza el movimiento del item
                                $itemPre->monto = $monto;
                                $itemPre->save();

                                $itemDir->save();

                                //actualizo los estados anteriores
                                ConsumoItem::actualizarEstadosPorIdItem($poaActividad->id_item);

                                $fecha = date('Y-m-d H:i:s');
                                $anio  = date('Y');

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


                                // Si tiene más de una dirección, se aumenta o reduce el valor de la dirección y del ítem presupuestario
                                if ($tipo == 'I' && $multipleAreas) { // Si hay más de un área

                                    $direccion = MontoDireccion::find($id_area);
                                    if ($direccion) {
                                        $direccion->monto += $actividad->total; // Sumar correctamente
                                        $direccion->save();
                                    }

                                } else if ($tipo == 'E' && $multipleAreas) {

                                    $direccion = MontoDireccion::find($id_area);
                                    if ($direccion) {
                                        $direccion->monto -= $actividad->total; // Restar correctamente
                                        $direccion->save();
                                    }

                                }


                            }

                            // Si el estado es "O" (Aprobado), asignar el siguiente número de POA secuencial
                            //$ultimoNroPoa = Poa::where('estado', 'O')->max('nro_poa');
                            //$nuevoNroPoa = $ultimoNroPoa ? $ultimoNroPoa + 1 : 1;


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

        $atributos = DB::table('db_inspi_planificacion.pla_reforma')
            ->select('pla_reforma.id as id', 'pla_reforma.nro_solicitud as numero', 'pla_reforma.nro_reforma as nro_reforma',
            DB::raw('DATE_FORMAT(pla_reforma.created_at, "%Y-%m-%d") as fecha_sol'),
            DB::raw('DATE_FORMAT(pla_reforma.updated_at, "%Y-%m-%d") as fecha_apr'),
            'pla_reforma.fecha as fecha', 'pla_reforma.justificacion as justificacion', 'pla_reforma.justificacion_area as justificacion_area',
            'pla_direcciones.nombre as area')
            ->join('db_inspi_planificacion.pla_direcciones', 'pla_reforma.area_id', '=', 'pla_direcciones.id')
            ->where('pla_reforma.id',"=", $id_reforma)
            ->first();

        $reforma = Reforma::where('id', $id_reforma)->first();

        if($reforma->estado == 'O'){

            // Obtener todas las actividades relacionadas con esta reforma
            $actividades = DB::table('db_inspi_planificacion.pla_reforma')
                ->select(
                    'pla_reforma.id as id', 'pla_actividad_operativa.nombre as actividad_operativa', 'pla_actividad.sub_actividad as sub_actividad',
                    'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
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

        }else{

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

        }

        
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

        $solicitud = Solicitud::select('area.nombre as solicitante', 'areaS.nombre as propietario', 'pla_solicitud.fecha_solicitud as fecha', 'pla_solicitud.id_actividad',
            'pla_solicitud.id_poa')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_solicitud.id_area_solicitante')
            ->join('db_inspi_planificacion.pla_direcciones as areaS', 'areaS.id', '=', 'pla_solicitud.id_area_propietaria') 
            ->where('pla_solicitud.id', $id_solicitud)->first();

        /*
        $valores = DB::table('db_inspi_planificacion.pla_poa1')
            ->select(
                'pla_poa1.id as id',
                'pla_sub_actividad.nombre as sub_actividad',
                DB::raw("'IGUAL' as tipo"),
                'pla_poa1.monto as disponible',
                DB::raw("0 as total"),
                'pla_poa1.departamento as departamento',
                'pla_item_presupuestario.nombre as item'
            )
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->where('pla_poa1.id', $solicitud->id_poa);
        */
        
        $valoresSoli = DB::table('db_inspi_planificacion.pla_actividad')
            ->select(
                'pla_actividad.id as id',
                'pla_actividad.sub_actividad as sub_actividad',
                'pla_calendario_ref.tipo as tipo',
                'pla_poa1.monto as disponible',
                'pla_calendario_ref.total',
                'pla_poa1.departamento as departamento',
                'pla_item_presupuestario.nombre as item'
            )
            ->join('db_inspi_planificacion.pla_calendario_ref', 'pla_actividad.id', '=', 'pla_calendario_ref.id_actividad')
            ->join('db_inspi_planificacion.pla_solicitud as sol', 'sol.id_actividad', '=', 'pla_actividad.id')
            ->join('db_inspi_planificacion.pla_poa1', 'pla_actividad.id_poa1', '=', 'pla_poa1.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            //->join('db_inspi_planificacion.pla_direcciones', 'pla_direcciones.id', '=', $solicitud->id_area_solicitante)
            ->where('sol.id', $id_solicitud)
            ->where('sol.estado_solicitud', 'pendiente')
            //->union($valores) // Unimos la primera consulta
            ->get(); // Obtenemos los resultados
        
        

        if ($valoresSoli) {

            return response()->json(['message' => 'La lista se cargo Correctamente','valoresSoli' => $valoresSoli, 
                'solicitud' => $solicitud, 'data' => true], 200);

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
        $filterAnio    = $request->input('filterAnio');
        $item          = $request->input('filterItem');
        $sub_actividad = $request->input('filterSubActividad');
        
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

        if (!empty($item)) {
            $query->where('pla_poa1.id_item', $item);
        }

        if (!empty($sub_actividad)) {
            $query->where('pla_poa1.id_sub_actividad', $sub_actividad);
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
                'pla_tipo_poa.nombre as tipoPoa', 'pro.nombre as proceso', 'area.nombre as direccion', 'pla_poa1.plurianual'
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



    //Excel Direcciones
    public function reportDetalleExcelUser(Request $request)
    {
        $filterAnio         = $request->input('filterAnio');
        $filterItem         = $request->input('filterItem');
        $filterSubActividad = $request->input('filterSubActividad');
        $id_direccion       = $request->input('id_direccion');

        // Construir el query base
        $query = DB::table('db_inspi_planificacion.pla_poa1')
            ->select(
                'pla_poa1.id as id', 'pla_actividad_operativa.nombre as actividad_operativa', 'pla_obj_operativo.nombre as objOperativo',
                'pla_sub_actividad.nombre as sub_actividad', 'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
                'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
                'pla_fuente.nombre as fuente', 'pla_calendario.enero as enero', 'pla_calendario.febrero as febrero', 'pla_calendario.marzo as marzo', 'pla_calendario.abril as abril',
                'pla_calendario.mayo as mayo', 'pla_calendario.junio as junio', 'pla_calendario.julio as julio', 'pla_calendario.agosto as agosto', 'pla_calendario.septiembre as septiembre',
                'pla_calendario.octubre as octubre', 'pla_calendario.noviembre as noviembre', 'pla_calendario.diciembre as diciembre', 'pla_poa1.monto as total', 'pla_tipo_monto.nombre as frecuencia',
                'pla_tipo_poa.nombre as tipoPoa', 'pro.nombre as proceso', 'area.nombre as direccion', 'pla_poa1.plurianual'
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
            ->where('area.id', $id_direccion)
            ->whereNotIn('pla_poa1.estado', ['E']);

        // Aplicar los filtros condicionalmente
        if (!empty($filterAnio)) {
            $query->where('pla_poa1.año', $filterAnio);
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

    }


    //Excel
    public function reportPOAExcel(Request $request)
    {
        //$filterEstado  = $request->input('filterEstado');
        $filterDireccion = $request->input('filterDireccion');
        $filterItem      = $request->input('filterItem');
        $programa        = $request->input('filterPrograma');

        if ($programa) {
            $programaIds = Programa::where('nombre', $programa)->pluck('id');
        } else {
            $programaIds = null;
        }

        $filterAnio = date("Y");

        // Construir el query base
        $query = DB::table('db_inspi_planificacion.pla_poa1')
            ->select(
                'pla_poa1.id as id', 'pla_actividad_operativa.nombre as actividad_operativa', 'pla_obj_operativo.nombre as objOperativo',
                'pla_sub_actividad.nombre as sub_actividad', 'pla_item_presupuestario.nombre as item_presupuestario', 'pla_item_presupuestario.descripcion as descripcion_item',
                'pla_unidad_ejecutora.nombre as u_ejecutora', 'pla_programa.nombre as programa', 'pla_proyecto.nombre as proyecto', 'pla_actividad_act.nombre as actividad',
                'pla_fuente.nombre as fuente', 'pla_poa1.monto as total',  'pla_poa1.monto_certificado as certificado', 'pla_poa1.nro_poa as nro_poa',
                'pla_tipo_poa.nombre as tipoPoa', 'pro.nombre as proceso', 'area.nombre as direccion', 'pla_poa1.plurianual'
            )
            ->join('db_inspi_planificacion.pla_tipo_poa', 'pla_poa1.id_tipo_poa', '=', 'pla_tipo_poa.id')
            ->join('db_inspi_planificacion.pla_direcciones as area', 'area.id', '=', 'pla_poa1.id_area')
            ->join('db_inspi_planificacion.pla_unidad_ejecutora', 'pla_poa1.u_ejecutora', '=', 'pla_unidad_ejecutora.id')
            ->join('db_inspi_planificacion.pla_programa', 'pla_poa1.programa', '=', 'pla_programa.id')
            ->join('db_inspi_planificacion.pla_proyecto', 'pla_poa1.proyecto', '=', 'pla_proyecto.id')
            ->join('db_inspi_planificacion.pla_actividad_act', 'pla_poa1.actividad', '=', 'pla_actividad_act.id')
            ->join('db_inspi_planificacion.pla_fuente', 'pla_poa1.fuente', '=', 'pla_fuente.id')
            ->join('db_inspi_planificacion.pla_actividad_operativa', 'pla_poa1.id_actividad', '=', 'pla_actividad_operativa.id')
            ->join('db_inspi_planificacion.pla_sub_actividad', 'pla_poa1.id_sub_actividad', '=', 'pla_sub_actividad.id')
            ->join('db_inspi_planificacion.pla_item_presupuestario', 'pla_poa1.id_item', '=', 'pla_item_presupuestario.id')
            ->join('db_inspi_planificacion.pla_obj_operativo', 'pla_poa1.id_obj_operativo', '=', 'pla_obj_operativo.id')
            ->join('db_inspi_planificacion.pla_tipo_proceso as pro', 'pro.id', '=', 'pla_poa1.id_proceso')
            ->whereNotIn('pla_poa1.id_area', [17, 18])
            ->where('pla_poa1.estado', ['O']);

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

        if (!empty($programaIds)) {
            $query->whereIn('pla_poa1.programa', $programaIds);
        }

        // Ejecutar el query
        $actividades = $query->get();

        return Excel::download(new ReportPOAExport($actividades), 'reporte_detalle.xlsx');

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
            'certificado'  => 'required|string',
        ]);

        $fecha = date('Y-m-d');

        $id_poa  = $request->input('solicitud_id');
        $justifi = $request->input('justifi');
        $certificado = $request->input('certificado');

        $poa = Poa::find($id_poa);
        $poa->estado = 'S';
        $poa->fecha  = $fecha;
        $poa->monto_certificado  = $certificado;
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


    function actualizarContador($zonal) {
        $anioActual = date('Y'); // Obtener el año actual
        $estadoActivo = 'A';
        
        // Consulta para verificar si ya existe un registro para el zonal y año actual
        $registroExistente = Contador::where('zonal', $zonal)
            ->where('anio', $anioActual)
            ->where('estado', $estadoActivo)
            ->first();
        
        if ($registroExistente) {
            // Si existe, incrementar el valor del contador
            $registroExistente->increment('valor');
            $numero = $registroExistente->valor; // Obtener el valor actualizado
        } else {
            // Si no existe, crear un nuevo registro empezando con 1
            $contador = Contador::create([
                'zonal' => $zonal,
                'anio' => $anioActual,
                'valor' => 1,
                'estado' => $estadoActivo,
            ]);
    
            $numero = $contador->valor; // Valor inicial del nuevo registro
        }
    
        return $numero;
    }




    function actualizarContadorRef($tipo) {
        if ($tipo !== 'R') {
            return 0; // Si el tipo no es "R", devolver 0 inmediatamente
        }
    
        $anioActual = date('Y'); // Obtener el año actual
        $estadoActivo = 'A';
        
        // Consulta para verificar si ya existe un registro para el tipo "R" en el año actual
        $registroExistente = ContadorRef::where('tipo', $tipo)
            ->where('anio', $anioActual)
            ->where('estado', $estadoActivo)
            ->first();
        
        if ($registroExistente) {
            // Si existe, incrementar el valor del contador y devolverlo
            $registroExistente->increment('valor');
            return $registroExistente->valor; // Retorna el valor actualizado
        } 
    
        // Si no existe, crear un nuevo registro con valor 1
        $contador = ContadorRef::create([
            'tipo' => $tipo,
            'anio' => $anioActual,
            'valor' => 1,
            'estado' => $estadoActivo,
        ]);
    
        return $contador->valor; // Retorna 1 ya que es el primer registro
    }


    //respuesta para la vista crear
    public function reportFormulario_Crear(){

        return view('planificacion.reportFormulario_Crear');
    }


    public function crear_usuarios(Request $request)
   {
       try {
           $data = $request->validate([
               'nombre'   => 'required|string',
               'apellido' => 'required|string',
               'correo'   => 'required|string',
               'telefono' => 'required|string',
           ]);
           
           $nombre   = $request->input('nombre');
           $apellido = $request->input('apellido');
           $correo   = $request->input('correo');
           $telefono = $request->input('telefono');
   
           $usuario = Formulario::create([
               'nombre'   => $nombre,
               'apellido' => $apellido,
               'correo'   => $correo,
               'telefono' => $telefono,
           ]);

            return response()->json(['success' => true, 'usuario' => $usuario], 200);
        
        } catch (\ValidationException $ve) {

            return response()->json(['success' => false, 'error' => $ve->getMessage()], 200);

        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 200);

        }
   
    }

    
    //respuesta para la vista editar
    public function reportFormulario_Editar($id){

        $datos = Formulario::find($id);

        $id        = $datos -> id;
        $nombre    = $datos -> nombre;
        $apellido  = $datos -> apellido;
        $correo    = $datos -> correo;
        $telefono  = $datos -> telefono;

       return view('planificacion.reportFormulario_Editar', compact('id', 'nombre', 'apellido', 'correo', 'telefono'));
       
   }
 

    public function editar_usuario(Request $request)
    {
        try {

            $data = $request->validate([
                'id'       => 'required|integer', 
                'nombre'   => 'required|string',
                'apellido' => 'required|string',
                'correo'   => 'required|email', 
                'telefono' => 'required|string',
            ]);

            $id = $data['id'];


            $usuario = Formulario::find($id);


            Log::info('ID recibido para edición:', ['id' => $id]);
            Log::info('Usuario encontrado:', ['usuario' => $usuario]);


            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado en la base de datos',
                    'id_recibido' => $id
                ], 404);
            }

            // Actualizar los datos del usuario
            $usuario->nombre = $data['nombre'];
            $usuario->apellido = $data['apellido'];
            $usuario->correo = $data['correo'];
            $usuario->telefono = $data['telefono'];
            $usuario->save();


            Log::info('Usuario actualizado correctamente:', ['usuario' => $usuario]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario editado correctamente',
                'data'    => $usuario
            ], 200);

        } catch (\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'error' => $ve->errors()
            ], 400);
        } catch (\Exception $e) {

            // Registrar en logs el error exacto
            Log::error('Error al editar usuario:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al editar usuario',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    //respuesta para la vista lista de usuario
    public function reportFormulario_ListaUsuario(){

        $Formularios = Formulario::all(); 
        
        return view('planificacion.reportFormulario_ListaUsuario', compact('Formularios'));
    }


   /* public function listar_usuario()
    {
        $Formularios = Formulario::all(); // Obtiene todos los registros de la tabla "formularios"
        
        return view('Formularios.index', compact('Formularios')); 
    }*/


}
