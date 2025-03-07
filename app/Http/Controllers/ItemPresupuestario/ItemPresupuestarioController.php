<?php

namespace App\Http\Controllers\ItemPresupuestario;

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

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

//ITEM PRESUPUESTARIO
use App\Models\ItemPresupuestario\ItemPresupuestario;
use App\Models\Planificacion\MontoDireccion\MontoDireccion;
use App\Models\Planificacion\ItemDireccion\ItemDireccion;

use App\Models\Planificacion\Poa1\Poa;

use App\Models\ConsumoItem\ConsumoItem;
use App\Models\RecursosHumanos\Filiacion;

//ESTRUCTURA PRESUPUESTARIA
use App\Models\Planificacion\UnidadEjecutora\UnidadEjecutora;
use App\Models\Planificacion\Programa\Programa;
use App\Models\Planificacion\Proyecto\Proyecto;
use App\Models\Planificacion\ActividadPre\ActividadPre;
use App\Models\Planificacion\Fuente\Fuente;

//PDF
use Barryvdh\DomPDF\Facade as PDF;

class ItemPresupuestarioController extends Controller{

    public function index(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        if(request()->ajax()) {

            return datatables()->of(ItemPresupuestario::select('pla_item_presupuestario.nombre as nombre',
            'pla_item_presupuestario.descripcion as descripcion',
            'pla_item_presupuestario.monto as monto',
            'pla_item_presupuestario.id as id',
            DB::raw('DATE_FORMAT(pla_item_presupuestario.created_at, "%Y-%m-%d %H:%i:%s") as fecha'))
            ->where('pla_item_presupuestario.estado', 'A')
            ->groupBy('id', 'pla_item_presupuestario.nombre', 'pla_item_presupuestario.descripcion', 
            'pla_item_presupuestario.monto', 'fecha')
            ->get() // Agrupar por todos los campos seleccionados
            )
            // ->where('users.id', '=', $id_usuario)
            ->addIndexColumn()
            ->make(true);
        }
        //respuesta para la vista
        return view('item_presupuestario.index');
    }



    /* GUARDAR ITEM PRESUPUESTARIO (MODAL EN INDEX)*/
    public function saveItemPres(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nameItem'    => 'required|string',
            'descripcion' => 'required|string',
            'montoItem'   => 'required|string',
            'estado'      => 'required|string',
        ]);

        $itemPresupuestario = itemPresupuestario::create([ //Guarda los datos de los campos en la base de datos
            'nombre'       => $request->nameItem,
            'descripcion'  => $request->descripcion,
            'monto'        => $request->montoItem,
            'estado'       => $request->estado,         
        ]);

        if ($itemPresupuestario) {

            return response()->json(['message' => 'Item guardado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear el item', 'data' => false], 500);

        }

    }
    /* GUARDAR ITEM PRESUPUESTARIO */

    //Eliminar ITEM PRESUPUESTARIO
    public function deleteItemP(Request $request)
    {
        $itemP = ItemPresupuestario::find($request->id); //Busca el registro por el ID

        if ($itemP) {

            $itemP->update([
                'estado' => 'E', //Asigna el estado "E" para no mostrarlo en la tabla
            ]);

            return response()->json(['message' => 'Registro eliminado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el registro', 'data' => false], 500);

        }

    }
    //Eliminar item presupuestario

    /* TRAER MUESTRA */
    public function obtenerItemP($id)
    {
        // Obtiene los datos previamente registrados
        $itemP = ItemPresupuestario::find($id);

        return response()->json(['itemP' => $itemP]);

    }
    /* TRAER MUESTRA */


    /* ACTUALIZAR ARTÍCULO */
    public function actualizarItemP(Request $request, $id) {
        //Actualiza los datos en la tabla
        $itemPresupuestario = itemPresupuestario::find($id);
        $itemPresupuestario->nombre       = $request->input('nombre');
        $itemPresupuestario->descripcion = $request->input('descripcion');
        $itemPresupuestario->monto      = $request->input('monto');

        $itemPresupuestario->save();
    
        return response()->json(['success' => true, 'message' => 'El item presupuestario se ha actualizado correctamente.']);
    }
    /* ACTUALIZAR ARTÍCULO */



    /* REINICIAR ITEMS PRESUPUESTARIOS */
    public function rebootItems()
    {
        // Se llama a la funcion para reiniciar los valores
        ItemPresupuestario::resetAllMontos();

        return response()->json(['valor' => true, 'message' => 'Los montes fueron reiniciados.'], 200);

    }
    /* REINICIAR ITEMS PRESUPUESTARIOS */


    /* TRAE EL HISTORIAL DE LOS ITEMS PRESUPUESTARIOS */
    public function traerHistorial(Request $request)
    {
        
        $id_item = $request->query('id_item');
        $anio    = $request->query('anio');

        $nombre = ItemPresupuestario::select('nombre', 'descripcion', 'monto_ini')->where('id', $id_item)->first();

        $historiales = ConsumoItem::select('actO.nombre as actOpera', 'sub.nombre as subActi', 'consumo_item.tipo as tipo'
            , 'consumo_item.monto_consumido as consumido', 'consumo_item.monto as monto', 'consumo_item.fecha as fecha')
            ->join('db_inspi.inspi_item_presupuestario as item', 'item.id', '=', 'db_inspi.consumo_item.id_item')
            ->join('db_inspi_planificacion.pla_poa1 as act', 'act.id', '=', 'consumo_item.id_actividad')
            ->join('db_inspi.inspi_actividad_operativa as actO', 'actO.id', '=', 'act.id_actividad')
            ->join('db_inspi.inspi_sub_actividad as sub', 'sub.id', '=', 'act.id_sub_actividad')
            ->where('item.id', '=', $id_item)
            ->where('consumo_item.anio', '=', $anio)
            ->get();

        if($historiales){

            return response()->json(['valor' => true, 'historiales' => $historiales, 'nombre' => $nombre->nombre.' - '.$nombre->descripcion, 'monto_ini' => $nombre->monto_ini], 200);

        }else{

            return response()->json(['valor' => false, 'message' => 'Error al cargar el historial.'], 500);

        }
        
    }
    /* TRAE EL HISTORIAL DE LOS ITEMS PRESUPUESTARIOS */




    /* ============================================ MONTO DIRECCION ============================================ */
    public function montoDireccion(Request $request)
    {
        $id_usuario = Auth::user()->id; // Trae el ID del usuario

        $montos = MontoDireccion::select(
            DB::raw('SUM(monto) AS total_monto_presupuestado'),
            DB::raw('COALESCE((SELECT SUM(monto) FROM pla_poa1 WHERE estado != "E"), 0) AS total_monto_direcciones'),
            DB::raw('COALESCE((SELECT SUM(monto) FROM pla_items_direcciones WHERE estado = "A"), 0) AS total_monto') 
        )
        ->where('estado', 'A')
        //->groupBy('monto')
        ->first();

        $montos->total_monto_presupuestado = number_format($montos->total_monto_presupuestado, 2);
        $montos->total_monto = number_format($montos->total_monto, 2);
        $montos->total_monto_direcciones = number_format($montos->total_monto_direcciones, 2);

        
        if (request()->ajax()) {
            return datatables()->of(MontoDireccion::select(
                'id',
                'id_dir',
                'descripcion',
                'estado',
                'proceso_estado',
                'id_dir_tec',
                'nombre',
                'monto',
                DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d %H:%i:%s") as fecha'),
                // Subconsulta para obtener el total_monto por id_area
                DB::raw('COALESCE((SELECT SUM(monto) FROM pla_poa1 WHERE id_area = pla_direcciones.id AND estado != "E"), 0) AS total_monto'),
                DB::raw('COALESCE((SELECT SUM(monto) FROM pla_items_direcciones WHERE id_direcciones = pla_direcciones.id AND estado != "E"), 0) AS total_monto_direcciones')           
                )
            ->where('estado', 'A')
            ->orderBy('nombre', 'asc')
            ->get())
            ->addIndexColumn()
            ->editColumn('monto', function($row) {
                // Formatear el monto con comas y 2 decimales
                return number_format($row->monto, 2, '.', ',');
            })
            ->make(true);
        }
        
    
        // Respuesta para la vista
        return view('item_presupuestario.monto_dir', compact('montos'));
    }
    


    /* TRAER DIRECCION POR ID */
    public function obtenerDireccionMonto($id)
    {
        // Obtiene los datos previamente registrados
        $itemP = MontoDireccion::find($id);

        return response()->json(['datos' => $itemP]);

    }
    /* TRAER DIRECCION POR ID */


    /* ACTUALIZA DIRECCION POR ID */
    public function actualizarDireccionMonto(Request $request, $id) {

        //Actualiza los datos en la tabla
        $montoDireccion = MontoDireccion::find($id);
        $montoDireccion->nombre      = $request->input('nombre');
        $montoDireccion->descripcion = $request->input('descripcion');
        $montoDireccion->monto       = $request->input('monto');

        $montoDireccion->save();
    
        return response()->json(['success' => true, 'message' => 'El presupuesto de la dirección se ha actualizado correctamente.']);

    }
    /* ACTUALIZA DIRECCION POR ID */



    /* CIERRA EL PROCESO DE PLANIFICACIÓN */
    public function cerrarDireccionMonto(Request $request, $id) {

        //Actualiza los datos en la tabla
        $montoDireccion = MontoDireccion::find($id);
        $montoDireccion->proceso_estado = true;
        $montoDireccion->save();
    
        return response()->json(['success' => true, 'message' => 'El proceso de planificación se ha cerrado.']);

    }
    /* CIERRA EL PROCESO DE PLANIFICACIÓN */




    /* ABRIR EL PROCESO DE PLANIFICACIÓN */
    public function abrirDireccionMonto(Request $request, $id) {

        //Actualiza los datos en la tabla
        $montoDireccion = MontoDireccion::find($id);
        $montoDireccion->proceso_estado = FALSE;
        $montoDireccion->save();
    
        return response()->json(['success' => true, 'message' => 'El proceso de planificación se ha abierto.']);

    }
    /* ABRIR EL PROCESO DE PLANIFICACIÓN */




    /* ELIMINAR ITEM PRESUPUESTARIO */
    public function deleteDireccionMonto(Request $request)
    {
        $direccion = MontoDireccion::find($request->id); //Busca el registro por el ID

        if ($direccion) {

            $direccion->update([
                'estado' => 'E', //Asigna el estado "E" para no mostrarlo en la tabla
            ]);

            return response()->json(['message' => 'Registro eliminado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el registro', 'data' => false], 500);

        }

    }
    /* ELIMINAR ITEM PRESUPUESTARIO */

    /* ============================================ MONTO DIRECCION ============================================ */



    /* ============================================ MONTO DIRECCION ITEM ============================================ */

    public function monto_item(Request $request){

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre', 'proceso_estado')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
            $id_fuente    = $direccion->id_fuente;
            $nombreDir    = $direccion->nombre;
            $proestado    = $direccion->proceso_estado;

        }else{
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre', 'proceso_estado')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
            $id_fuente    = $direccion->id_fuente;
            $nombreDir    = $direccion->nombre;
            $proestado    = $direccion->proceso_estado;

        }

        $items = ItemPresupuestario::where('pla_item_presupuestario.estado', 'A')->whereNotIn('pla_item_presupuestario.id', function ($query) use ($id_direccion) {
            $query->select('id_item')
                    ->from('pla_items_direcciones')
                    ->where('id_direcciones', '=', $id_direccion)
                    ->where('estado', '=', 'A');
        })->get();


        if(request()->ajax()) {

            return datatables()->of(ItemDireccion::select('pla_items_direcciones.id', 'dir.nombre as direccion', 'ite.nombre as n_item', 'pla_items_direcciones.estado', 
            'ite.descripcion as nombre_item', 'pla_items_direcciones.monto', 'dir.proceso_estado',
            DB::raw('DATE_FORMAT(pla_items_direcciones.created_at, "%Y-%m-%d %H:%i:%s") as fecha'))
            ->join('pla_direcciones as dir', 'dir.id', '=', 'pla_items_direcciones.id_direcciones')
            ->join('pla_item_presupuestario as ite', 'ite.id', '=', 'pla_items_direcciones.id_item')
            ->where('pla_items_direcciones.estado', 'A')
            ->where('dir.id', $id_direccion)
            ->orderBy('ite.nombre', 'asc')
            ->get() 
            )
            ->addIndexColumn()
            ->make(true);
        }
        //respuesta para la vista
        return view('item_presupuestario.monto_item', compact('items', 'id_area', 'direccion_id', 'id_user', 'id_direccion', 'monto', 'id_fuente', 'nombreDir',
                    'proestado'));
    }


    public function list_items($id_direccion){

        $items = ItemPresupuestario::where('pla_item_presupuestario.estado', 'A')->whereNotIn('pla_item_presupuestario.id', function ($query) use ($id_direccion) {
            $query->select('id_item')
                    ->from('pla_items_direcciones')
                    ->where('id_direcciones', '=', $id_direccion)
                    ->where('estado', '=', 'A');
        })->get();

        return response()->json([
            'success' => true,
            'data'    => $items,
        ], 200); 

    }



    public function actualizarItems(Request $request)
    {

        $validatedData = $request->validate([
            'id_direccion'  => 'required',
            'items'         => 'required|array',
            'items.*.id'    => 'required',
            'items.*.valor' => 'required|numeric|min:0',
        ]);
    
        $id_dir = $validatedData['id_direccion'];
        $items = $validatedData['items'];



        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'proceso_estado')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
            $proceso      = $direccion->proceso_estado;
        }else{
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente', 'proceso_estado')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
            $proceso      = $direccion->proceso_estado;
        }

        $montoTotal = ItemDireccion::where('id_direcciones', $id_direccion)->where('estado', 'A')->sum('monto');
        $montoNuevo = 0;

        foreach ($items as $itemData) {
            $montoNuevo += $itemData['valor'];
        }

        $sumMonto = $montoTotal + $montoNuevo;

        if($monto < $sumMonto){

            return response()->json([
                'error'   => true,
                'message' => 'La suma del monto total excede el límite permitido.'
            ], 400); 

        }else{

            DB::beginTransaction();
    
            try {
                
                foreach ($items as $itemData) {
                    $data = [
                        'id_direcciones' => $id_dir,
                        'id_item' => $itemData['id'],
                    ];
        
                    ItemDireccion::updateOrCreate(
                        $data,
                        [
                        'monto'       => $itemData['valor'],
                        'presupuesto' => $itemData['valor'],
                        'estado'      => 'A'
                        ]
                    );
                }
        
                DB::commit();
        
                return response()->json(['message' => 'Registro agregado exitosamente', 'data' => true], 200);
        
            } catch (\Exception $e) {
                DB::rollBack();
        
                return response()->json(['message' => 'Error al registrar los datos', 'error' => $e->getMessage()], 500);
            }

        }

    }



    /* ACTUALIZA LA ESTRUCTURA DE LA DIRECCION */
    public function actualizarEstructura(Request $request) {

        $id_direccion = $request->input('id_direccion');
        $id_fuente    = $request->input('id_fuente');


        //Actualiza los datos en la tabla
        $montoDireccion = MontoDireccion::find($id_direccion);
        $montoDireccion->id_fuente      = $request->input('id_fuente');

        $montoDireccion->save();
    
        return response()->json(['success' => true, 'message' => 'Se actualizo la estructura de financiamiento de la dirección']);

    }
    /* ACTUALIZA LA ESTRUCTURA DE LA DIRECCION */



    /* TRAER EL ITEM ESPECIFICO DE LA DIRECCION POR ID */
    public function obtenerDireccionItem($id)
    {
        // Obtiene los datos previamente registrados
        $itemP = ItemDireccion::find($id);

        return response()->json(['datos' => $itemP]);

    }
    /* TRAER EL ITEM ESPECIFICO DE LA DIRECCION POR ID */



    /* ACTUALIZA ACTUALIZA EL MONTO DEL ITEM POR DIRECCION */
    public function actualizarItemMonto(Request $request, $id) {

        $id_user   = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();
        $id_area   = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        if($id_area == 7){
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir_tec', $direccion_id)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
        }else{
            $direccion = MontoDireccion::select('id', 'monto', 'id_fuente')->where('id_dir', $id_area)->first();
            $id_direccion = $direccion->id;
            $monto        = $direccion->monto;
        }

        $montoNuevo = $request->input('monto');
        $montoTotal = ItemDireccion::where('id_direcciones', $id_direccion)->where('id', '!=', $id)->where('estado', 'A')->sum('monto');
        $sumMonto = $montoTotal + $montoNuevo;

        if($monto < $sumMonto && $montoNuevo != 0){

            return response()->json([
                'error'   => true,
                'message' => 'La suma del monto total excede el límite permitido.', 
                'total'   => $montoTotal,
                'monto'   => $montoNuevo,
            ], 400); 

        }else{

            //Actualiza los datos en la tabla
            $montoDireccion = ItemDireccion::find($id);
            $montoDireccion->monto = $request->input('monto');
            $montoDireccion->presupuesto = $request->input('monto');
            $montoDireccion->save();
        
            return response()->json(['error' => false, 'message' => 'El presupuesto deL Item se ha actualizado correctamente.']);

        }

    }
    /* ACTUALIZA ACTUALIZA EL MONTO DEL ITEM POR DIRECCION */



    /* ELIMINAR ITEM PRESUPUESTARIO DE LA DIRECCION */
    public function deleteItemDireccion(Request $request)
    {
        $direccion = ItemDireccion::find($request->id); //Busca el registro por el ID
        
        if ($direccion) {

            $direccion->update([
                'estado' => 'E', //Asigna el estado "E" para no mostrarlo en la tabla
            ]);

            return response()->json(['message' => 'Registro eliminado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el registro', 'data' => false], 500);

        }

    }
    /* ELIMINAR ITEM PRESUPUESTARIO DE LA DIRECCION */



    /* TRAE LA ESTRUCTURA PRESUPUESTARIA */
    public function get_estructura(Request $request, $id) {

        $estrutura = Fuente::select('pla_fuente.id as id_fuente', 'act.id as id_actividad', 'pro.id as id_proyecto',
            'proy.id as id_programa', 'uni.id as id_unidad')
            ->join('pla_actividad_act as act', 'act.id', '=', 'pla_fuente.id_actividad')
            ->join('pla_proyecto as pro', 'pro.id', '=', 'act.id_proyecto')
            ->join('pla_programa as proy', 'proy.id', '=', 'pro.id_programa')
            ->join('pla_unidad_ejecutora as uni', 'uni.id', '=', 'proy.id_unidad')
            ->where('pla_fuente.id', $id)->first();

        
        $unidad = UnidadEjecutora::where('estado', 'A')->get();
        $programa = Programa::where('estado', 'A')->where('id_unidad', $estrutura->id_unidad)->get();
        $proyecto = Proyecto::where('estado', 'A')->where('id_programa', $estrutura->id_programa)->get();
        $actividadPre = ActividadPre::where('estado', 'A')->where('id_proyecto', $estrutura->id_proyecto)->get();
        $fuente = Fuente::where('estado', 'A')->where('id_actividad', $estrutura->id_actividad)->get();

        return response()->json([ 'success' => true, 'data' => $estrutura, 'unidad' => $unidad,
            'programa' => $programa, 'proyecto' => $proyecto, 'actividadPre' => $actividadPre, 'fuente' => $fuente ]);

    }
    /* TRAE LA ESTRUCTURA PRESUPUESTARIA */



    /* TRAE LOS VALORES DEL LOS MONTOS POR DIRECCION */
    public function get_montos($id) {

        $direccion = MontoDireccion::select('monto')->find($id);
        $monto     = $direccion->monto;

        $totalItems = ItemDireccion::selectRaw('SUM(monto) as total_monto')
            ->where('id_direcciones', $id)
            ->where('estado', 'A')
            ->first();

        $totalOcupado = $totalItems->total_monto ?? 0;

        $porOcupar = $monto - $totalOcupado;

        return response()->json([
            'success'     => true,
            'monto_total' =>    number_format($monto,2),
            'total_ocupado' =>  number_format($totalOcupado, 2),
            'por_ocupar'  =>    number_format($porOcupar,2)
        ]);

    }
    /* TRAE LOS VALORES DEL LOS MONTOS POR DIRECCION */



    /* ============================================ MONTO DIRECCION ITEM ============================================ */



}
