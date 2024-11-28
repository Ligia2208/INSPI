<?php

namespace App\Http\Controllers\InventarioReactivo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use App\Http\Requests\DocumentoRequest;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;

use App\Models\User;
//use App\Models\PermisoRolOpcion\PermisoRolOpcion;

use Datatables;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cache;
use League\CommonMark\Extension\Table\Table;

// email
use App\Mail\UsuarioHospital;

//MODELO PARA INVENTARIO
use App\Models\Inventarios\Contador\Contador;
use App\Models\Inventarios\Proveedor\Proveedor;
use App\Models\Inventarios\Categoria\Categoria;
use App\Models\Inventarios\Subcategoria\Subcategoria;
use App\Models\Inventarios\Marca\Marca;
use App\Models\Inventarios\Unidad\Unidad;
use App\Models\Inventarios\Articulo\Articulo;
use App\Models\Inventarios\Acta\Acta;
use App\Models\Inventarios\Movimiento\Movimiento;
use App\Models\Inventarios\MovimientoArticulo\MovimientoArticulo;
use App\Models\Inventarios\DetalleMovimiento\DetalleMovimiento;
use App\Models\Inventarios\InventarioMovimiento\InventarioMovimiento;
use App\Models\Inventarios\InventarioMovimientoLab\InventarioMovimientoLab;
use App\Models\Inventarios\Inventario\Inventario;
use App\Models\Inventarios\Lote\Lote;
use App\Models\Inventarios\Kit\Kit;

use App\Models\Inventarios\PruebaArticulo\PruebaArticulo;
use App\Models\Inventarios\Prueba\Prueba;

use App\Models\CentrosReferencia\Crn;//esto es para el centro de referencia

//MODELO PARA CORRIDA
use App\Models\Corrida\Corrida\Corrida;
use App\Models\Corrida\Extraccion\Extraccion;
use App\Models\Corrida\ExtraccionDet\ExtraccionDet;
use App\Models\Corrida\Mezcla\Mezcla;
use App\Models\Corrida\MezclaDet\MezclaDet;
use App\Models\Corrida\Perfil\Perfil;
use App\Models\Corrida\PerfilDet\PerfilDet;
use App\Models\Corrida\Control\Control;
use App\Models\Corrida\ControlDet\ControlDet;
use App\Models\Corrida\Resultado\Resultado;
use App\Models\Corrida\ResultadoDet\ResultadoDet;
use App\Models\Corrida\Estandar\Estandar;
use App\Models\Corrida\Monoclonal\Monoclonal;
use App\Models\Corrida\Policlonal\Policlonal;
use App\Models\Corrida\ReactivoMono\ReactivoMono;
use App\Models\Corrida\Movimiento\MovimientoCor;

use App\Models\Laboratorio\Laboratorio;
use App\Models\Muestra\Muestra;
use App\Models\Examen\Examen;
use App\Models\Controles\Controles;

//use App\Imports\YourModelImport;
use App\Imports\ArticulosImport;
use App\Imports\ResultadosImport;
use App\Imports\ExtracionImport;
use App\Imports\ResultadosImportInm;

use App\Exports\MovimientosExport;
use App\Exports\Movimientos2Export;
use App\Exports\Movimientos3Export;

use App\Exports\IngresoExport;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;

//PDF
use Barryvdh\DomPDF\Facade as PDF;

class InventarioController extends Controller
{

    public function index(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id')
            ->where('lab.usuario_id', '=', $id_usuario)//46 es para bodega
            ->first();

        $id_labora = $labora->crns_id;

        $laboratorios = Crn::select('id', 'descripcion')->where('estado', 'A')->get();

        //$laboratorios = Laboratorio::select('id', 'nombre')->where('estado', 'A')->get();
        $categorias = Categoria::select('id', 'nombre')->where('estado', 'A')->get();

        if(request()->ajax()) {

            return datatables()->of($evento = Inventario::select('inv_inventario.id as id_inv','art.id as id', 'art.nombre as articulo', 'lote.nombre as lote',
                'inv_inventario.estado as estado', DB::raw('DATE_FORMAT(inv_inventario.created_at, "%Y-%m-%d") as fecha'), 'lote.f_caduca',
                'inv_inventario.cantidad as cantidad', 'lab.nombre as laboratorio')
                ->join('db_inspi_inventario.inv_lote as lote', 'lote.id', '=', 'db_inspi_inventario.inv_inventario.id_lote')
                ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lote.id_articulo')
                ->join('db_inspi.inspi_laboratorio as lab', 'lab.id', '=', 'inv_inventario.id_laboratorio')
                ->where('inv_inventario.estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        //return view('inventarios.index', compact('Modulos','Opciones', 'id_labora', 'laboratorios', 'categorias'));
        return view('inventarios.index', compact('id_labora', 'laboratorios', 'categorias'));
    }




    /* VISTA - LISTA TODAS LAS MARCAS EXISTENTES */
    public function listMarca(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        if(request()->ajax()) {

            return datatables()->of($marca = Marca::select('id', 'nombre', 'estado', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as fecha'))
                            ->where('estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_marca', compact('Modulos','Opciones'));
    }
    /* VISTA - LISTA TODAS LAS MARCAS EXISTENTES */



    /* GUARDAR MARCA */
    public function saveMarca(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nameMarca' => 'required|string',
        ]);

        $existingMarca = Marca::where('nombre', $request->nameMarca)->first();

        if ($existingMarca) {
            return response()->json(['message' => 'La marca ya existe.', 'data' => false], 200); // 409 Conflict
        }

        $marca = Marca::create([
            'nombre' => $request->nameMarca,
        ]);

        if ($marca) {

            return response()->json(['message' => 'Marca guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear la Marca', 'data' => false], 500);

        }

    }
    /* GUARDAR MARCA */


    /* TRAER KIT */
    public function obtenerKit($id)
    {
        // Validar y obtener los datos del formulario
        $kit = Kit::find($id);

        return response()->json($kit);

    }
    /* TRAER KIT */


    /* TRAER MARCA */
    public function obtenerMarca($id)
    {
        // Validar y obtener los datos del formulario
        $marca = Marca::find($id);

        return response()->json($marca);

    }
    /* TRAER MARCA */


    /* ACTUALIZAR MARCA */
    public function actualizarMarca(Request $request, $id) {

        $marca = Marca::find($id);
        $marca->nombre = $request->input('nombre');
        $marca->save();

        return response()->json(['success' => true, 'message' => 'La Marca se ha actualizado correctamente.']);
    }
    /* ACTUALIZAR MARCA */


    /* ELIMINAR MARCA */
    public function deleteMarca(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_marca' => 'required|string',
        ]);

        $marca = Marca::find($request->id_marca);

        if ($marca) {

            $marca->update([
                'estado' => 'E',
            ]);

            return response()->json(['message' => 'Marca eliminada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar la Marca', 'data' => false], 500);

        }

    }
    /* ELIMINAR MARCA */




    /* VISTA - LISTA TODAS LAS CATEGORÍAS EXISTENTEST */
    public function listCategoria(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        if(request()->ajax()) {

            return datatables()->of(
                $categoria = Categoria::select('id', 'nombre', 'estado', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as created_at'))
                            ->where('estado', 'A')
                )
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_categoria');
    }
    /* VISTA - LISTA TODAS LAS CATEGORÍAS EXISTENTEST */


    /* GUARDAR CATEGORÍA */
    public function saveCategoria(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nameCategoria' => 'required|string',
        ]);

        $existingCategoria = Categoria::where('nombre', $request->nameCategoria)->first();

        if ($existingCategoria) {
            return response()->json(['message' => 'La categoria ya existe.', 'data' => false], 200); // 409 Conflict
        }else{

            $categoria = Categoria::create([
                'nombre' => $request->nameCategoria,
            ]);

            if ($categoria) {

                return response()->json(['message' => 'Categoría guardada exitosamente', 'data' => true], 200);

            } else {

                return response()->json(['message' => 'Error al crear la Categoría', 'data' => false], 500);

            }

        }

    }
    /* GUARDAR CATEGORÍA */



    /* ELIMINAR CATEGORÍA */
    public function deleteCategoria(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_categoria' => 'required|string',
        ]);

        $categoria = Categoria::find($request->id_categoria);

        if ($categoria) {

            $categoria->update([
                'estado' => 'E',
            ]);

            return response()->json(['message' => 'Categoría eliminada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar la Categoría', 'data' => false], 500);

        }

    }
    /* ELIMINAR CATEGORÍA */


    /* TRAER CATEGORÍA */
    public function obtenerCategoria($id)
    {
        // Validar y obtener los datos del formulario
        $categoria = Categoria::find($id);

        return response()->json($categoria);

    }
    /* TRAER CATEGORÍA */



    /* ACTUALIZAR CATEGORÍA */
    public function actualizarCategoria(Request $request, $id) {

        $categoria = Categoria::find($id);
        $categoria->nombre = $request->input('nombre');
        $categoria->save();

        return response()->json(['success' => true, 'message' => 'La categoría se ha actualizado correctamente.']);
    }
    /* ACTUALIZAR CATEGORÍA */





    /* ========================================================================== UNIDAD DE MEDIDA ========================================================================== */

    /* VISTA - LISTA TODAS LAS CATEGORÍAS EXISTENTEST */
    public function listUnidad(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        if(request()->ajax()) {

            return datatables()->of($categoria = Unidad::select('id', 'nombre', 'abreviatura', 'estado', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as created_at'))
                            ->where('estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_unidad');
    }
    /* VISTA - LISTA TODAS LAS CATEGORÍAS EXISTENTEST */



    /* GUARDAR UNIDAD */
    public function saveUnidad(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nameUnidad'    => 'required|string',
            'abreviaUnidad' => 'required|string',
        ]);

        $unidad = Unidad::create([
            'nombre'      => $request->nameUnidad,
            'abreviatura' => $request->abreviaUnidad,
        ]);

        if ($unidad) {

            return response()->json(['message' => 'Unidad guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear la Unidad', 'data' => false], 500);

        }

    }
    /* GUARDAR UNIDAD */


    /* ELIMINAR UNIDAD */
    public function deleteUnidad(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_unidad' => 'required|string',
        ]);

        $unidad = Unidad::find($request->id_unidad);

        if ($unidad) {

            $unidad->update([
                'estado' => 'E',
            ]);

            return response()->json(['message' => 'Unidad eliminada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar la Unidad', 'data' => false], 500);

        }

    }
    /* ELIMINAR UNIDAD */



    /* TRAER UNIDAD */
    public function obtenerUnidad($id)
    {
        // Validar y obtener los datos del formulario
        $unidad = Unidad::find($id);

        return response()->json($unidad);

    }
    /* TRAER UNIDAD */


    /* ACTUALIZAR UNIDAD */
    public function actualizarUnidad(Request $request, $id) {

        $unidad = Unidad::find($id);
        $unidad->nombre      = $request->input('nombre');
        $unidad->abreviatura = $request->input('abreviatura');
        $unidad->save();

        return response()->json(['success' => true, 'message' => 'La unidad se ha actualizado correctamente.']);
    }
    /* ACTUALIZAR UNIDAD */






    /* ========================================================================== ARTICULO ========================================================================== */

    /* VISTA - LISTA TODAS LAS ARTÍCULOS EXISTENTES  */
    public function listArticulo(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        if(request()->ajax()) {

            return datatables()->of($categoria = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado',
                                    DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad')
                                    ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                                    ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                                    ->where('inv_articulo.estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_articulo', compact('unidades', 'categorias'));
    }
    /* VISTA - LISTA TODAS LAS ARTÍCULOS EXISTENTES  */



    /* GUARDAR ARTÍCULO */
    public function saveArticulo(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nameArticulo'   => 'required|string',
            'id_categoria'   => 'required|string',
            'id_unidad'      => 'required|string',
        ]);

        $existingArticulo = Articulo::where('nombre', $request->nameArticulo)
            ->where('id_categoria', $request->id_categoria)->first();

        if ($existingArticulo) {
            return response()->json(['message' => 'El Artículo ya existe.', 'data' => false], 200); // 409 Conflict
        }else{

            $articulo = Articulo::create([
                'nombre'       => $request->nameArticulo,
                'id_categoria' => $request->id_categoria,
                'id_unidad'    => $request->id_unidad,
            ]);

            if ($articulo) {

                return response()->json(['message' => 'Artículo guardado exitosamente', 'data' => true], 200);

            } else {

                return response()->json(['message' => 'Error al crear el Artículo', 'data' => false], 500);

            }

        }

    }
    /* GUARDAR ARTÍCULO */


    /* ELIMINAR ARTÍCULO */
    public function deleteArticulo(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_articulo' => 'required|string',
        ]);

        $articulo = Articulo::find($request->id_articulo);

        if ($articulo) {

            $articulo->update([
                'estado' => 'E',
            ]);

            return response()->json(['message' => 'Artículo eliminada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar la Artículo', 'data' => false], 500);

        }

    }
    /* ELIMINAR ARTÍCULO */



    /* TRAER ARTÍCULO */
    public function obtenerArticulo($id)
    {
        // Validar y obtener los datos del formulario
        $articulo = Articulo::find($id);

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        //return response()->json($unidad);
        return response()->json(['unidades' => $unidades, 'categorias' => $categorias, 'articulo' => $articulo ]);

    }
    /* TRAER ARTÍCULO */



    /* ACTUALIZAR ARTÍCULO */
    public function actualizarArticulo(Request $request, $id) {


        $articulo = Articulo::find($id);
        $articulo->nombre       = $request->input('nombre');
        //$articulo->precio       = $request->input('precio');
        $articulo->id_categoria = $request->input('id_categoria');
        $articulo->id_unidad    = $request->input('id_unidad');

        $articulo->save();

        return response()->json(['success' => true, 'message' => 'El artículo se ha actualizado correctamente.']);
    }
    /* ACTUALIZAR ARTÍCULO */





    /* ========================================================================== MOVIMIENTO ========================================================================== */

    /* VISTA - LISTA TODOS LOS MOVIMIENTOS EXISTENTES  */
    public function listMovimiento(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id')
            ->where('lab.usuario_id', '=', $id_usuario)//46 es para bodega
            ->first();

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();
        $laboratorios = Crn::where('estado', 'A')->get();
        
        if(request()->ajax()) {
            
            return datatables()->of(
                                    /*
                                    $acta = Acta::select('inv_acta.id as id', 'inv_acta.nombre as nombre', 'inv_acta.estado as estado', 
                                    'inv_acta.fecha as fechaI', 'inv_acta.proveedor as proveedor', 'inv_acta.numero',
                                    DB::raw('DATE_FORMAT(inv_acta.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'inv_acta.tipo as tipo', 
                                    'lab.nombre as origen', 'inv_acta.total as total', 'inv_acta.transferible as transferible')
                                    ->join('db_inspi.inspi_laboratorio as lab', 'lab.id', '=', 'inv_acta.origen')
                                    ->where('inv_acta.estado', '!=', 'E')
                                    ->where('lab.id', '=', $labora->id
                                    */
                                    $acta = Acta::select('inv_acta.id as id', 'inv_acta.nombre as nombre', 'inv_acta.estado as estado', 
                                    'inv_acta.fecha as fechaI', 'inv_acta.proveedor as proveedor', 'inv_acta.numero',
                                    DB::raw('DATE_FORMAT(inv_acta.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'inv_acta.tipo as tipo', 
                                    'lab.descripcion as origen', 'inv_acta.total as total', 'inv_acta.transferible as transferible')
                                    ->join('inspi_crns.crns as lab', 'lab.id', '=', 'inv_acta.origen')
                                    ->where('inv_acta.estado', '!=', 'E')
                                    ->where('lab.id', '=', $labora->crns_id)
                                    )
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_movimiento', compact('unidades', 'categorias', 'laboratorios'));
    }
    /* VISTA - LISTA TODOS LOS MOVIMIENTOS EXISTENTES  */



    /* VISTA - CREAR NUEVO MOVIMIENTO */
    public function crearMovimiento(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $usuarios = User::select('id', 'name')
            ->where('status', '=', 'A')
            ->get();

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();
        $laboratorios = Crn::where('estado', 'A')->get();

        //respuesta para la vista
        return view('inventarios.create_movimiento', compact('unidades', 'categorias', 'laboratorios', 'usuarios'));
    }
    /* VISTA - CREAR NUEVO MOVIMIENTO */


    /* VISTA - EDITAR MOVIMIENTO */
    public function editarMovimiento($id){

        $id_acta = $id;
        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $usuarios = User::select('id', 'name')
            ->where('status', '=', 'A')
            ->get();

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        $laboratorios = Crn::where('estado', 'A')->get();

        $acta = Acta::select('inv_acta.id as id', 'inv_acta.nombre as nombre', 'inv_acta.estado as estado', 'inv_acta.fecha as fechaI', 'inv_acta.proveedor as proveedor',
                DB::raw('DATE_FORMAT(inv_acta.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'inv_acta.tipo as tipo', 'inv_acta.origen as origen', 'inv_acta.total as total',
                'inv_acta.id_laboratorio as destino', 'mov.id_usuario', 'inv_acta.factura as factura', 'inv_acta.n_contrato as n_contrato',
                'inv_acta.descripcion as descripcion')
                ->join('inv_movimiento as mov', 'mov.id_acta', '=', 'inv_acta.id')
                //->where('inv_acta.estado', 'A')
                ->where('inv_acta.id', $id_acta)->first();

        //respuesta para la vista
        return view('inventarios.edit_movimiento', compact('unidades', 'categorias', 'laboratorios', 'usuarios', 'acta'));
    }
    /* VISTA - EDITAR MOVIMIENTO */



    /* TRAER LOS MOVIMIENTOS POR ACTA */
    public function getMoviemientos($id)
    {
        $id_acta = $id;

        $movimientos = Movimiento::select('inv_movimiento.id', 'inv_movimiento.id_lote', 'inv_movimiento.unidades', 'inv_movimiento.precio', 'inv_movimiento.precio_total',
            'lot.nombre', 'lot.f_elabora', 'lot.f_caduca', 'lot.caduca', 'lot.id_articulo', 'art.id_unidad', 'lot.id as id_lote', 'uni.nombre as unidad', 'uni.abreviatura')
            ->join('inv_lote as lot', 'inv_movimiento.id_lote', '=', 'lot.id')
            ->join('inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('inv_unidad as uni', 'inv_movimiento.uni_medida', '=', 'uni.id')
            ->where('inv_movimiento.estado', 'A')
            ->where('inv_movimiento.id_acta', $id_acta)->get();

        return response()->json($movimientos);

    }
    /* TRAER LOS MOVIMIENTOS POR ACTA */


    /* TRAER ARTÍCULOS */
    public function obtenerArticulos()
    {

        $articulos = Articulo::where('estado', 'A')->get();
        return response()->json($articulos);

    }
    /* TRAER ARTÍCULOS */


    /* TRAER ARTÍCULOS POR ID LABORATORIO */
    public function obtenerArticulosIdLab(Request $request)
    {

        $id_laboratorio = $request->query('id_laboratorio');

        $articulos = Inventario::select('art.id', 'art.nombre')
            ->join('inv_lote as lote', 'inv_inventario.id_lote', '=', 'lote.id')
            ->join('inv_articulo as art', 'lote.id_articulo', '=', 'art.id')
            ->where('inv_inventario.estado', 'A')
            ->where('inv_inventario.id_laboratorio', $id_laboratorio)->get();
        return response()->json($articulos);

    }
    /* TRAER ARTÍCULOS POR ID LABORATORIO */


    /* TRAER MARCAS */
    public function obtenerMarcas()
    {

        $marca = Marca::where('estado', 'A')->get();
        return response()->json($marca);

    }
    /* TRAER MARCAS */


    /* TRAER LOS DATOS DEL PROVEEDOR */
    public function get_proveedor(Request $request)
    {
        $ruc = $request->input('ruc');
        // Validar y obtener los datos del formulario
        $proveedor = Proveedor::where('ruc', $ruc)->first();

        return response()->json($proveedor);

    }
    /* TRAER LOS DATOS DEL PROVEEDOR */


    /* GUARDAR MOVIMIENTO */
    public function saveMovimiento(Request $request)
    {

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'descripcion' => 'required|string',
            'total'       => 'required|string',
            'proveedor'   => 'required|string',
            'destino'     => 'required|string',
            'recibe'      => 'required|string',
            //'noIngreso'   => 'required|string',
            'n_contrato'  => 'required|string',
            'factura'     => 'string|nullable',
            'arraryData'  => 'required|array',
        ]);


        $ruc = $request->nombre;
        $proveedor = $request->proveedor;

        $proveedor = Proveedor::updateOrCreate(
            ['ruc' => $ruc],
            ['nombre' => $proveedor, 'ruc' => $ruc]
        );


        $tipo = $request->tipo;
        if($request->factura == NULL){
            $factura = '';
        }else{
            $factura = $request->factura;
        }

        $counter = Contador::first();

        if (!$counter) {
            $counter = Contador::create([
                'no_ingreso'  => 0,
                'no_egreso'   => 0,
                'no_donacion' => 0,
                'no_traspaso' => 0,
            ]);
        }

        //DB::beginTransaction();
        $createdActaId = null;
        $lote_id = null;
        $createdLoteIds = [];
        $createdMovimientoIds = [];
        $initialInventoryState = [];

        try {
            // Crea el registro de Acta
            $acta = Acta::create([
                'nombre'         => $request->nombre,
                'proveedor'      => $request->proveedor,
                'fecha'          => $request->fecha,
                'tipo'           => $tipo,
                'origen'         => $request->destino, //en el caso de un ingreso el origen y el destino es el mismo
                'recibe'         => $request->recibe,
                'descripcion'    => $request->descripcion,
                'factura'        => $factura,
                'n_contrato'     => $request->n_contrato,
                'total'          => $request->total,
                'id_laboratorio' => $request->destino,
            ]);
            $createdActaId = $acta->id;

            // Incrementa los contadores y actualiza el Acta
            if ($tipo === 'I') {

                $noIngreso = 'N-DON-' . ($counter->no_donacion + 1);
                $counter->increment('no_donacion');

            }else if($tipo === 'C'){

                $noIngreso = 'N-INT-' . ($counter->no_ingreso + 1);
                $counter->increment('no_ingreso');

            }

            // Actualiza el registro de Acta
            $acta->update([
                'no_ingreso' => $noIngreso,
                'numero'     => $noIngreso,
            ]);


            $actaId = $acta->id;

            $movimientos = $request->input('arraryData');
            $unis = '';

            foreach ($movimientos as $movimiento) {

                $unis = $movimiento['uni_medida'];

                $uni_medida = $movimiento['uni_medida'];
                $unidad   = $movimiento['unidad'];
                $articulo = $movimiento['articulo'];
                //$marca    = $movimiento['marca'];
                $costo    = $movimiento['costo'];
                $costoTotal = $movimiento['costoTotal'];
                $caduca   = $movimiento['caduca'];
                $expF     = $movimiento['expF'];
                $elaF     = $movimiento['elaF'];
                $loteName = $movimiento['lote'];

                // $LoteExistente = Lote::where('nombre', $loteName)->first();

                // if ($LoteExistente) {
                //     $createdLoteIds[] = $LoteExistente->id;
                //     $lote_id = $LoteExistente->id;
                // } else {

                $lote = Lote::create([
                    'nombre'      => $loteName,
                    'f_elabora'   => $elaF ?? '',
                    'f_caduca'    => $expF ?? '',
                    'caduca'      => $caduca,
                    'id_articulo' => $articulo,
                    'id_marca'    => '',
                ]);
                $createdLoteIds[] = $lote->id;
                $lote_id = $lote->id;

                // }


                // Determinar el saldo inicial
                // if ($LoteExistente) {
                //     $saldoInicial = $inventarioExistente->cantidad;

                // } else {
                //     $saldoInicial = 0;

                // }

                $inventarioExistente = Inventario::where('id_lote', $lote_id)
                ->where('id_laboratorio', $request->destino)
                ->first();

                //Determinar el saldo inicial
                $saldoInicial = $inventarioExistente ? $inventarioExistente->cantidad : 0;

                //Calcular el saldo final
                $saldoFinal = $saldoInicial + $unidad;

                //Calcular el saldo final
                //$saldoFinal = $saldoInicial + $unidad;

                $movimientoCreate = Movimiento::create([
                    'id_usuario'   => $id_usuario,
                    'id_lote'      => $lote_id,
                    'unidades'     => $unidad, //cantidad
                    'uni_medida'   => $uni_medida, //en unidadesd de medidas
                    'precio'       => $costo,  //precio unitario
                    'precio_total' => $costoTotal,  //precio total
                    'id_acta'      => $actaId,
                    'saldo_ini'    => $saldoInicial,
                    'saldo_fin'    => $saldoFinal,
                ]);

                // ================= se guarda un registro para ver el movimiento en articulos
                $inventarioExistenteArt = Inventario::join('inv_lote as lote', 'inv_inventario.id_lote', '=', 'lote.id')
                    ->where('lote.id_articulo', $articulo)
                    ->where('inv_inventario.id_laboratorio', $request->destino)
                    ->where('inv_inventario.id_unidad', $uni_medida)
                    ->sum('inv_inventario.cantidad');

                //Determinar el saldo inicial
                $saldoInicialArt = $inventarioExistenteArt ? $inventarioExistenteArt : 0;

                //Calcular el saldo final
                $saldoFinalArt = $saldoInicialArt + $unidad;
                $movimientoArtCreate = MovimientoArticulo::create([
                    'id_usuario'   => $id_usuario,
                    'id_articulo'  => $articulo,
                    'unidades'     => $unidad, //cantidad
                    'uni_medida'   => $uni_medida, //en unidadesd de medidas
                    'precio'       => $costo,  //precio unitario
                    'precio_total' => $costoTotal,  //precio total
                    'id_acta'      => $actaId,
                    'saldo_ini'    => $saldoInicialArt,
                    'saldo_fin'    => $saldoFinalArt,
                ]);
                // ================= 
                

                $createdMovimientoIds[] = $movimientoCreate->id;

                //guarda los datos que fueron modificados, en caso de que algo salga mal
                $inventarioExistente = Inventario::where('id_lote', $lote_id)->where('id_laboratorio', $request->destino)->first();
                if ($inventarioExistente) {
                    $initialInventoryState[] = [
                        'id' => $inventarioExistente->id,
                        'cantidad' => $inventarioExistente->cantidad,
                        'id_lote' => $lote_id,
                        'id_laboratorio' => $request->destino,
                        'exists' => true
                    ];
                } else {
                    $initialInventoryState[] = [
                        'id_lote' => $lote_id,
                        'cantidad' => 0,
                        'id_laboratorio' => $request->destino,
                        'exists' => false
                    ];
                }

                $inventarioId = Inventario::actualizarInventario($lote_id, $unidad, $request->destino, $uni_medida);//esta funcion guarda en el inventario

                // Guardar ID del inventario en el estado inicial
                if (!$inventarioExistente) {
                    $initialInventoryState[count($initialInventoryState) - 1]['id'] = $inventarioId;
                }
            }

            //DB::commit();
            return response()->json(['message' => 'Movimiento guardado exitosamente', 'data' => true, 'unis' => $unis], 200);

        } catch (\Exception $e) {

            // Eliminar registros creados manualmente
            if ($createdMovimientoIds) {
                Movimiento::whereIn('id', $createdMovimientoIds)->delete();
            }
            if ($createdLoteIds) {
                Lote::whereIn('id', $createdLoteIds)->delete();
            }
            if ($createdActaId) {
                Acta::where('id', $createdActaId)->delete();
            }

            // Revertir cambios en el inventario
            foreach ($initialInventoryState as $state) {
                if ($state['exists']) {
                    $inventarioExistente = Inventario::where('id', $state['id'])->first();
                    if ($inventarioExistente) {
                        $inventarioExistente->update([
                            'cantidad' => $state['cantidad']
                        ]);
                    }
                } else {
                    Inventario::where('id', $state['id'])->delete();
                }
            }

            //DB::rollBack();
            return response()->json(['message' => 'Error al crear el Movimiento', 'data' => false, 'error' => $e->getMessage()], 500);
        }

    }
    /* GUARDAR MOVIMIENTO */


    /* GUARDAR LA EDICCIÓN DEL MOVIMIENTO */
    public function editMovimiento(Request $request)
    {

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_acta'     => 'required|string',
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'descripcion' => 'required|string',
            'total'       => 'required|string',
            'proveedor'   => 'required|string',
            'destino'     => 'required|string',
            'recibe'      => 'required|string',
            //'noIngreso'   => 'required|string',
            'n_contrato'  => 'required|string',
            'factura'     => 'string|nullable',
            'arraryData'  => 'required|array',
        ]);

        $id_acta   = $request->id_acta;
        $ruc = $request->nombre;
        $proveedor = $request->proveedor;

        $proveedor = Proveedor::updateOrCreate(
            ['ruc' => $ruc],
            ['nombre' => $proveedor, 'ruc' => $ruc]
        );


        $tipo = $request->tipo;
        if($request->factura == NULL){
            $factura = '';
        }else{
            $factura = $request->factura;
        }

        $counter = Contador::first();

        if (!$counter) {
            $counter = Contador::create([
                'no_ingreso'  => 0,
                'no_egreso'   => 0,
                'no_donacion' => 0,
                'no_traspaso' => 0,
            ]);
        }

        //DB::beginTransaction();
        $createdActaId = null;
        $createdLoteIds = [];
        $createdMovimientoIds = [];
        $initialInventoryState = [];

        try {

            $acta = Acta::find($id_acta);

            if ($acta) {
                $acta->update([
                    'nombre'         => $request->nombre,
                    'proveedor'      => $request->proveedor,
                    'fecha'          => $request->fecha,
                    'tipo'           => $tipo,
                    'origen'         => $request->destino,
                    'recibe'         => $request->recibe,
                    'descripcion'    => $request->descripcion,
                    'factura'        => $factura,
                    'n_contrato'     => $request->n_contrato,
                    'total'          => $request->total,
                    'id_laboratorio' => $request->destino,
                    'modificar'      => 'false',
                ]);
            }

            // Incrementa los contadores y actualiza el Acta
            if ($tipo === 'I') {

                $noIngreso = 'N-DON-' . ($counter->no_donacion + 1);
                $counter->increment('no_donacion');

            }else if($tipo === 'C'){

                $noIngreso = 'N-INT-' . ($counter->no_ingreso + 1);
                $counter->increment('no_ingreso');

            }

            // Actualiza el registro de Acta
            $acta->update([
                'no_ingreso' => $noIngreso,
                'numero'     => $noIngreso,
            ]);


            //$actaId = $acta->id;

            $movimientos = $request->input('arraryData');

            foreach ($movimientos as $movimiento) {

                $id_movimiento = $movimiento['id_movimiento'];
                $uni_medida = $movimiento['uni_medida'];
                $unidad   = $movimiento['unidad'];
                $articulo = $movimiento['articulo'];
                //$marca    = $movimiento['marca'];
                $costo    = $movimiento['costo'];
                $costoTotal = $movimiento['costoTotal'];
                $caduca   = $movimiento['caduca'];
                $expF     = $movimiento['expF'];
                $elaF     = $movimiento['elaF'];
                $lote     = $movimiento['lote'];

                if($id_movimiento == '0'){

                    $lote = Lote::create([
                        'nombre'      => $lote,
                        'f_elabora'   => $elaF ?? '',
                        'f_caduca'    => $expF ?? '',
                        'caduca'      => $caduca,
                        'id_articulo' => $articulo,
                        'id_marca'    => '',
                    ]);
                    $createdLoteIds[] = $lote->id;

                    $movimientoCreate = Movimiento::create([
                        'id_usuario'   => $id_usuario,
                        'id_lote'      => $lote->id,
                        'unidades'     => $unidad, //cantidad
                        'uni_medida'   => $uni_medida, //en unidadesd de medidas
                        'precio'       => $costo,  //precio unitario
                        'precio_total' => $costoTotal,  //precio total
                        'id_acta'      => $id_acta,
                    ]);
                    $createdMovimientoIds[] = $movimientoCreate->id;

                    //guarda los datos que fueron modificados, en caso de que algo salga mal
                    $inventarioExistente = Inventario::where('id_lote', $lote->id)->where('id_laboratorio', $request->destino)->first();
                    if ($inventarioExistente) {
                        $initialInventoryState[] = [
                            'id' => $inventarioExistente->id,
                            'cantidad' => $inventarioExistente->cantidad,
                            'id_lote' => $lote->id,
                            'id_laboratorio' => $request->destino,
                            'exists' => true
                        ];
                    } else {
                        $initialInventoryState[] = [
                            'id_lote' => $lote->id,
                            'cantidad' => 0,
                            'id_laboratorio' => $request->destino,
                            'exists' => false
                        ];
                    }

                    $inventarioId = Inventario::actualizarInventario($lote->id, $unidad, $request->destino, $uni_medida);//esta funcion guarda en el inventario

                    // Guardar ID del inventario en el estado inicial
                    if (!$inventarioExistente) {
                        $initialInventoryState[count($initialInventoryState) - 1]['id'] = $inventarioId;
                    }

                }else{

                    $mov = Movimiento::find($id_movimiento);

                    //actualiza el inventario dependiendo de la transacción
                    $unidadesAntiguas = $mov->unidades;
                    $diferenciaUnidades = $unidad - $unidadesAntiguas;

                    $loteToUpdate = Lote::find($mov->id_lote);
                    if ($loteToUpdate) {
                        $loteToUpdate->update([
                            'nombre'      => $lote,
                            'f_elabora'   => $elaF,
                            'f_caduca'    => $expF,
                            'caduca'      => $caduca,
                            'id_articulo' => $articulo,
                            'id_marca'    => '',
                        ]);
                    }

                    if ($mov) {
                        $mov->update([
                            'id_usuario'   => $id_usuario,
                            //'id_lote'      => $lote->id,
                            'unidades'     => $unidad,
                            'uni_medida'   => $uni_medida,
                            'precio'       => $costo,
                            'precio_total' => $costoTotal,
                            //'id_acta'      => $id_acta,
                        ]);
                    }

                    // Aumentar o disminuir inventario según la diferencia
                    if ($diferenciaUnidades > 0) {
                        // Aumentar inventario
                        $inventarioId = Inventario::actualizarInventario($mov->id_lote, $diferenciaUnidades, $request->destino, $uni_medida);

                    } elseif ($diferenciaUnidades < 0) {
                        // Disminuir inventario
                        $inventarioId = Inventario::actualizarInventario($mov->id_lote, $diferenciaUnidades, $request->destino, $uni_medida);

                    }


                }


            }

            //DB::commit();
            return response()->json(['message' => 'Movimiento guardado exitosamente', 'data' => true
                , 'inventarioId' => $diferenciaUnidades, 'unidadesAntiguas' => $unidadesAntiguas, 'unidad' => $unidad], 200);

        } catch (\Exception $e) {

            // Eliminar registros creados manualmente
            if ($createdMovimientoIds) {
                Movimiento::whereIn('id', $createdMovimientoIds)->delete();
            }
            if ($createdLoteIds) {
                Lote::whereIn('id', $createdLoteIds)->delete();
            }
            if ($createdActaId) {
                Acta::where('id', $createdActaId)->delete();
            }

            // Revertir cambios en el inventario
            foreach ($initialInventoryState as $state) {
                if ($state['exists']) {
                    $inventarioExistente = Inventario::where('id', $state['id'])->first();
                    if ($inventarioExistente) {
                        $inventarioExistente->update([
                            'cantidad' => $state['cantidad']
                        ]);
                    }
                } else {
                    Inventario::where('id', $state['id'])->delete();
                }
            }

            //DB::rollBack();
            return response()->json(['message' => 'Error al crear el Movimiento', 'data' => false, 'error' => $e->getMessage()], 500);
        }

    }
    /* GUARDAR LA EDICCIÓN DEL MOVIMIENTO */



    public function import(Request $request)
    {

        \DB::beginTransaction();

        // Validar que se haya enviado un archivo
        $request->validate([
            'file'        => 'required|mimes:csv,txt|max:2048',
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'origen'      => 'required|string',
            'descripcion' => 'required|string',
            'proveedor'   => 'required|string',
            'destino'     => 'required|string',
            'recibe'      => 'required|string',
            //'factura'     => 'string',
            'n_contrato'  => 'required|string',
        ]);

        $id_acta = '';

        try {
            // Obtener el archivo cargado
            $file = $request->file('file');

            // Generar un nombre único para el archivo
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Mover el archivo a una ubicación específica
            $file->move(public_path('uploads'), $fileName);

            $nombre = $request->input('nombre');
            $fecha  = $request->input('fecha');
            $tipo   = $request->input('tipo');
            //$origen = 'Bodega';//$request->input('origen');
            $descripcion = $request->input('descripcion');

            $proveedor = $request->input('proveedor');
            $destino   = $request->input('destino');
            $recibe    = $request->input('recibe');
            //$noIngreso = $request->input('noIngreso');
            //$numero    = $request->input('numero');

            $factura   = $request->input('factura');
            if($factura == null){
                $factura = '';
            }

            $n_contrato    = $request->input('n_contrato');


            $counter = Contador::first();

            if (!$counter) {
                $counter = Contador::create([
                    'no_ingreso'  => 0,
                    'no_egreso'   => 0,
                    'no_donacion' => 0,
                    'no_traspaso' => 0,
                ]);
            }

            $acta = Acta::create([
                'nombre'      => $nombre,
                'proveedor'   => $proveedor,
                'fecha'       => $fecha,
                'tipo'        => $tipo,
                'origen'      => $destino,

                'recibe'      => $recibe,
                //'no_ingreso'  => $noIngreso,
                //'numero'      => $numero,
                'factura'     => $factura,
                'n_contrato'  => $n_contrato,
                'id_laboratorio' => $destino,

                'descripcion' => $descripcion, // Usar el valor del formulario
                'total'       => 0,
                'modificar'   => 'false',
            ]);

            if ($tipo === 'I') {

                $noIngreso = 'N-DON-' . ($counter->no_donacion + 1);
                $counter->increment('no_donacion');

            }else if($tipo === 'C'){

                $noIngreso = 'N-INT-' . ($counter->no_ingreso + 1);
                $counter->increment('no_ingreso');

            }

            // Actualiza el registro de Acta
            $acta->update([
                'no_ingreso' => $noIngreso,
                'numero'     => $noIngreso,
            ]);

            $id_acta = $acta->id;

            $acta->save();

            // Importar el archivo usando el nombre único y los datos adicionales
            Excel::import(new ArticulosImport($acta, $destino), public_path('uploads') . '/' . $fileName);

            //ACTUALIZA EL TOTAL
            $sumaTotal = Movimiento::where('id_acta', $acta->id)
            ->sum('precio_total');

            $acta->update(['total' => $sumaTotal]);

            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Datos importados correctamente']);
        } catch (\Exception $e) {
            \DB::rollBack();

            Acta::where('id', $id_acta)->delete(); //si algo sale mal,se elimina el acta

            return response()->json(['success' => false, 'message' => 'Error al importar datos', 'error' => $e->getMessage()]);
        }
    }


    public function report1(Request $request){

        $request->validate([

            'entidad'             => 'required|string',
            'unidadEjecutora'     => 'required|string',
            'unidadDesconcentrada'=> 'required|string',
            'tipoInventario'      => 'required|string',
            'tipoProducto'        => 'required|string',
            'presentacion'        => 'required|string',
            'serieInicial'        => 'string',
            'serieFinal'          => 'string',
            'observaciones'       => 'required|string',
            'inactivo'            => 'required|string',
            'mayor'               => 'required|string',
            'subcuenta1'          => 'required|string',
            'codigoAnterior'      => 'string',
            'estadoProducto'      => 'required|string',

            'idReport1'           => 'required|string',
        ]);


        $filters = $request->only([
            'entidad', 'unidadEjecutora', 'unidadDesconcentrada', 'tipoInventario',
            'tipoProducto', 'presentacion', 'serieInicial', 'serieFinal', 'observaciones',
            'inactivo', 'mayor', 'subcuenta1', 'codigoAnterior', 'estadoProducto',
        ]);

        $filteredFilters = $filters;

        ob_start();
        ob_end_clean();

        Excel::store(new MovimientosExport($filteredFilters, $request->idReport1), 'public/report1.xlsx');
        $fullPath = storage_path('app/public/report1.xlsx');

        //Excel::store(new MovimientosExport($filteredFilters, $request->idReport1), 'public/payments1.xlsx');
        //$fullPath = storage_path('app/public/payments1.xlsx');
        //$relativePath = str_replace(storage_path('app/public/'), '', $fullPath);
        //$fileUrl = asset("storage/{$relativePath}");

        //return response()->json(['url' => $fileUrl]);
        return response()->json(['url' => 'report1.xlsx']);

    }


    public function exportarPlantilla()
    {
        return Excel::download(new IngresoExport(), 'ingreso.xlsx');
    }


    public function report2(Request $request){

        $request->validate([

            'entidadReport2'   => 'required|string',
            'ejecutoraReport2' => 'required|string',
            'desconcenReport2' => 'required|string',
            'actaNReport2'     => 'required|string',
            'codReport2'       => 'required|string',

            'idReport2'        => 'required|string',
        ]);


        $filters = $request->only([
            'entidadReport2', 'ejecutoraReport2', 'desconcenReport2',
            'actaNReport2', 'codReport2'
        ]);

        $filteredFilters = $filters;

        ob_start();
        ob_end_clean();

        //return Excel::download(new IngresoExport(), 'ingreso.xlsx');


        Excel::store(new Movimientos2Export($filteredFilters, $request->idReport2), 'public/report2.xlsx');

        $fullPath = storage_path('app/public/report2.xlsx');
        //$relativePath = str_replace(storage_path('app/public/'), '', $fullPath);
        //$fileUrl = asset("storage/{$relativePath}");


        /*
        $excelFileName = 'report2_' . time() . '.xlsx';
        //Excel::store(new Movimientos2Export($filteredFilters, $request->idReport2), public_path('excel/' . $excelFileName));
        Excel::store(new Movimientos2Export($filteredFilters, $request->idReport2), 'excel/' . $excelFileName);
        $excelUrl = asset("excel/{$excelFileName}");
        return response()->json(['url' => $excelUrl]);
        */

        return response()->json(['url' => 'report2.xlsx']);

    }



    public function report3(Request $request){

        $request->validate([

            'entidadReport3'   => 'required|string',
            'ejecutoraReport3' => 'required|string',
            'desconcenReport3' => 'required|string',
            'tipoPReport3'     => 'required|string',
            'presenReport3'    => 'required|string',
            'obserReport3'     => 'required|string',
            'inactReport3'     => 'required|string',
            'mayorReport3'     => 'required|string',
            'subCuent1Report3' => 'required|string',
            'subCuent2Report3' => 'required|string',
            'estadoReport3'    => 'required|string',
            'idReport3'        => 'required|string',

        ]);


        $filters = $request->only([
            'entidadReport3', 'ejecutoraReport3', 'desconcenReport3',
            'tipoPReport3', 'presenReport3', 'obserReport3',
            'inactReport3', 'mayorReport3', 'subCuent1Report3',
            'subCuent2Report3', 'estadoReport3'
        ]);

        $filteredFilters = $filters;

        ob_start();
        ob_end_clean();

        //return Excel::download(new IngresoExport(), 'ingreso.xlsx');


        Excel::store(new Movimientos3Export($filteredFilters, $request->idReport3), 'public/report3.xlsx');

        $fullPath = storage_path('app/public/report3.xlsx');
        //$relativePath = str_replace(storage_path('app/public/'), '', $fullPath);
        //$fileUrl = asset("storage/{$relativePath}");


        /*
        $excelFileName = 'report2_' . time() . '.xlsx';
        //Excel::store(new Movimientos2Export($filteredFilters, $request->idReport2), public_path('excel/' . $excelFileName));
        Excel::store(new Movimientos2Export($filteredFilters, $request->idReport2), 'excel/' . $excelFileName);
        $excelUrl = asset("excel/{$excelFileName}");
        return response()->json(['url' => $excelUrl]);
        */

        return response()->json(['url' => 'report3.xlsx']);

    }




    public function downloadExcel($fileName)
    {
        //$filePath = public_path('excel/' . $fileName);
        //$filePath = storage_path('app/public/excel/' . $fileName);
        $filePath = storage_path('app/public/' . $fileName);

        // Verificar si el archivo existe
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Descargar el archivo
        return response()->download($filePath);
        //return $filePath;

    }



    /* VISTA - INVENTARIO LABORATORIO */
    public function laboratorio(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $laboratorioId = $request->input('laboratorioId');

        $laboratorios = Crn::where('estado', 'A')->get();
        $categorias = Categoria::select('id', 'nombre')->where('estado', 'A')->get();

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $id_labora = $labora->id;

        if($labora->id == ''){
            $permiso = false;
            $admin = false;
        }else{
            $permiso = true;
            $admin = false;
        }

        $cantKits = Kit::where('cantidad', '')->count();

        if(request()->ajax()) {

            if (isset($laboratorioId)) {
                return datatables()->of(

                    $articulos = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado',
                        DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad',
                        'inv.cantidad as stock', 'lot.f_caduca as f_caduca', 'inv.cant_minima as cant_minima')
                        ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                        ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                        ->join('db_inspi_inventario.inv_lote as lot', 'lot.id_articulo', '=', 'inv_articulo.id')
                        ->join('db_inspi_inventario.inv_inventario as inv', 'inv.id_lote', '=', 'lot.id')
                        ->where('inv_articulo.estado', 'A')
                        ->where('inv.id_laboratorio', $laboratorioId)
                        ->distinct()
                        ->get()

                )
                ->addIndexColumn()
                ->make(true);
            }else{

                return datatables()->of(

                    $articulos = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado',
                        DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad',
                        'inv.cantidad as stock', 'lot.f_caduca as f_caduca', 'inv.cant_minima as cant_minima')
                        ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                        ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                        ->join('db_inspi_inventario.inv_lote as lot', 'lot.id_articulo', '=', 'inv_articulo.id')
                        ->join('db_inspi_inventario.inv_inventario as inv', 'inv.id_lote', '=', 'lot.id')
                        ->where('inv_articulo.estado', 'A')
                        ->where('inv.id_laboratorio', $labora->id)
                        ->distinct()
                        ->get()

                )
                ->addIndexColumn()
                ->make(true);

            }

        }

        //respuesta para la vista
        return view('inventarios.list_inventario_lab', compact('permiso', 'admin', 'laboratorios', 'cantKits', 'id_labora', 'categorias'));
    }
    /* VISTA - INVENTARIO LABORATORIO */




    public function filtrar(Request $request)
    {
        $caducityFilter = $request->input('caducar');
        $stockFilter = $request->input('stock');

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $query = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado',
            DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as abreviatura',
            'inv.cantidad as stock', 'lot.f_caduca as f_caduca', 'inv.cant_minima as cant_minima', 'lot.nombre as lote',
            'uni.nombre as unidad')
            ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_lote as lot', 'lot.id_articulo', '=', 'inv_articulo.id')
            ->join('db_inspi_inventario.inv_inventario as inv', 'inv.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv.id_unidad')
            ->where('inv_articulo.estado', 'A')
            ->where('inv.id_laboratorio', $labora->id);

        // Apply caducity filter
        if ($caducityFilter == 'por_caducar') {
            $query->whereDate('lot.f_caduca', '>=', now())
                ->whereDate('lot.f_caduca', '<=', now()->addMonth(3));
        } elseif ($caducityFilter == 'caducados') {
            $query->whereDate('lot.f_caduca', '<', now());
        }

        // Apply stock filter
        if ($stockFilter == 'minimo') {
            $query->whereColumn('inv.cantidad', '<=', 'inv.cant_minima');
        } elseif ($stockFilter == 'cercano') {
            $query->whereColumn('inv.cantidad', '>', 'inv.cant_minima')
                ->whereRaw('inv.cantidad <= 2 * inv.cant_minima');
        }
            
        $articulos = $query->distinct()->get();

        return response()->json($articulos);
    }





    public function filtrarReporte(Request $request)
    {
        $caducityFilter = $request->input('caducar');
        $stockFilter = $request->input('stock');

        $filtro1 = '';
        $filtro2 = '';

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $labora->id)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        //$laboratorioId = auth()->user()->laboratorio_id; // Or however you get the lab ID

        $query = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado',
            DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as abreviatura',
            'inv.cantidad as stock', 'lot.f_caduca as f_caduca', 'inv.cant_minima as cant_minima', 'lot.nombre as lote',
            'uni.nombre as unidad', DB::raw('DATEDIFF(lot.f_caduca, CURDATE()) as dias_para_caducar'))
            ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_lote as lot', 'lot.id_articulo', '=', 'inv_articulo.id')
            ->join('db_inspi_inventario.inv_inventario as inv', 'inv.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv.id_unidad')
            ->where('inv_articulo.estado', 'A')
            ->where('inv.id_laboratorio', $labora->id);

        // Apply caducity filter
        if ($caducityFilter == 'por_caducar') {
            $query->whereDate('lot.f_caduca', '>=', now())
                ->whereDate('lot.f_caduca', '<=', now()->addMonth(3));
            $filtro1 = 'Por caducar (próximos 3 meses)';
        } elseif ($caducityFilter == 'caducados') {
            $query->whereDate('lot.f_caduca', '<', now());
            $filtro1 = 'Caducados ';
        }else{
            $filtro1 = 'Todos ';
        }

        // Apply stock filter
        if ($stockFilter == 'minimo') {
            $query->whereColumn('inv.cantidad', '<=', 'inv.cant_minima');
            $filtro2 = 'Stock mínimo ';
        } elseif ($stockFilter == 'cercano') {
            $query->whereColumn('inv.cantidad', '>', 'inv.cant_minima')
                ->whereRaw('inv.cantidad <= 2 * inv.cant_minima');
            $filtro2 = 'Cercano al stock mínimo ';
        }else{
            $filtro2 = 'Todos los niveles de stock ';
        }
            

        $articulos = $query->distinct()->get();

        $fecha = date("d-m-Y");
        $pdf = \PDF::loadView('pdf.pdf_inventario_reporte', ['fecha' => $fecha, 'results' => $results, 'articulos' => $articulos,
                    'filtro1' => $filtro1, 'filtro2' => $filtro2])->setPaper('a4', 'landscape');
        return $pdf->download('pdf_inventario_reporte.pdf');

    }






    /* VISTA - INVENTARIO LABORATORIO */
    public function bodega(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        //$laboratorios = Laboratorio::where('estado', 'A')->get();
        $categorias = Categoria::select('id', 'nombre')->where('estado', 'A')->get();

        $id_labora = 6;
        //$cantKits = Kit::where('cantidad', '')->count();

        if(request()->ajax()) {

            return datatables()->of(

                $articulos = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado',
                    DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad',
                    'inv.cantidad as stock', 'lot.f_caduca as f_caduca', 'inv.cant_minima as cant_minima')
                    ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                    ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                    ->join('db_inspi_inventario.inv_lote as lot', 'lot.id_articulo', '=', 'inv_articulo.id')
                    ->join('db_inspi_inventario.inv_inventario as inv', 'inv.id_lote', '=', 'lot.id')
                    ->where('inv_articulo.estado', 'A')
                    ->where('inv.id_laboratorio', $id_labora)
                    ->distinct()
                    ->get()

            )
            ->addIndexColumn()
            ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_inventario_bodega', compact('categorias', 'id_labora'));
    }
    /* VISTA - INVENTARIO LABORATORIO */




    /* VISTA - CREAR NUEVO EGRESO */
    public function crearEgreso(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $Modulos = PermisoRolOpcion::select('inspi_modulos.id as id',
                                            'inspi_modulos.nombre as nombre',
                                            'inspi_modulos.estado as estado')->distinct()
        ->join('inspi_opciones', 'inspi_opciones.id', '=', 'inspi_rol_opcion.opcion_id')
        ->join('inspi_modulos', 'inspi_modulos.id', '=', 'inspi_opciones.id_modulo')
        ->join('role_user', 'role_user.role_id', '=', 'inspi_rol_opcion.role_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->join('users', 'users.id', '=', 'role_user.user_id')
        ->whereNotIn('inspi_modulos.estado', ['E', 'I'])->whereIn('users.id', [Auth::id()])
        ->get();

        $Opciones = PermisoRolOpcion::select('inspi_opciones.id as id',
                                                'inspi_opciones.id_modulo as id_modulo',
                                                'inspi_opciones.nombre as nombre',
                                                'inspi_opciones.controller as controller',
                                                'inspi_opciones.icon as icon',
                                                'inspi_opciones.estado as estado')->distinct()
        ->join('inspi_opciones', 'inspi_opciones.id', '=', 'inspi_rol_opcion.opcion_id')
        ->join('role_user', 'role_user.role_id', '=', 'inspi_rol_opcion.role_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->join('users', 'users.id', '=', 'role_user.user_id')
        ->whereNotIn('inspi_opciones.estado', ['E', 'I'])->whereIn('users.id', [Auth::id()])
        ->get();

        $usuarioInf = User::select('db_inspi.r.name as role_name', 'db_inspi.ar.id as id_area')
        ->join('db_inspi.role_user as ro', 'users.id', '=', 'ro.user_id')
        ->join('db_inspi.roles as r', 'r.id', '=', 'ro.role_id')
        ->join('db_inspi.inspi_area as ar', 'ar.id', '=', 'users.id_area')
        ->where('users.id', '=', $id_usuario)
        //->whereIn('r.name', ['Gerente', 'Secretaria'])
        ->first();

        //obtener laboratorio
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        $laboratorios = Laboratorio::where('estado', 'A')->get();

        $cantKits = Kit::where('cantidad', '')->count();

        if(request()->ajax()) {

            return datatables()->of($categoria = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado', 'inv_articulo.precio as precio',
                                    DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad')
                                    ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                                    ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                                    ->where('inv_articulo.estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.create_egreso', compact('Modulos','Opciones', 'unidades', 'categorias', 'laboratorios', 'cantKits', 'labora'));
    }
    /* VISTA - CREAR NUEVO EGRESO */



    /* TRAER ARTÍCULOS POR LABORATORÍO EXANTEMATICOS */
    public function obtenerArticulosExa()
    {

        $id_usuario = Auth::user()->id;

        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        $articulos = Articulo::select('inv_articulo.id', 'inv_articulo.nombre', 'inv_articulo.subcategoria')
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            ->where('db_inspi_inventario.inv_categoria.nombre', '=', 'Reactivo')
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_kit.cantidad', '!=', '')
            ->get();

        return response()->json($articulos);

    }
    /* TRAER ARTÍCULOS POR LABORATORÍO EXANTEMATICOS */



    /* TRAER ARTÍCULOS POR LABORATORÍO */
    public function obtenerArticulosLab()
    {

        $id_usuario = Auth::user()->id;

        /*
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();
        */

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $articulos = Articulo::select('inv_articulo.id', 'inv_articulo.nombre')
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            //->where('db_inspi_inventario.inv_categoria.nombre', '=', 'Reactivo') // solo trae los reactivos
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->get();

        return response()->json($articulos);

    }
    /* TRAER ARTÍCULOS POR LABORATORÍO */



    /* TRAER ARTÍCULOS POR LABORATORÍO */
    public function obtenerArticulosCate($id_categoria)
    {

        $id_usuario = Auth::user()->id;

        /*
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();
        */

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $articulos = Articulo::select('inv_articulo.id', /*'inv_kit.valor', 'inv_inventario.cantidad',*/
            DB::raw('IF(inv_articulo.descripcion = "", inv_articulo.nombre, inv_articulo.descripcion) as nombre'))
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
            ->join('db_inspi_inventario.inv_prueba_articulo', 'inv_prueba_articulo.id_articulo', '=', 'inv_articulo.id')
            ->join('db_inspi_inventario.inv_prueba', 'inv_prueba.id', '=', 'inv_prueba_articulo.id_prueba')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            ->where('db_inspi_inventario.inv_prueba_articulo.id_prueba', '=', $id_categoria)
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_prueba_articulo.estado', '=', 'A')
            ->get();

        return response()->json($articulos);

    }
    /* TRAER ARTÍCULOS POR LABORATORÍO */



    /* TRAER EXAMENES POR LABORATORÍO */
    public function obtenerExamenLab()
    {

        $id_usuario = Auth::user()->id;

        /*
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();
        */
        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $examenes = Examen::select('id', 'nombre')
            ->where('laboratorio_id', '=', $labora->id)
            ->get();

        return response()->json($examenes);

    }
    /* TRAER EXAMENES POR LABORATORÍO */


    /* TRAER CONTROLES POR LABORATORÍO */
    public function obtenerControlLab()
    {

        $id_usuario = Auth::user()->id;

        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        $controles = Controles::select('id', 'nombre')
            ->where('laboratorio_id', '=', $labora->id)
            ->get();

        return response()->json($controles);

    }
    /* TRAER CONTROLES POR LABORATORÍO */


    /* TRAER ARTÍCULO POR ID LABORATORIO */
    public function articuloLoteIdLab(Request $request)
    {

        $id_articulo = $request->query('id_articulo');
        $id_laboratorio = $request->query('id_laboratorio');

        $id_usuario = Auth::user()->id;

        $unidades = Articulo::select('uni.nombre', 'uni.abreviatura')
            ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id')
            ->where('inv_articulo.id', $id_articulo)
            ->where('inv_articulo.estado', 'A')->first();


        $resultados = Lote::select('inv_lote.id', 'inv_lote.nombre', 'inv_lote.f_caduca')
            ->join('db_inspi_inventario.inv_articulo', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->where('db_inspi_inventario.inv_articulo.id', '=', $id_articulo)
            //->where('db_inspi_inventario.inv_categoria.nombre', '=', 'Reactivo')
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $id_laboratorio)
            ->get();

        //return response()->json($unidad);
        return response()->json(['resultados' => $resultados, 'unidades' => $unidades]);

    }
    /* TRAER ARTÍCULO POR ID LABORATORIO */


    /* TRAER ARTÍCULO */
    public function articuloLote($id)
    {

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $unidades = Articulo::select('uni.nombre', 'uni.abreviatura')
            ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id')
            ->where('inv_articulo.id', $id)
            ->where('inv_articulo.estado', 'A')->first();


        $resultados = Lote::select('inv_lote.id', 'inv_lote.nombre', 'inv_lote.f_caduca')
            ->join('db_inspi_inventario.inv_articulo', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->where('db_inspi_inventario.inv_articulo.id', '=', $id)
            //->where('db_inspi_inventario.inv_categoria.nombre', '=', 'Reactivo')
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->crns_id)
            ->get();

        //return response()->json($unidad);
        return response()->json(['resultados' => $resultados, 'unidades' => $unidades]);

    }
    /* TRAER ARTÍCULO */


    /* TRAER ARTÍCULO EXANTEMATICOS */
    public function articuloLoteExa($id)
    {

        $unidades = Articulo::select('uni.nombre', 'uni.abreviatura')
            ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
            ->where('inv_articulo.id', $id)
            ->where('inv_articulo.estado', 'A')->first();


        $resultados = Lote::select('inv_lote.id', 'inv_lote.nombre', 'inv_lote.f_caduca')
            ->join('db_inspi_inventario.inv_articulo', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
            ->where('db_inspi_inventario.inv_articulo.id', '=', $id)
            ->where('db_inspi_inventario.inv_categoria.nombre', '=', 'Reactivo')
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_kit.cantidad', '!=', '')
            ->get();

        return response()->json(['resultados' => $resultados, 'unidades' => $unidades]);

    }
    /* TRAER ARTÍCULO EXANTEMATICOS */



    /* TRAER UNIDADES POR LOTE */
    public function unidadLote($id)
    {

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                'inv_lote.f_elabora', 'inv_kit.valor')
            ->join('db_inspi_inventario.inv_lote', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
            ->where('inv_lote.id', '=', $id)
            ->where('inv_inventario.id_laboratorio', '=', $labora->crns_id)
            ->first();

        return response()->json(['movimientos' => $movimientos]);

    }
    /* TRAER UNIDADES POR LOTE */


    /* TRAER UNIDADES POR LOTE Y ID_LABORATORIO */
    public function unidadLoteIdLab(Request $request)
    {

        $id_lote = $request->query('id_lote');
        $id_laboratorio = $request->query('id_laboratorio');

        $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                'inv_lote.f_elabora', 'inv_kit.valor', 'uni.abreviatura', 'uni.nombre')
            ->join('db_inspi_inventario.inv_lote', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
            ->join('inv_unidad as uni', 'uni.id', '=', 'inv_inventario.id_unidad')
            ->where('inv_lote.id', '=', $id_lote)
            ->where('inv_inventario.id_laboratorio', '=', $id_laboratorio)
            ->first();

        return response()->json(['movimientos' => $movimientos]);

    }
    /* TRAER UNIDADES POR LOTE Y ID_LABORATORIO */


    /* TRAER LAS MUESTRAS POR LABORATORIO */
    public function muestrasLaborat($id)
    {

        $muestras = Muestra::where('laboratorio_id', '=', $id)->get();
        return response()->json(['muestras' => $muestras]);

    }
    /* TRAER LAS MUESTRAS POR LABORATORIO */


    /* GUARDAR MOVIMIENTO EGRESO */
    public function saveMovimientoEgre(Request $request)
    {

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'descripcion' => 'required|string',
            'arraryData'  => 'required|array',
        ]);


        $movimientos = $request->arraryData;

        foreach ($movimientos as $movimiento) {

            $id_movimiento = $movimiento['id_inventario'];
            $rt = $movimiento['rt'];
            $rt = is_numeric($rt) ? (int)$rt : 0;

            $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                'inv_kit.cant_actual as cant_actual')
                ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
                ->where('inv_inventario.id', '=', $id_movimiento)
                ->first();

            $id_inv      = $movimientos->id;
            $unidades    = $movimientos->unidades;
            $unidades = is_numeric($unidades) ? (int)$unidades : 0;

            $cantidad    = $movimientos->cantidad;
            $cantidad = is_numeric($cantidad) ? (int)$cantidad : 0;

            $id_kit      = $movimientos->id_kit;
            $cant_actual = $movimientos->cant_actual;
            $cant_actual = is_numeric($cant_actual) ? (int)$cant_actual : 0;

            $result = $cant_actual - $rt;

            if ($result < 0) {

                $result = abs($result);

                $cantidad_total_unidades = $rt; // La cantidad total de unidades consumidas
                $unidades_por_reactivo   = $cantidad; // La cantidad de unidades por reactivo

                // Calcula cuántos reactivos completos has consumido
                $cantidad_reactivos_consumidos = floor($cantidad_total_unidades / $unidades_por_reactivo);

                // Calcula cuántas unidades de un reactivo tienes aún
                $unidades_restantes = $cantidad_total_unidades % $unidades_por_reactivo;


                //actualiza inventario
                $kits = Kit::find($id_kit);
                $kits->cant_actual = $kits->cant_actual - $unidades_restantes;
                $kits->consumido   = $rt + $kits->consumido;

                $kits->save();

                //actualiza inventario
                $inventa = Inventario::find($id_movimiento);
                $inventa->cantidad    = $inventa->cantidad  - $cantidad_reactivos_consumidos;

                $inventa->save();

            }else{

                $kits = Kit::find($id_kit);
                $kits->cant_actual = $result;
                $kits->consumido   = $rt + $kits->consumido;

            }

        }

        if ($kits) {

            return response()->json(['message' => 'Corrida guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear la corrida', 'data' => false], 500);

        }

    }
    /* GUARDAR MOVIMIENTO EGRESO */



    /* VISTA - CREAR TRANSFERENCIA DE REACTIVOS A LOS LABORATORIOS */
    public function createTransferencia(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        $laboratorios = Crn::where('estado', 'A')->get();

        $cantKits = Kit::where('cantidad', '')->count();

        if(request()->ajax()) {

            return datatables()->of($categoria = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado', 'inv_articulo.precio as precio',
                                    DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad')
                                    ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                                    ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                                    ->where('inv_articulo.estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.create_transferencia', compact('unidades', 'categorias', 'laboratorios', 'cantKits'));
    }
    /* VISTA - CREAR TRANSFERENCIA DE REACTIVOS A LOS LABORATORIOS */


    /* GUARDAR TRANSFERENCIA */
    public function saveTransferencia(Request $request)
    {
        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'destino'     => 'required|string',
            'descripcion' => 'required|string',
            'arraryData'  => 'required|array',
        ]);

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        /*
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();
        */


        $counter = Contador::first();

        if (!$counter) {
            $counter = Contador::create([
                'no_ingreso'  => 0,
                'no_egreso'   => 0,
                'no_donacion' => 0,
                'no_traspaso' => 0,
            ]);
        }

        $tipoMovimi = $request->tipo;
        $nameMovi = '';
        $numero   = '';
        $origen   = '';
        $total_acta = 0;

        if($tipoMovimi == 'E'){
            $nameMovi = 'Egreso';
            $numero = 'N-OUT-' . ($counter->no_egreso + 1);
            $counter->increment('no_egreso');

            //si es egreso, solo se crea un egreso
            //$origen = $request->destino;
            $origen = $labora->id;

        }else if($tipoMovimi == 'T'){
            $nameMovi = 'Traspaso';
            $numero = 'N-TRA-' . ($counter->no_traspaso + 1);
            $counter->increment('no_traspaso');

            //si es traspaso, se crea un ingreso y un egreso
            $origen = $labora->id;


        }else{
            $nameMovi = 'Movimiento';
        }


        $acta = Acta::create([
            'nombre'      => $request->nombre,
            'proveedor'   => 'N/A',
            'fecha'       => $request->fecha,
            'tipo'        => $request->tipo,
            'origen'      => $origen,

            'recibe'      => 'N/A',
            'id_laboratorio' => $request->destino,
            'no_ingreso'  => $numero,
            'numero'      => $numero,

            'descripcion' => $request->descripcion,
            'total'       => 0,
            'transferible' => 'true',
        ]);

        $actaId = $acta->id;

        $movimientos = $request->input('arraryData');

        foreach ($movimientos as $movimiento) {

            $precio = 0;
            $unidad = 0;
            //$uTotal = 0;

            $unidad   = $movimiento['unidad'];
            $id_inventario = $movimiento['movimiento'];
            $uTotal        = $movimiento['uTotal'];
            $id_lote       = $movimiento['lote'];
            $id_articulo   = $movimiento['id_articulo'];

            //trae el id_lote
            $datoMovimiento = Movimiento::select('precio', 'uni_medida', 'id_acta')->where('id_lote', $id_lote)->first();

            //si se toma un articulo de un acta con transferencia rapida, se elimina la transferencia rapida
            if ($datoMovimiento) {
                $actaTransferencia = Acta::where('id', $datoMovimiento->id_acta)->first();
            
                if ($actaTransferencia && $actaTransferencia->transferible == 'false') {
                    $actaTransferencia->transferible = 'true';
                    $actaTransferencia->save();
                }
            }

            $datoInven = Inventario::where('id', $id_inventario)->first();

            $precio = is_numeric($datoMovimiento->precio) ? (int)$datoMovimiento->precio : 0;
            $unidad = is_numeric($unidad) ? (int)$unidad : 0;

            $uniActual = (int)$unidad * -1;

            $costoTotal = $precio * $unidad;
            $total_acta = $costoTotal + $total_acta;

            // Calcular saldo inicial y final para el origen
            $saldo_ini = $datoInven ? $datoInven->cantidad : 0;
            // $saldo_fin = $saldo_ini - $uniActual;
            $saldo_fin = $saldo_ini - $unidad;

            $movimientoCreate = Movimiento::create([
                'id_usuario'   => $id_usuario,
                'id_lote'      => $id_lote,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'saldo_ini'    => $saldo_ini,
                'saldo_fin'    => $saldo_fin,
                'id_acta'      => $actaId,
            ]);


            // ================= se guarda un registro para ver el movimiento en articulos
            $inventarioExistenteArt = Inventario::join('inv_lote as lote', 'inv_inventario.id_lote', '=', 'lote.id')
                ->where('lote.id_articulo', $id_articulo)
                ->where('inv_inventario.id_laboratorio', $labora->id)
                ->where('inv_inventario.id_unidad', $datoMovimiento->uni_medida)
                ->sum('inv_inventario.cantidad');

            //Determinar el saldo inicial
            $saldoInicialArt = $inventarioExistenteArt ? $inventarioExistenteArt : 0;

            //Calcular el saldo final
            $saldoFinalArt = $saldoInicialArt - $unidad;
            $movimientoArtCreate = MovimientoArticulo::create([
                'id_usuario'   => $id_usuario,
                'id_articulo'  => $id_articulo,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'id_acta'      => $actaId,
                'saldo_ini'    => $saldoInicialArt,
                'saldo_fin'    => $saldoFinalArt,
            ]);
            // ================= 


            //se crea o se actualiza el registro dependiendo de la transferencia
            //Inventario::actualizarInventario($id_lote, $unidad, $request->destino, $datoInven->id_unidad);

            //se actualiza el registro existente
            Inventario::actualizarInventario($id_lote, $uniActual, $labora->id, $datoInven->id_unidad);

        }
        //se actualiza el total
        $acta->update([
            'total' => $total_acta,
        ]);



        // ==================================================================
        //ahora se hace el mismo movimiento para que se vea la transferencia a otra area o laboratorio

        $tipoMovimi = $request->tipo;
        $numero   = '';
        $origen   = '';
        $total_acta = 0;

        $numero = 'N-INT-' . ($counter->no_ingreso + 1);
        $counter->increment('no_ingreso');

        $acta = Acta::create([
            'nombre'      => $request->nombre,
            'proveedor'   => 'N/A',
            'fecha'       => $request->fecha,
            'tipo'        => 'C',
            'origen'      => $request->destino,

            'recibe'      => 'N/A',
            'id_laboratorio' => $request->destino,
            'no_ingreso'  => $numero,
            'numero'      => $numero,

            'descripcion' => 'Ingreso '. date('Y-m-d'),
            'total'       => 0,
            'transferible' => 'true',
        ]);

        $actaId = $acta->id;

        $movimientos = $request->input('arraryData');

        foreach ($movimientos as $movimiento) {

            $precio = 0;
            $unidad = 0;
            //$uTotal = 0;

            $unidad   = $movimiento['unidad'];
            $id_inventario = $movimiento['movimiento'];
            $uTotal        = $movimiento['uTotal'];
            $id_lote       = $movimiento['lote'];
            $id_articulo   = $movimiento['id_articulo'];

            //trae el id_lote
            $datoMovimiento = Movimiento::select('precio', 'uni_medida')->where('id_lote', $id_lote)->first();

            //$datoInven = Inventario::where('id', $id_inventario)->first();
            $datoInven = Inventario::join('inv_lote as lote', 'inv_inventario.id_lote', '=', 'lote.id')
                ->where('lote.id', $id_lote)
                ->where('inv_inventario.id_laboratorio', $request->destino)
                ->where('inv_inventario.id_unidad', $datoMovimiento->uni_medida)
                ->sum('inv_inventario.cantidad');

            $precio = is_numeric($datoMovimiento->precio) ? (int)$datoMovimiento->precio : 0;
            $unidad = is_numeric($unidad) ? (int)$unidad : 0;

            $uniActual = (int)$unidad;

            $costoTotal = $precio * $unidad;
            $total_acta = $costoTotal + $total_acta;

            // Calcular saldo inicial y final para el origen
            $saldo_ini = $datoInven ? $datoInven->cantidad : 0;
            // $saldo_fin = $saldo_ini - $uniActual;
            $saldo_fin = $saldo_ini + $unidad;

            $movimientoCreate = Movimiento::create([
                'id_usuario'   => $id_usuario,
                'id_lote'      => $id_lote,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'saldo_ini'    => $saldo_ini,
                'saldo_fin'    => $saldo_fin,
                'id_acta'      => $actaId,
            ]);


            // ================= se guarda un registro para ver el movimiento en articulos
            $inventarioExistenteArt = Inventario::join('inv_lote as lote', 'inv_inventario.id_lote', '=', 'lote.id')
                ->where('lote.id_articulo', $id_articulo)
                ->where('inv_inventario.id_laboratorio', $request->destino)
                ->where('inv_inventario.id_unidad', $datoMovimiento->uni_medida)
                ->sum('inv_inventario.cantidad');

            //Determinar el saldo inicial
            $saldoInicialArt = $inventarioExistenteArt ? $inventarioExistenteArt : 0;

            //Calcular el saldo final
            $saldoFinalArt = $saldoInicialArt + $unidad;
            $movimientoArtCreate = MovimientoArticulo::create([
                'id_usuario'   => $id_usuario,
                'id_articulo'  => $id_articulo,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'id_acta'      => $actaId,
                'saldo_ini'    => $saldoInicialArt,
                'saldo_fin'    => $saldoFinalArt,
            ]);
            // ================= 


            //se crea o se actualiza el registro dependiendo de la transferencia
            Inventario::actualizarInventario($id_lote, $unidad, $request->destino, $datoMovimiento->uni_medida);

            //se actualiza el registro existente
            //Inventario::actualizarInventario($id_lote, $uniActual, $labora->id, $datoInven->id_unidad);

        }
        //se actualiza el total
        $acta->update([
            'total' => $total_acta,
        ]);

        // ==================================================================


        if ($acta) {

            return response()->json(['message' => 'Movimiento de '.$nameMovi.' guardado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear el '.$nameMovi, 'data' => false], 500);

        }

    }
    /* GUARDAR TRANSFERENCIA */


    /* EDITAR TRANSFERENCIA - EGRESO */
    public function editTransferencia(Request $request)
    {

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_acta'     => 'required|string',
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'destino'     => 'required|string',
            'descripcion' => 'required|string',
            'arraryData'  => 'required|array',
        ]);

        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();


        $counter = Contador::first();

        if (!$counter) {
            $counter = Contador::create([
                'no_ingreso'  => 0,
                'no_egreso'   => 0,
                'no_donacion' => 0,
                'no_traspaso' => 0,
            ]);
        }

        $tipoMovimi = $request->tipo;
        $nameMovi = '';
        $numero   = '';
        if($tipoMovimi == 'E'){
            $nameMovi = 'Egreso';
            $numero = 'N-OUT-' . ($counter->no_egreso + 1);
            $counter->increment('no_egreso');
        }else if($tipoMovimi == 'T'){
            $nameMovi = 'Traspaso';
            $numero = 'N-TRA-' . ($counter->no_traspaso + 1);
            $counter->increment('no_traspaso');
        }else{
            $nameMovi = 'Movimiento';
        }

        $acta = Acta::find($request->id_acta); // Reemplaza $id_acta con el ID del registro que quieres actualizar

        if ($acta) {
            $acta->update([
                'nombre'         => $request->nombre,
                'proveedor'      => 'N/A',
                'fecha'          => $request->fecha,
                'tipo'           => $request->tipo,
                'origen'         => $labora->id,
                'recibe'         => 'N/A',
                'descripcion'    => $request->descripcion,
                'factura'        => 'N/A',
                'n_contrato'     => 'N/A',
                'total'          => $request->total,
                'id_laboratorio' => $request->destino,
            ]);
        }

        $movimientos = $request->input('arraryData');

        foreach ($movimientos as $movimiento) {

            $precio = 0;
            $unidad = 0;

            $id_movimiento = $movimiento['id_movimiento'];
            $unidad        = $movimiento['unidad'];
            $id_inventario = $movimiento['id_inventario'];
            $uTotal        = $movimiento['uTotal'];
            $id_lote       = $movimiento['lote'];
            $id_articulo   = $movimiento['id_articulo'];

            if($id_movimiento == '0'){

                $precio = 0;
                $unidad = 0;

                $unidad   = $movimiento['unidad'];
                $id_inventario = $movimiento['movimiento'];
                $uTotal        = $movimiento['uTotal'];
                $id_lote       = $movimiento['lote'];
                $id_articulo   = $movimiento['id_articulo'];

                $datoMovimiento = Movimiento::select('precio', 'uni_medida')->where('id_lote', $id_lote)->first();
                $datoInven = Inventario::where('id', $id_inventario)->first();

                $precio = is_numeric($datoMovimiento->precio) ? (int)$datoMovimiento->precio : 0;
                $unidad = is_numeric($unidad) ? (int)$unidad : 0;

                $uniActual = (int)$unidad * -1;

                $costoTotal = $precio * $unidad;

                $movimientoCreate = Movimiento::create([
                    'id_usuario'   => $id_usuario,
                    'id_lote'      => $id_lote,
                    'unidades'     => $unidad, //cantidad
                    'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                    'precio'       => $precio,  //precio unitario
                    'precio_total' => $costoTotal,  //precio total
                    'id_acta'      => $actaId,
                ]);

                //se crea o se actualiza el registro dependiendo de la transferencia
                Inventario::actualizarInventario($id_lote, $unidad, $request->destino, $datoInven->id_unidad);

                //se actualiza el registro existente
                Inventario::actualizarInventario($id_lote, $uniActual, $labora->id, $datoInven->id_unidad);

            }else{

                $mov = Movimiento::find($id_movimiento);
                $datoInven = Inventario::where('id', $id_inventario)->first();

                //actualiza el inventario dependiendo de la transacción
                $unidadesAntiguas = $mov->unidades;
                $diferenciaUnidades = $unidad - $unidadesAntiguas;

                $precio = is_numeric($mov->precio) ? (int)$mov->precio : 0;
                $unidad = is_numeric($unidad) ? (int)$unidad : 0;

                $uniActual = (int)$diferenciaUnidades * -1;

                $costoTotal = $precio * $unidad;

                if ($mov) {
                    $mov->update([
                        'id_usuario'   => $id_usuario,
                        'id_lote'      => $id_lote,
                        'unidades'     => $unidad,
                        'uni_medida'   => $mov->uni_medida,
                        'precio'       => $precio,
                        'precio_total' => $costoTotal,
                        //'id_acta'      => $actaId,
                    ]);
                }

                // Aumentar o disminuir inventario según la diferencia
                if ($diferenciaUnidades > 0) {
                    //se crea o se actualiza el registro dependiendo de la transferencia
                    Inventario::actualizarInventario($id_lote, $diferenciaUnidades, $request->destino, $datoInven->id_unidad);
                    //se actualiza el registro existente
                    Inventario::actualizarInventario($id_lote, $uniActual, $labora->id, $datoInven->id_unidad);

                } elseif ($diferenciaUnidades < 0) {
                    // Disminuir inventario
                    Inventario::actualizarInventario($id_lote, $diferenciaUnidades, $request->destino, $datoInven->id_unidad);
                    //se actualiza el registro existente
                    Inventario::actualizarInventario($id_lote, $uniActual, $labora->id, $datoInven->id_unidad);

                }

            }

        }

        if ($acta) {

            return response()->json(['message' => 'Movimiento de '.$nameMovi.' editado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al editar el '.$nameMovi, 'data' => false], 500);

        }

    }
    /* EDITAR TRANSFERENCIA - EGRESO */



    /* GENERAR PDF IN */
    public function generatePDF_IN( Request $request )
    {

        $id_acta = $request->query('id_acta');

        $acta = Acta::select('inv_acta.nombre', 'inv_acta.proveedor', 'inv_acta.fecha', 'inv_acta.tipo', 'inv_acta.origen', 'inv_acta.recibe'
            ,'inv_acta.no_ingreso', 'inv_acta.numero', 'inv_acta.factura', 'inv_acta.descripcion', 'lab.nombre as laboratorio', 'inv_acta.n_contrato')
        ->join('db_inspi.inspi_laboratorio as lab', 'lab.id', '=', 'inv_acta.id_laboratorio')
        ->where('inv_acta.id', $id_acta)
        ->first();

        $movimiento = Movimiento::select('art.nombre', 'inv_movimiento.unidades', 'uni.nombre as uniNombre', 'lot.caduca as caduca',
        'lot.f_elabora as fecha_ela', 'lot.f_caduca as fecha_cad', 'lot.nombre as lote', 'inv_movimiento.precio as precio',
        'inv_movimiento.precio_total as total')
        ->join('inv_lote as lot', 'lot.id', '=', 'inv_movimiento.id_lote')
        ->join('inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
        ->join('inv_unidad as uni', 'uni.id', '=', 'art.id_unidad')
        ->where('inv_movimiento.id_acta', $id_acta)
        ->get();

        $datosActa = $acta->toArray();

        $pdf = \PDF::loadView('pdf.ingresos_in', ['datosActa' => $datosActa, 'datosMovimiento' => $movimiento]);

        return $pdf->download('ingresos_in.pdf');
    }
    /* GENERAR PDF IN */



    /* GENERAR PDF OUT */
    public function generatePDF_OUT( Request $request )
    {

        $id_acta = $request->query('id_acta');

        $acta = Acta::select('inv_acta.nombre', 'inv_acta.fecha', 'inv_acta.tipo', 'inv_acta.origen'
        ,'inv_acta.numero', 'inv_acta.descripcion', 'lab.nombre as laboratorio')
        ->join('db_inspi.inspi_laboratorio as lab', 'lab.id', '=', 'inv_acta.id_laboratorio')
        // ->join('db_inspi.users as usu', 'usu.id', '=', 'inv_acta.recibe')
        ->where('inv_acta.id', $id_acta)
        ->first();


        $movimiento = Movimiento::select('art.nombre', 'inv_movimiento.unidades', 'uni.nombre as uniNombre', 'lot.nombre as lote')
        ->join('inv_lote as lot', 'lot.id', '=', 'inv_movimiento.id_lote')
        ->join('inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
        ->join('inv_unidad as uni', 'uni.id', '=', 'art.id_unidad')
        ->where('inv_movimiento.id_acta', $id_acta)
        ->get();

        $datosActa = $acta->toArray();

        $pdf = \PDF::loadView('pdf.egresos_out', ['datosActa' => $datosActa, 'datosMovimiento' => $movimiento]);

        //$pdf = \Barryvdh\DomPDF\Facade::loadView('pdf.ejemplo');

        return $pdf->download('egresos_out.pdf');
    }
    /* GENERAR PDF OUT */

    //===============================================================================================================


    public function generatePDF_AJ( Request $request )
    {

        $id_acta = $request->query('id_acta');

        $acta = Acta::select('inv_acta.nombre', 'inv_acta.fecha', 'inv_acta.tipo', 'inv_acta.origen'
        ,'inv_acta.numero', 'inv_acta.descripcion', 'lab.nombre as laboratorio','inv_acta.transaccion')
        ->join('db_inspi.inspi_laboratorio as lab', 'lab.id', '=', 'inv_acta.id_laboratorio')
        // ->join('db_inspi.users as usu', 'usu.id', '=', 'inv_acta.recibe')
        ->where('inv_acta.id', $id_acta)
        ->first();


        $movimiento = Movimiento::select('art.nombre', 'inv_movimiento.unidades', 'uni.nombre as uniNombre', 'lot.nombre as lote')
        ->join('inv_lote as lot', 'lot.id', '=', 'inv_movimiento.id_lote')
        ->join('inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
        ->join('inv_unidad as uni', 'uni.id', '=', 'art.id_unidad')
        ->where('inv_movimiento.id_acta', $id_acta)
        ->get();

        $datosActa = $acta->toArray();

        $pdf = \PDF::loadView('pdf.pdfAjuste', ['datosActa' => $datosActa, 'datosMovimiento' => $movimiento]);

        //$pdf = \Barryvdh\DomPDF\Facade::loadView('pdf.ejemplo');

        return $pdf->download('pdfAjuste.pdf');
    }
    /* GENERAR PDF OUT */

    //==============================================================================================================


    /* GENERAR PDF  */
    public function pdf( Request $request )
    {

        $pdf = \PDF::loadView('pdf.pdfexantematico');

        return $pdf->download('pdf.pdf');
    }
    /* GENERAR PDF  */



    /* VISTA - INVENTARIO LABORATORIO - PRUEBAS */
    public function agregarUnidades(){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $laboratorios = CRN::where('estado', 'A')->get();

        /*
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();
        */

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $laboratorio_id = $labora->id;
        if($labora->id == ''){
            $permiso = false;
            $admin = false;
        }else{
            $permiso = true;
            $admin = false;
        }

        $cantKits = Kit::where('cantidad', '')->count();

        $articulos = Articulo::select('inv_articulo.id', 'inv_articulo.nombre',
             DB::raw('IF(inv_articulo.descripcion = "", inv_articulo.nombre, inv_articulo.descripcion) as nombre'))
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            //->where('db_inspi_inventario.inv_categoria.nombre', '=', 'Reactivo')
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->get();

        //traer articulos
        $articulosList = Articulo::select('inv_articulo.id', 'inv_articulo.nombre', 'inv_prueba.id as id_prueba',
            DB::raw('IF(inv_articulo.descripcion = "", inv_articulo.nombre, inv_articulo.descripcion) as nombre'))
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_prueba_articulo', 'inv_prueba_articulo.id_articulo', '=', 'inv_articulo.id')
            ->join('db_inspi_inventario.inv_prueba', 'inv_prueba.id', '=', 'inv_prueba_articulo.id_prueba')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_prueba_articulo.estado', '=', 'A')
            ->get();

        //traemos las pruebas 
        $pruebasLab = Prueba::select('id', 'id_laboratorio', 'nombre', 'descripcion', 'estado')
            ->where('id_laboratorio', '=', $labora->id)
            ->where('estado', '=', 'A')
            ->get();


        if(request()->ajax()) {

            return datatables()->of(
                            $consulta = Inventario::join('inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                                ->join('db_inspi_inventario.inv_unidad as uni', 'art.id_unidad', '=', 'uni.id')
                                ->join('db_inspi_inventario.inv_categoria as cat', 'art.id_categoria', '=', 'cat.id')
                                ->join('db_inspi_inventario.inv_kit as kit', 'inv_inventario.id', '=', 'kit.id_inventario')
                                ->select('lot.nombre as name_lote', 'inv_inventario.cantidad', 'uni.nombre as name_unidad', 'kit.valor',
                                         'cat.nombre as name_categoria', 'inv_inventario.estado', 'kit.cantidad as kit_cantidad', 'kit.id', 'art.id as id_articulo',
                                         DB::raw('IF(art.descripcion = "", art.nombre, art.descripcion) as name_articulo'))
                                ->where('art.estado', 'A')
                                ->where('inv_inventario.id_laboratorio', $labora->id)
                                    )
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.addUnidades', compact('permiso', 'admin', 'laboratorios', 'cantKits',
                 'articulos', 'articulosList', 'laboratorio_id', 'pruebasLab'));
    }
    /* VISTA - INVENTARIO LABORATORIO - PRUEBAS */



    /* ACTUALIZA LA CANTIDAD DE KIT PARA EL REACTIVO */
    public function updateKit(Request $request)
    {

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $data = $request->validate([
            'idKit' => 'required|string',
            'kit'   => 'required|string',
        ]);

        $kits = Kit::find($request->idKit);
        $kits->cantidad    = $request->kit;
        $kits->cant_actual = $request->kit;
        $kits->consumido   = 0;

        $kits->save();

        if ($kits) {

            return response()->json(['message' => 'Cantidad guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al guardar la cantidad', 'data' => false], 500);

        }

    }
    /* ACTUALIZA LA CANTIDAD DE KIT PARA EL REACTIVO */



    /* ACTUALIZA LA CANTIDAD DE KIT PARA EL REACTIVO */
    public function updateValor(Request $request)
    {

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $data = $request->validate([
            'idKit' => 'required|string',
            'valor'   => 'required|string',
        ]);

        $kits = Kit::find($request->idKit);
        $kits->valor    = $request->valor;

        $kits->save();

        if ($kits) {

            return response()->json(['message' => 'Valor guardado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al guardar el valor', 'data' => false], 500);

        }

    }
    /* ACTUALIZA LA CANTIDAD DE KIT PARA EL REACTIVO */



    /* ACTUALIZA LA SUBCATEGORIA */
    public function updateSubcategoria(Request $request)
    {

        $data = $request->validate([
            'id_articulo'     => 'required|string',
            'id_subcategoria' => 'required|string',
        ]);

        $id_articulo = $request->id_articulo;
        $id_prueba   = $request->id_subcategoria;

        $pruebaArticulo = PruebaArticulo::updateOrCreate(
            [
                'id_prueba' => $id_prueba,
                'id_articulo' => $id_articulo
            ],
            [
                'estado' => 'A'
            ]
        );

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        //traer articulos
        $articulosList = Articulo::select('inv_articulo.id', 'inv_articulo.nombre',
            DB::raw('IF(inv_articulo.descripcion = "", inv_articulo.nombre, inv_articulo.descripcion) as nombre'))
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_prueba_articulo', 'inv_prueba_articulo.id_articulo', '=', 'inv_articulo.id')
            ->join('db_inspi_inventario.inv_prueba', 'inv_prueba.id', '=', 'inv_prueba_articulo.id_prueba')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            ->where('db_inspi_inventario.inv_prueba_articulo.id_prueba', '=', $request->id_subcategoria)
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_prueba_articulo.estado', '=', 'A')
            ->get();

        if ($pruebaArticulo) {

            return response()->json(['message' => 'Subcategoría guardado exitosamente', 'data' => true, 'articulosList' => $articulosList], 200);

        } else {

            return response()->json(['message' => 'Error al guardar el subcategoría', 'data' => false], 500);

        }

    }
    /* ACTUALIZA LA SUBCATEGORIA */



    /* QUITA LA SUBCATEGORIA */
    public function deleteSubcategoria(Request $request)
    {

        $data = $request->validate([
            'id_articulo'     => 'required|string',
            'id_subcategoria' => 'required|string',
        ]);

        $id_articulo = $request->id_articulo;
        $id_prueba   = $request->id_subcategoria;

        $pruebaArticulo = PruebaArticulo::where('id_prueba', $id_prueba)
            ->where('id_articulo', $id_articulo)
            ->firstOrFail();

        // Si se encuentra, actualizar el estado
        $pruebaArticulo->estado = 'E';
        $pruebaArticulo->save();

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        //traer articulos
        $articulosList = Articulo::select('inv_articulo.id', 'inv_articulo.nombre',
            DB::raw('IF(inv_articulo.descripcion = "", inv_articulo.nombre, inv_articulo.descripcion) as nombre'))
            ->distinct()
            ->join('db_inspi_inventario.inv_lote', 'inv_articulo.id', '=', 'inv_lote.id_articulo')
            ->join('db_inspi_inventario.inv_categoria', 'inv_categoria.id', '=', 'inv_articulo.id_categoria')
            ->join('db_inspi_inventario.inv_inventario', 'inv_lote.id', '=', 'inv_inventario.id_lote')
            ->join('db_inspi_inventario.inv_prueba_articulo', 'inv_prueba_articulo.id_articulo', '=', 'inv_articulo.id')
            ->join('db_inspi_inventario.inv_prueba', 'inv_prueba.id', '=', 'inv_prueba_articulo.id_prueba')
            ->where('db_inspi_inventario.inv_inventario.id_laboratorio', '=', $labora->id)
            ->where('db_inspi_inventario.inv_prueba_articulo.id_prueba', '=', $request->id_subcategoria)
            ->where('db_inspi_inventario.inv_categoria.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_articulo.estado', '=', 'A')
            ->where('db_inspi_inventario.inv_prueba_articulo.estado', '=', 'A')
            ->get();

        if ($pruebaArticulo) {

            return response()->json(['message' => 'Artículo eliminado de la categoría exitosamente', 'data' => true, 'articulosList' => $articulosList], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el artículo de la categoría', 'data' => false], 500);

        }

    }
    /* QUITA LA SUBCATEGORIA */



    /* ACTUALIZA EL NOMBRE DEL REACTIVO */
    public function updateNameReactivo(Request $request)
    {

        $data = $request->validate([
            'id_articulo' => 'required|string',
            'newNombre'   => 'required|string',
        ]);

        $art = Articulo::find($request->id_articulo);
        $art->descripcion = $request->newNombre;

        $art->save();

        if ($art) {

            return response()->json(['message' => 'Nombre guardado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al guardar el nombre', 'data' => false], 500);

        }

    }
    /* ACTUALIZA EL NOMBRE DEL REACTIVO */




    /* OBTENER LOS DATOS DE LA CORRIDA - EXANTEMATICOS */
    public function saveCorrida(Request $request)
    {
        $id_usuario = Auth::user()->id;

        //datos generales
        $tecnica = $request->input('tecnica');
        $para    = $request->input('para');
        $hora    = $request->input('hora');
        $fecha   = $request->input('fecha');
        $tipo    = $request->input('tipo');
        $equipos = $request->input('equipos');

        // Acceder a los datos enviados desde el formulario
        $f_reporte = $request->input('f_reporte');
        $f_procesa = $request->input('f_procesa');
        $observacionRes = $request->input('observacion');

        //obtener laboratorio
        $labora = DB::table('users as usu')
        ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
        ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
        ->select('lab.id', 'lab.nombre')
        ->where('usu.id', '=', $id_usuario)
        ->first();

        $datosCorrida = [
            'id_analista'    => $id_usuario,
            'extraccion_equi' => 'N/A',
            'equipos'        => $equipos,
            'numero'         => 'N/A',
            'tecnica'        => $tecnica,
            'servicio'       => $tecnica.' para '. $para,
            'hora'           => $hora,
            'fecha'          => $fecha,
            'vigilacia_tipo' => 'N/A',
            'observacion'    => 'N/A',
            'id_laboratorio' =>  $labora->id,
            'estado'         => 'A',
        ];

        $corrida = Corrida::create($datosCorrida);

        if ($corrida) {

            // ===================================== Acceder a los datos de ARN
            $arn = $request->input('arn');
            foreach ($arn as $dato) {

                $kits     = $dato['kits'];
                $muestras = $dato['muestras'];

                foreach ($kits as $kit) {

                    $nombreKit = $kit['nombreKit'];
                    $lote      = $kit['lote'];
                    $inventa   = $kit['inventa'];
                    $cant      = $kit['cant'];

                    $observa   = $kit['observa'];

                    $extracion = Extraccion::create([
                        'id_lote'     => $lote,
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => $observa,
                    ]);



                    //se hace el egreso en el inventario
                    $id_inventario = $inventa;
                    $rt = $cant;
                    //$rt = is_numeric($rt) ? (int)$rt : 0;
                    $rt = is_numeric($rt) ? $rt : 0;

                    $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                        'inv_kit.cant_actual as cant_actual')
                        ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
                        ->where('inv_inventario.id', '=', $id_inventario)
                        ->first();

                    $id_inv      = $movimientos->id;
                    $unidades    = $movimientos->unidades;
                    $unidades = is_numeric($unidades) ? $unidades : 0;

                    $cantidad    = $movimientos->cantidad;
                    $cantidad = is_numeric($cantidad) ? $cantidad : 0;

                    $id_kit      = $movimientos->id_kit;
                    $cant_actual = $movimientos->cant_actual;
                    $cant_actual = is_numeric($cant_actual) ? $cant_actual : 0;

                    $resultadoCal = $cant_actual - $rt;

                    $aux = 0;

                    $inventa = Inventario::find($id_inventario);
                    $ini_saldo = $inventa->cantidad;
                    $fin_saldo = $inventa->cantidad;

                    if ($resultadoCal <= 0) {

                        $cantidad_total_unidades = $rt; // La cantidad total de unidades consumidas
                        $unidades_por_reactivo   = $cantidad; // La cantidad de unidades por reactivo

                        // Calcula cuántos reactivos completos has consumido
                        $cantidad_reactivos_consumidos = floor($cantidad_total_unidades / $unidades_por_reactivo);
                        $kits = Kit::find($id_kit);

                        if($unidades_por_reactivo != 1){ //si lo reactivos son de 1 a 1, se salta este proceso



                            // Calcula cuántas unidades de un reactivo tienes aún
                            //$unidades_restantes = $resultadoCal;

                            //actualiza inventario
                            $aux = $resultadoCal;

                            if($aux < 0){

                                do {
                                    $aux = $kits->cantidad + $aux;
                                } while ($aux < 0);

                                if($aux == 0){
                                    $aux = $kits->cantidad;
                                    $cantidad_reactivos_consumidos += 1;
                                }

                            }else if($aux == 0){
                                $aux = $kits->cantidad;
                                //$cantidad_reactivos_consumidos += 1;
                            }else{
                                $cantidad_reactivos_consumidos += 1;
                            }

                            //$kits->cant_actual = $kits->cant_actual - $unidades_restantes;
                            $kits->cant_actual = $aux;

                        }

                        $kits->consumido   = $rt + $kits->consumido;
                        $kits->save();

                        //actualiza inventario
                        //$inventa = Inventario::find($id_inventario);
                        $inventa->cantidad = $inventa->cantidad  - $cantidad_reactivos_consumidos;
                        $inventa->save();

                        $fin_saldo = $fin_saldo - $cantidad_reactivos_consumidos;

                    }else{

                        $kits = Kit::find($id_kit);
                        $kits->cant_actual = $resultadoCal;
                        $kits->consumido   = $rt + $kits->consumido;

                        $kits->save();

                    }

                    $movimiento = MovimientoCor::create([

                        'id_usuario'   => $id_usuario,
                        'id_lote'      => $lote,
                        'cantidad'     => $cantidad,
                        'valor'        => $cant,
                        'total'        => $cant,

                        'prueba'       => 'Extracción de ARN',
                        'fecha'        => $fecha,
                        'ini_saldo'    => $ini_saldo,
                        'fin_saldo'    => $fin_saldo,
                        'id_movimiento_inv' => $id_inventario,
                        'id_corrida'   => $corrida->id

                    ]);



                }

                foreach ($muestras as $muestra) {

                    $codMuestra  = $muestra['codMuestra'];
                    $tipoMuestra = $muestra['tipoMuestra'];

                    $extracionDet = ExtraccionDet::create([
                        'id_muestra'    => $tipoMuestra,
                        'cod_muestra'   => $codMuestra,
                        'id_extraccion' => $extracion->id,
                    ]);

                }

            }

            // ===================================== Acceder a los datos de reacción
            $reaccion = $request->input('reaccion');
            foreach ($reaccion as $dato) {

                $tablaMovimiento = $dato['tablaMovimiento'];
                $tablaMezcla     = $dato['tablaMezcla'];
                $mezclaIDs       = [];

                $inventarioIDs   = [];
                $inventariolote  = [];

                foreach ($tablaMovimiento as $itemMovimiento) {

                    $mezcla = Mezcla::create([
                        'id_lote'     => $itemMovimiento['lote'],
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => 'N/A',
                    ]);

                    $mezclaIDs[] = $mezcla->id;
                    $inventarioIDs[]  = $itemMovimiento['id_inventario'];
                    $inventariolote[] = $itemMovimiento['lote'];

                }

                foreach ($tablaMezcla as $itemMezcla) {

                    $pruebas = json_decode($itemMezcla['pruebas'], true);

                    foreach ($pruebas as $prueba) {

                        $id_examen = $prueba;

                    }

                    $numElementos = count($mezclaIDs);
                    for ($i = 0; $i < $numElementos; $i++) {
                        $id_mezcla = $mezclaIDs[$i];

                        $prueba = $itemMezcla['datosPruebas'][$i];

                        $mezclaDet = MezclaDet::create([
                            'id_examen' => $id_examen,
                            'rx'        => $prueba['rx'],
                            'rt'        => $prueba['rt'],
                            'cant'      => $itemMezcla['cantidad'],
                            'id_mezcla' => $id_mezcla,
                        ]);


                        //se hace el egreso en el inventario
                        $id_inventario = $inventarioIDs[$i];
                        $rt = $prueba['rt'];
                        //$rt = is_numeric($rt) ? (int)$rt : 0;
                        $rt = is_numeric($rt) ? $rt : 0;

                        $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                            'inv_kit.cant_actual as cant_actual')
                            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
                            ->where('inv_inventario.id', '=', $id_inventario)
                            ->first();

                        $id_inv      = $movimientos->id;
                        $unidades    = $movimientos->unidades;
                        $unidades = is_numeric($unidades) ? $unidades : 0;

                        $cantidad    = $movimientos->cantidad;
                        $cantidad = is_numeric($cantidad) ? $cantidad : 0;

                        $id_kit      = $movimientos->id_kit;
                        $cant_actual = $movimientos->cant_actual;
                        $cant_actual = is_numeric($cant_actual) ? $cant_actual : 0;

                        $resultadoCal = $cant_actual - $rt;

                        $aux = 0;

                        $inventa = Inventario::find($id_inventario);
                        $ini_saldo = $inventa->cantidad;
                        $fin_saldo = $inventa->cantidad;

                        if ($resultadoCal <= 0) {

                            $cantidad_total_unidades = $rt; // La cantidad total de unidades consumidas
                            $unidades_por_reactivo   = $cantidad; // La cantidad de unidades por reactivo

                            // Calcula cuántos reactivos completos has consumido
                            $cantidad_reactivos_consumidos = floor($cantidad_total_unidades / $unidades_por_reactivo);
                            $kits = Kit::find($id_kit);

                            if($unidades_por_reactivo != 1){ //si lo reactivos son de 1 a 1, se salta este proceso



                                // Calcula cuántas unidades de un reactivo tienes aún
                                //$unidades_restantes = $resultadoCal;

                                //actualiza inventario
                                $aux = $resultadoCal;

                                if($aux < 0){

                                    do {
                                        $aux = $kits->cantidad + $aux;
                                    } while ($aux < 0);

                                    if($aux == 0){
                                        $aux = $kits->cantidad;
                                        $cantidad_reactivos_consumidos += 1;
                                    }

                                }else if($aux == 0){
                                    $aux = $kits->cantidad;
                                    //$cantidad_reactivos_consumidos += 1;
                                }else{
                                    $cantidad_reactivos_consumidos += 1;
                                }

                                //$kits->cant_actual = $kits->cant_actual - $unidades_restantes;
                                $kits->cant_actual = $aux;

                            }

                            $kits->consumido   = $rt + $kits->consumido;
                            $kits->save();

                            //actualiza inventario
                            //$inventa = Inventario::find($id_inventario);
                            $inventa->cantidad = $inventa->cantidad  - $cantidad_reactivos_consumidos;
                            $inventa->save();

                            $fin_saldo = $fin_saldo - $cantidad_reactivos_consumidos;

                        }else{

                            $kits = Kit::find($id_kit);
                            $kits->cant_actual = $resultadoCal;
                            $kits->consumido   = $rt + $kits->consumido;

                            $kits->save();

                        }

                        $movimiento = MovimientoCor::create([

                            'id_usuario'   => $id_usuario,
                            'id_lote'      => $inventariolote[$i],
                            'cantidad'     => $prueba['rx'],
                            'valor'        => $prueba['rt'],
                            'total'        => $prueba['rt'],

                            'prueba'       => 'RT-PCR',
                            'fecha'        => $fecha,
                            'ini_saldo'    => $ini_saldo,
                            'fin_saldo'    => $fin_saldo,
                            'id_movimiento_inv' => $id_inventario,
                            'id_corrida'   => $corrida->id

                        ]);






                    }

                    //foreach ($itemMezcla['datosPruebas'] as $prueba) {

                    //}

                }

            }

            // ===================================== Acceder a los datos de perfil
            $perfil = $request->input('perfil');
            foreach ($perfil as $dato) {
                // Acceder a los datos de cada elemento de perfil
                $datosTermico = $dato['datosTermico'];
                $canales = $dato['canales'];

                $perfil = Perfil::create([
                    'id_corrida' => $corrida->id,
                    'canales'    => $canales,
                ]);

                foreach ($datosTermico as $termico) {

                    PerfilDet::create([
                        'temperatura' => $termico['temperatura'],
                        'tiempo'      => $termico['tiempo'],
                        'ciclos'      => $termico['ciclos'],
                        'id_perfil'   => $perfil->id,
                    ]);

                }

            }

            // ===================================== Acceder a los datos de controles
            $controles = $request->input('controles');

            $control = Control::create([
                'id_corrida' => $corrida->id,
                'total'      => '0',
                'umbral'     => '0',
            ]);

            foreach ($controles as $dato) {

                $controlCon   = $dato['controlCon'];
                $ctControl    = $dato['ctControl'];
                $resultadoCon = $dato['resultadoCon'];


                ControlDet::create([

                    'control_id' => $controlCon,
                    'ct'         => $ctControl,
                    'resultado'  => $resultadoCon,
                    'criterios'  => 'N/A',
                    'id_control' => $control->id,

                ]);

            }



            // ===================================== CREAMOS LA CABEZERA DE RESULTADOS
            if($observacionRes == ''){
                $observacionRes = 'N/A';
            }
            $resultado = Resultado::create([

                'id_corrida'  => $corrida->id,
                'f_procesa'   => $f_procesa,
                'f_reporte'   => $f_reporte,
                'observacion' => $observacionRes,
                'estado'      => 'A',

            ]);


            $file = $request->file('file');
            // Generar un nombre único para el archivo
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Mover el archivo a una ubicación específica
            $file->move(public_path('uploads'), $fileName);

            // Importar el archivo usando el nombre único y los datos adicionales
            Excel::import(new ResultadosImport($resultado->id), public_path('uploads') . '/' . $fileName);

            return response()->json(['message' => 'Corrida guardada exitosamente', 'data' => true], 200);


        } else {

            return response()->json(['message' => 'Error al guardar la corrida', 'data' => false], 500);


        }


    }
    /* OBTENER LOS DATOS DE LA CORRIDA - EXANTEMATICOS */




    /* OBTENER LOS DATOS DE LA CORRIDA MANUAL - EXANTEMATICOS */
    public function saveCorridaMan(Request $request)
    {

        $data = $request->validate([

            'tecnica' => 'required|string',
            'para'    => 'required|string',
            'hora'    => 'required|string',
            'fecha'   => 'required|string',
            'tipo'    => 'required|string',
            'equipos' => 'required|string',

            'arn'        => 'required|array',
            'reaccion'   => 'required|array',
            'perfil'     => 'required|array',
            'resultados' => 'required|array',
            'controles'  => 'required|array',

        ]);

        $tecnica = $request->input('tecnica');
        $para = $request->input('para');
        $hora = $request->input('hora');
        $fecha = $request->input('fecha');
        $tipo = $request->input('tipo');
        $equipos = $request->input('equipos');

        $id_usuario = Auth::user()->id;

        //obtener laboratorio
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        $datosCorrida = [
            'id_analista'    => $id_usuario,
            'extraccion_equi' => 'N/A',
            'equipos'        => $equipos,
            'numero'         => 'N/A',
            'tecnica'        => $tecnica,
            'servicio'       => $tecnica.' para '. $para,
            'hora'           => $hora,
            'fecha'          => $fecha,
            'vigilacia_tipo' => 'N/A',
            'observacion'    => 'N/A',
            'id_laboratorio' => $labora->id,
            'estado'         => 'A',
        ];

        $corrida = Corrida::create($datosCorrida);

        if ($corrida) {

            // ===================================== Acceder a los datos de ARN
            $arn = $request->input('arn');

            foreach ($arn as $dato) {

                $kits     = $dato['kits'];
                $muestras = $dato['muestras'];

                foreach ($kits as $kit) {

                    $nombreKit = $kit['nombreKit'];
                    $lote      = $kit['lote'];
                    $inventa   = $kit['inventa'];
                    $cant      = $kit['cant'];

                    $observa   = $kit['observa'];

                    $extracion = Extraccion::create([
                        'id_lote'     => $lote,
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => $observa,
                    ]);


                    //se hace el egreso en el inventario
                    $id_inventario = $inventa;
                    $rt = $cant;
                    //$rt = is_numeric($rt) ? (int)$rt : 0;
                    $rt = is_numeric($rt) ? $rt : 0;

                    $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                        'inv_kit.cant_actual as cant_actual')
                        ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
                        ->where('inv_inventario.id', '=', $id_inventario)
                        ->first();

                    $id_inv      = $movimientos->id;
                    $unidades    = $movimientos->unidades;
                    $unidades = is_numeric($unidades) ? $unidades : 0;

                    $cantidad    = $movimientos->cantidad;
                    $cantidad = is_numeric($cantidad) ? $cantidad : 0;

                    $id_kit      = $movimientos->id_kit;
                    $cant_actual = $movimientos->cant_actual;
                    $cant_actual = is_numeric($cant_actual) ? $cant_actual : 0;

                    $resultadoCal = $cant_actual - $rt;

                    $aux = 0;

                    $inventa = Inventario::find($id_inventario);
                    $ini_saldo = $inventa->cantidad;
                    $fin_saldo = $inventa->cantidad;

                    if ($resultadoCal <= 0) {

                        $cantidad_total_unidades = $rt; // La cantidad total de unidades consumidas
                        $unidades_por_reactivo   = $cantidad; // La cantidad de unidades por reactivo

                        // Calcula cuántos reactivos completos has consumido
                        $cantidad_reactivos_consumidos = floor($cantidad_total_unidades / $unidades_por_reactivo);
                        $kits = Kit::find($id_kit);

                        if($unidades_por_reactivo != 1){ //si lo reactivos son de 1 a 1, se salta este proceso



                            // Calcula cuántas unidades de un reactivo tienes aún
                            //$unidades_restantes = $resultadoCal;

                            //actualiza inventario
                            $aux = $resultadoCal;

                            if($aux < 0){

                                do {
                                    $aux = $kits->cantidad + $aux;
                                } while ($aux < 0);

                                if($aux == 0){
                                    $aux = $kits->cantidad;
                                    $cantidad_reactivos_consumidos += 1;
                                }

                            }else if($aux == 0){
                                $aux = $kits->cantidad;
                                //$cantidad_reactivos_consumidos += 1;
                            }else{
                                $cantidad_reactivos_consumidos += 1;
                            }

                            //$kits->cant_actual = $kits->cant_actual - $unidades_restantes;
                            $kits->cant_actual = $aux;

                        }

                        $kits->consumido   = $rt + $kits->consumido;
                        $kits->save();

                        //actualiza inventario
                        //$inventa = Inventario::find($id_inventario);
                        $inventa->cantidad = $inventa->cantidad  - $cantidad_reactivos_consumidos;
                        $inventa->save();

                        $fin_saldo = $fin_saldo - $cantidad_reactivos_consumidos;

                    }else{

                        $kits = Kit::find($id_kit);
                        $kits->cant_actual = $resultadoCal;
                        $kits->consumido   = $rt + $kits->consumido;

                        $kits->save();

                    }

                    $movimiento = MovimientoCor::create([

                        'id_usuario'   => $id_usuario,
                        'id_lote'      => $lote,
                        'cantidad'     => $cantidad,
                        'valor'        => $cant,
                        'total'        => $cant,

                        'prueba'       => 'Extracción de ARN',
                        'fecha'        => $fecha,
                        'ini_saldo'    => $ini_saldo,
                        'fin_saldo'    => $fin_saldo,
                        'id_movimiento_inv' => $id_inventario,
                        'id_corrida'   => $corrida->id

                    ]);


                }

                foreach ($muestras as $muestra) {

                    $codMuestra  = $muestra['codMuestra'];
                    $tipoMuestra = $muestra['tipoMuestra'];

                    $extracionDet = ExtraccionDet::create([
                        'id_muestra'    => $tipoMuestra,
                        'cod_muestra'   => $codMuestra,
                        'id_extraccion' => $extracion->id,
                    ]);

                }

            }

            // ===================================== Acceder a los datos de reacción
            $reaccion = $request->input('reaccion');
            foreach ($reaccion as $dato) {

                $tablaMovimiento = $dato['tablaMovimiento'];
                $tablaMezcla     = $dato['tablaMezcla'];
                $mezclaIDs       = [];
                $inventarioIDs   = [];
                $inventariolote  = [];

                foreach ($tablaMovimiento as $itemMovimiento) {

                    $mezcla = Mezcla::create([
                        'id_lote'     => $itemMovimiento['lote'],
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => 'N/A',
                    ]);

                    $mezclaIDs[] = $mezcla->id;
                    $inventarioIDs[]  = $itemMovimiento['id_inventario'];
                    $inventariolote[] = $itemMovimiento['lote'];

                }

                foreach ($tablaMezcla as $itemMezcla) {

                    $pruebas = $itemMezcla['pruebas'];

                    foreach ($pruebas as $prueba) {

                        $id_examen = $prueba;

                    }


                    $numElementos = count($mezclaIDs);
                    for ($i = 0; $i < $numElementos; $i++) {
                        $id_mezcla = $mezclaIDs[$i];

                        $prueba = $itemMezcla['datosPruebas'][$i];

                        $mezclaDet = MezclaDet::create([
                            'id_examen' => $id_examen,
                            'rx'        => $prueba['rx'],
                            'rt'        => $prueba['rt'],
                            'cant'      => $itemMezcla['cantidad'],
                            'id_mezcla' => $id_mezcla,
                        ]);



                        //se hace el egreso en el inventario
                        $id_inventario = $inventarioIDs[$i];
                        $rt = $prueba['rt'];;
                        //$rt = is_numeric($rt) ? (int)$rt : 0;
                        $rt = is_numeric($rt) ? $rt : 0;

                        $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                            'inv_kit.cant_actual as cant_actual')
                            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
                            ->where('inv_inventario.id', '=', $id_inventario)
                            ->first();

                        $id_inv      = $movimientos->id;
                        $unidades    = $movimientos->unidades;
                        $unidades = is_numeric($unidades) ? $unidades : 0;

                        $cantidad    = $movimientos->cantidad;
                        $cantidad = is_numeric($cantidad) ? $cantidad : 0;

                        $id_kit      = $movimientos->id_kit;
                        $cant_actual = $movimientos->cant_actual;
                        $cant_actual = is_numeric($cant_actual) ? $cant_actual : 0;

                        $resultadoCal = $cant_actual - $rt;

                        $aux = 0;

                        $inventa = Inventario::find($id_inventario);
                        $ini_saldo = $inventa->cantidad;
                        $fin_saldo = $inventa->cantidad;

                        if ($resultadoCal <= 0) {

                            $cantidad_total_unidades = $rt; // La cantidad total de unidades consumidas
                            $unidades_por_reactivo   = $cantidad; // La cantidad de unidades por reactivo

                            // Calcula cuántos reactivos completos has consumido
                            $cantidad_reactivos_consumidos = floor($cantidad_total_unidades / $unidades_por_reactivo);
                            $kits = Kit::find($id_kit);

                            if($unidades_por_reactivo != 1){ //si lo reactivos son de 1 a 1, se salta este proceso



                                // Calcula cuántas unidades de un reactivo tienes aún
                                //$unidades_restantes = $resultadoCal;

                                //actualiza inventario
                                $aux = $resultadoCal;

                                if($aux < 0){

                                    do {
                                        $aux = $kits->cantidad + $aux;
                                    } while ($aux < 0);

                                    if($aux == 0){
                                        $aux = $kits->cantidad;
                                        $cantidad_reactivos_consumidos += 1;
                                    }

                                }else if($aux == 0){
                                    $aux = $kits->cantidad;
                                    //$cantidad_reactivos_consumidos += 1;
                                }else{
                                    $cantidad_reactivos_consumidos += 1;
                                }

                                //$kits->cant_actual = $kits->cant_actual - $unidades_restantes;
                                $kits->cant_actual = $aux;

                            }

                            $kits->consumido   = $rt + $kits->consumido;
                            $kits->save();

                            //actualiza inventario
                            //$inventa = Inventario::find($id_inventario);
                            $inventa->cantidad = $inventa->cantidad  - $cantidad_reactivos_consumidos;
                            $inventa->save();

                            $fin_saldo = $fin_saldo - $cantidad_reactivos_consumidos;

                        }else{

                            $kits = Kit::find($id_kit);
                            $kits->cant_actual = $resultadoCal;
                            $kits->consumido   = $rt + $kits->consumido;

                            $kits->save();

                        }

                        $movimiento = MovimientoCor::create([

                            'id_usuario'   => $id_usuario,
                            'id_lote'      => $inventariolote[$i],
                            'cantidad'     => $prueba['rx'],
                            'valor'        => $prueba['rt'],
                            'total'        => $prueba['rt'],

                            'prueba'       => 'RT-PCR',
                            'fecha'        => $fecha,
                            'ini_saldo'    => $ini_saldo,
                            'fin_saldo'    => $fin_saldo,
                            'id_movimiento_inv' => $id_inventario,
                            'id_corrida'   => $corrida->id

                        ]);



                    }

                }

            }

            // ===================================== Acceder a los datos de perfil
            $perfil = $request->input('perfil');
            foreach ($perfil as $dato) {
                // Acceder a los datos de cada elemento de perfil
                $datosTermico = $dato['datosTermico'];
                $canales = $dato['canales'];

                $perfil = Perfil::create([
                    'id_corrida' => $corrida->id,
                    'canales'    => $canales,
                ]);

                foreach ($datosTermico as $termico) {

                    PerfilDet::create([
                        'temperatura' => $termico['temperatura'],
                        'tiempo'      => $termico['tiempo'],
                        'ciclos'      => $termico['ciclos'],
                        'id_perfil'   => $perfil->id,
                    ]);

                }

            }

            // ===================================== Acceder a los datos de controles
            $controles = $request->input('controles');

            $control = Control::create([
                'id_corrida' => $corrida->id,
                'total'      => '0',
                'umbral'     => '0',
            ]);

            foreach ($controles as $dato) {

                $controlCon   = $dato['controlCon'];
                $ctControl    = $dato['ctControl'];
                $resultadoCon = $dato['resultadoCon'];


                ControlDet::create([

                    'control_id' => $controlCon,
                    'ct'         => $ctControl,
                    'resultado'  => $resultadoCon,
                    'criterios'  => 'N/A',
                    'id_control' => $control->id,

                ]);

            }



            // ===================================== Acceder a los datos de resultados

            $resultados = $request->input('resultados');
            foreach ($resultados as $result) {
                $f_procesa = $result['f_procesa'];
                $f_reporte = $result['f_reporte'];
                $observaci = $result['observaci'];

                $datosResult = $result['datosResult'];//arreglo

                if($observaci == ''){
                    $observaci = 'N/A';
                }

                $resultado = Resultado::create([

                    'id_corrida'  => $corrida->id,
                    'f_procesa'   => $f_procesa,
                    'f_reporte'   => $f_reporte,
                    'observacion' => $observaci,
                    'estado'      => 'A',

                ]);

                foreach ($datosResult as $dato) {

                    $id_muestra   = $dato['id_muestraRes'];
                    $codigo       = $dato['codigoRes'];
                    $ct           = $dato['ctRes'];
                    $ensayo       = $dato['enzayoRes'];
                    $fecha        = $dato['fingresonRes'];
                    $paciente     = $dato['pacienteRes'];
                    $procedencia  = $dato['procedenciaRes'];
                    $resultadoPru = $dato['resultadoRes'];
                    $ubicacion    = $dato['ubicacionRes'];

                    if($ct == ''){
                        $ct = 'N/A';
                    }

                    $resultadoDet = ResultadoDet::create([

                        'ubicacion'     => $ubicacion,
                        'f_ingreso'     => $fecha,
                        'codigo'        => $codigo,
                        'paciente'      => $paciente,
                        'procedencia'   => $procedencia,
                        'id_muestra'    => $id_muestra,
                        'ensayo'        => $ensayo,
                        'ct'            => $ct,
                        'resultado'     => $resultadoPru,
                        'concentracion' => 'N/A',
                        'id_resultado'  => $resultado->id,
                        'estado'        => 'A',

                    ]);

                }

            }

            return response()->json(['message' => 'Corrida guardada exitosamente', 'data' => true, 'extra' => $aux, 'resultadoCal' => $resultadoCal], 200);


        } else {

            return response()->json(['message' => 'Error al guardar la corrida', 'data' => false], 500);


        }


    }
    /* OBTENER LOS DATOS DE LA CORRIDA MANUAL - EXANTEMATICOS */


    /* TRAE LAS CORRIDAS HECHAS */
    public function listCorrida(){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $usuarios = User::select('users.id', 'users.name')
        ->join('inspi_crns.responsables', 'responsables.usuario_id', '=', 'users.id')
        ->where('inspi_crns.responsables.crns_id', function($query) use ($id_usuario) {
            $query->select('lab.crns_id')
                  ->from('inspi_crns.responsables as lab')
                  ->join('users as usu', 'usu.id', '=', 'lab.usuario_id')
                  ->where('usu.id', $id_usuario);
        })
        ->get();

        //obtener laboratorio
        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();
        
        /*
        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();
        */

        $cantKits = Kit::where('cantidad', '')->count();


        if(request()->ajax()) {

            return datatables()->of(
                            $consulta = Corrida::select('tecnica', 'equipos', 'servicio', 'fecha', 'estado', 'id')
                                ->where('estado', 'A')->where('id_laboratorio', $labora->id)
                            )
                ->addIndexColumn()
                ->make(true);

        }


        //respuesta para la vista
        return view('inventarios.list_corrida', compact('usuarios', 'cantKits', 'labora'));

    }
    /* TRAE LAS CORRIDAS HECHAS */



    /* OBTENER USUARIOS POR LABORATORIO */
    function obtenerUsuariosLab($id_usuario){

        /*
        $usuarios = User::select('users.id', 'users.name')
        ->join('inspi_area', 'users.id_area', '=', 'inspi_area.id')
        ->join('inspi_laboratorio', 'inspi_area.id', '=', 'inspi_laboratorio.area_id')
        ->where('inspi_laboratorio.id', function($query) use ($id_usuario) {
            $query->select('lab.id')
                  ->from('inspi_laboratorio as lab')
                  ->join('inspi_area as are', 'lab.area_id', '=', 'are.id')
                  ->join('users as usu', 'usu.id_area', '=', 'are.id')
                  ->where('usu.id', $id_usuario);
        })
        ->get();
        */

        $usuarios = User::select('users.id', 'users.name')
        ->join('inspi_crns.responsables', 'responsables.usuario_id', '=', 'users.id')
        ->where('inspi_crns.responsables.crns_id', function($query) use ($id_usuario) {
            $query->select('lab.crns_id')
                  ->from('inspi_crns.responsables as lab')
                  ->join('users as usu', 'usu.id', '=', 'lab.usuario_id')
                  ->where('usu.id', $id_usuario);
        })
        ->get();

        return response()->json($usuarios);

    }
    /* OBTENER USUARIOS POR LABORATORIO */




    /* GENERAR PDF  */
    public function reportHexa(Request $request)
    {
        $id_corrida  = $request->query('id_corrida');
        $id_revisado = $request->query('id_revisado');
        $id_autoriza = $request->query('id_autoriza');
        $id_reporta  = $request->query('id_reporta');
        $id_laboratorio = $request->query('id_laboratorio');

        $usuarios = [
            'revisado' => User::select('name')->where('id', $id_revisado)->first(),
            'autoriza' => User::select('name')->where('id', $id_autoriza)->first(),
            'reporta' => User::select('name')->where('id', $id_reporta)->first(),
        ];

        if($id_laboratorio == 6){

        //============== hexantematico
            //corrida
            $corrida = Corrida::select('cor_corrida.id', 'cor_corrida.extraccion_equi', 'cor_corrida.equipos', 'cor_corrida.numero'
                , 'cor_corrida.tecnica', 'cor_corrida.servicio', 'cor_corrida.hora', 'cor_corrida.fecha', 'cor_corrida.vigilacia_tipo'
                , 'cor_corrida.observacion', 'use.name')
                ->join('bdcoreinspi.users as use', 'use.id', '=', 'cor_corrida.id_analista')
                ->where('cor_corrida.estado', 'A')->where('cor_corrida.id', $id_corrida)->first();

            //extración
            $extraccion = Extraccion::select('cor_extraccion.id', 'cor_extraccion.numero', 'cor_extraccion.observacion', 'lot.f_elabora'
                , 'lot.f_caduca', 'lot.nombre as lote', 'art.nombre as nombre')
                ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_extraccion.id_lote')
                ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
                ->where('cor_extraccion.estado', 'A')->where('cor_extraccion.id_corrida', $id_corrida)->first();

            $extraccionDet = ExtraccionDet::select('cor_extraccion_det.cod_muestra', 'mue.nombre')
                ->join('db_inspi.inspi_muestra as mue', 'mue.id', '=', 'cor_extraccion_det.id_muestra')
                ->where('cor_extraccion_det.id_extraccion', $extraccion->id)->get();


            //mezcla
            $mezcla = Mezcla::select('cor_mezcla.id', 'cor_mezcla.numero', 'art.nombre as reactivo', 'lot.nombre as lote')
                ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_mezcla.id_lote')
                ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
                ->where('cor_mezcla.estado', 'A')->where('cor_mezcla.id_corrida', $id_corrida)->get();


            //mezclas
            $examenes = MezclaDet::select('db_inspi_labcorrida.cor_mezcla_det.id_examen', 'db_inspi_labcorrida.cor_mezcla_det.cant', 'inspi_examen.nombre')
                ->join('db_inspi_labcorrida.cor_mezcla', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla', '=', 'db_inspi_labcorrida.cor_mezcla.id')
                ->join('db_inspi.inspi_examen', 'db_inspi_labcorrida.cor_mezcla_det.id_examen', '=', 'inspi_examen.id')
                ->where('db_inspi_labcorrida.cor_mezcla.id_corrida', $id_corrida)
                ->distinct()
                ->get(); // Cambio pluck() por get() para obtener todos los resultados

            $arrayMezclas = [];

            foreach ($examenes as $examen) {
                $mezclaDet = MezclaDet::select('db_inspi_labcorrida.cor_mezcla_det.rx', 'db_inspi_labcorrida.cor_mezcla_det.rt')
                    ->join('db_inspi_labcorrida.cor_mezcla as mez', 'mez.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla')
                    ->join('db_inspi.inspi_examen as exa', 'exa.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_examen')
                    ->join('db_inspi_labcorrida.cor_mezcla', 'cor_mezcla.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla')
                    ->where('db_inspi_labcorrida.cor_mezcla_det.id_examen', $examen->id_examen)
                    ->where('db_inspi_labcorrida.cor_mezcla.id_corrida', $id_corrida)
                    ->get();

                $arrayMezclas[] = [
                    'id_examen' => $examen->id_examen,
                    'cant' => $examen->cant,
                    'nombre' => $examen->nombre, // Agregar el nombre del examen
                    'mezclaDet' => $mezclaDet,
                ];
            }

            $resultadosMez = DB::table('db_inspi_labcorrida.cor_mezcla_det as det')
                ->join('db_inspi_labcorrida.cor_mezcla as mez', 'det.id_mezcla', '=', 'mez.id')
                ->select(DB::raw('SUM(det.rx) AS total_rx'), DB::raw('SUM(det.rt) AS total_rt'))
                ->where('mez.id_corrida', $id_corrida)
                ->groupBy('det.id_mezcla')
                ->get();

            //resultados
            $resultado = Resultado::select('id', 'f_procesa', 'f_reporte', 'observacion')
                ->where('estado', 'A')->where('id_corrida', $id_corrida)->first();

            $resultadoDet = ResultadoDet::select('cor_resultado_det.ubicacion', 'cor_resultado_det.f_ingreso', 'cor_resultado_det.codigo',
                'cor_resultado_det.paciente', 'cor_resultado_det.procedencia', 'mue.nombre', 'cor_resultado_det.ensayo', 'cor_resultado_det.resultado', 'cor_resultado_det.ct')
                ->join('db_inspi.inspi_muestra as mue', 'mue.id', '=', 'cor_resultado_det.id_muestra')
                ->where('cor_resultado_det.id_resultado', $resultado->id)->get();

            //perfil
            $perfil = Perfil::select('id', 'canales')
            ->where('estado', 'A')->where('id_corrida', $id_corrida)->first();

            $perfilDet = PerfilDet::select('id', 'temperatura', 'tiempo', 'ciclos')
            ->where('estado', 'A')->where('id_perfil', $perfil->id)->get();

            $control = Control::select('total', 'umbral', 'id')
                ->where('estado', 'A')->where('id_corrida', $id_corrida)->first();

            $controlDet = ControlDet::select('cor_control_det.ct', 'cor_control_det.resultado', 'con.nombre', 'cor_control_det.criterios')
                ->join('db_inspi.inspi_control as con', 'con.id', '=', 'cor_control_det.control_id')
                ->where('cor_control_det.estado', 'A')->where('cor_control_det.id_control', $control->id)->get();

            $pdf = \PDF::loadView('pdf.pdfexantematico', ['usuarios' => $usuarios, 'examenes' => $examenes,
                        'arrayMezclas' => $arrayMezclas, 'resultadosMez' => $resultadosMez, 'resultado' => $resultado,
                        'resultadoDet' => $resultadoDet, 'perfil' => $perfil, 'perfilDet' => $perfilDet, 'mezcla' => $mezcla,
                        'corrida' => $corrida, 'extraccion' => $extraccion, 'extraccionDet' => $extraccionDet,
                        'control' => $control, 'controlDet' => $controlDet]);

        //============== hexantematico

        }else if($id_laboratorio == 3){

        //============== inmunohematología
            //corrida
            $corrida = Corrida::select('cor_corrida.id', 'cor_corrida.extraccion_equi', 'cor_corrida.equipos', 'cor_corrida.numero'
                , 'cor_corrida.tecnica', 'cor_corrida.servicio', 'cor_corrida.hora', 'cor_corrida.fecha', 'cor_corrida.vigilacia_tipo'
                , 'cor_corrida.observacion', 'use.name')
                ->join('bdcoreinspi.users as use', 'use.id', '=', 'cor_corrida.id_analista')
                ->where('cor_corrida.estado', 'A')->where('cor_corrida.id', $id_corrida)->first();

            //extración
            $extraccion = Extraccion::select('cor_extraccion.id', 'cor_extraccion.numero', 'cor_extraccion.observacion', 'lot.f_elabora'
                , 'lot.f_caduca', 'lot.nombre as lote', 'art.nombre as nombre')
                ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_extraccion.id_lote')
                ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
                ->where('cor_extraccion.estado', 'A')->where('cor_extraccion.id_corrida', $id_corrida)->first();

            $extraccionDet = ExtraccionDet::select('cor_extraccion_det.cod_muestra', 'mue.nombre')
                ->join('db_inspi.inspi_muestra as mue', 'mue.id', '=', 'cor_extraccion_det.id_muestra')
                ->where('cor_extraccion_det.id_extraccion', $extraccion->id)->get();


            //mezcla
            $mezcla = Mezcla::select('cor_mezcla.id', 'cor_mezcla.numero', 'art.nombre as reactivo', 'lot.nombre as lote', 'lot.f_caduca as f_caduca')
                ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_mezcla.id_lote')
                ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
                ->where('cor_mezcla.estado', 'A')->where('cor_mezcla.id_corrida', $id_corrida)->get();


            //mezclas
            $examenes = MezclaDet::select('db_inspi_labcorrida.cor_mezcla_det.id_examen', 'db_inspi_labcorrida.cor_mezcla_det.cant', 'inspi_examen.nombre')
                ->join('db_inspi_labcorrida.cor_mezcla', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla', '=', 'db_inspi_labcorrida.cor_mezcla.id')
                ->join('db_inspi.inspi_examen', 'db_inspi_labcorrida.cor_mezcla_det.id_examen', '=', 'inspi_examen.id')
                ->where('db_inspi_labcorrida.cor_mezcla.id_corrida', $id_corrida)
                ->distinct()
                ->get(); // Cambio pluck() por get() para obtener todos los resultados

            $arrayMezclas = [];

            foreach ($examenes as $examen) {
                $mezclaDet = MezclaDet::select('db_inspi_labcorrida.cor_mezcla_det.rx', 'db_inspi_labcorrida.cor_mezcla_det.rt', 'db_inspi_labcorrida.cor_mezcla_det.solucion')
                    ->join('db_inspi_labcorrida.cor_mezcla as mez', 'mez.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla')
                    ->join('db_inspi.inspi_examen as exa', 'exa.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_examen')
                    ->join('db_inspi_labcorrida.cor_mezcla', 'cor_mezcla.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla')
                    ->where('db_inspi_labcorrida.cor_mezcla_det.id_examen', $examen->id_examen)
                    ->where('db_inspi_labcorrida.cor_mezcla.id_corrida', $id_corrida)
                    ->get();

                $arrayMezclas[] = [
                    'id_examen' => $examen->id_examen,
                    'cant' => $examen->cant,
                    'nombre' => $examen->nombre, // Agregar el nombre del examen
                    'mezclaDet' => $mezclaDet,
                ];
            }

            $resultadosMez = DB::table('db_inspi_labcorrida.cor_mezcla_det as det')
                ->join('db_inspi_labcorrida.cor_mezcla as mez', 'det.id_mezcla', '=', 'mez.id')
                ->select(DB::raw('SUM(det.rx) AS total_rx'), DB::raw('SUM(det.rt) AS total_rt'))
                ->where('mez.id_corrida', $id_corrida)
                ->groupBy('det.id_mezcla')
                ->get();

            //resultados
            $resultado = Resultado::select('id', 'f_procesa', 'f_reporte', 'observacion')
                ->where('estado', 'A')->where('id_corrida', $id_corrida)->first();

            $resultadoDet = ResultadoDet::select('cor_resultado_det.ubicacion', 'cor_resultado_det.f_ingreso', 'cor_resultado_det.codigo', 'cor_resultado_det.concentracion', 'cor_resultado_det.observacion',
                'cor_resultado_det.paciente', 'cor_resultado_det.procedencia', 'mue.nombre', 'cor_resultado_det.ensayo', 'cor_resultado_det.resultado', 'cor_resultado_det.ct')
                ->join('db_inspi.inspi_muestra as mue', 'mue.id', '=', 'cor_resultado_det.id_muestra')
                ->where('cor_resultado_det.id_resultado', $resultado->id)->get();

            //perfil
            $perfil = Perfil::select('id', 'canales')
            ->where('estado', 'A')->where('id_corrida', $id_corrida)->first();

            $perfilDet = PerfilDet::select('id', 'temperatura', 'tiempo', 'ciclos')
            ->where('estado', 'A')->where('id_perfil', $perfil->id)->get();

            $control = Control::select('total', 'umbral', 'id', 'automatic')
                ->where('estado', 'A')->where('id_corrida', $id_corrida)->first();

            $controlDet = ControlDet::select('cor_control_det.ct', 'cor_control_det.resultado', 'con.nombre', 'cor_control_det.criterios')
                ->join('db_inspi.inspi_control as con', 'con.id', '=', 'cor_control_det.control_id')
                ->where('cor_control_det.estado', 'A')->where('cor_control_det.id_control', $control->id)->get();

            $estandar = Estandar::select('estandar', 'concentra', 'ct', 'interpreta')
                ->where('estado', 'A')->where('id_corrida', $id_corrida)->get();

            $pdf = \PDF::loadView('pdf.pdfinmunohematologia', ['usuarios' => $usuarios, 'examenes' => $examenes,
                        'arrayMezclas' => $arrayMezclas, 'resultadosMez' => $resultadosMez, 'resultado' => $resultado,
                        'resultadoDet' => $resultadoDet, 'perfil' => $perfil, 'perfilDet' => $perfilDet, 'mezcla' => $mezcla,
                        'corrida' => $corrida, 'extraccion' => $extraccion, 'extraccionDet' => $extraccionDet,
                        'control' => $control, 'controlDet' => $controlDet, 'estandar' => $estandar, 'mezclaDet' => $mezclaDet]);

        //============== inmunohematología

        }else if($id_laboratorio == 5){

            //============== influenza
                //corrida
                $corrida = Corrida::select('cor_corrida.id', 'cor_corrida.extraccion_equi', 'cor_corrida.equipos', 'cor_corrida.numero'
                    , 'cor_corrida.tecnica', 'cor_corrida.servicio', 'cor_corrida.hora', 'cor_corrida.fecha', 'cor_corrida.vigilacia_tipo'
                    , 'cor_corrida.observacion', 'use.name', 'cor_corrida.estacional', 'cor_corrida.variante')
                    ->join('bdcoreinspi.users as use', 'use.id', '=', 'cor_corrida.id_analista')
                    ->where('cor_corrida.estado', 'A')->where('cor_corrida.id', $id_corrida)->first();

                //extración
                $extraccion = Extraccion::select('cor_extraccion.id', 'cor_extraccion.numero', 'cor_extraccion.observacion', 'lot.f_elabora'
                    , 'lot.f_caduca', 'lot.nombre as lote', 'art.nombre as nombre')
                    ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_extraccion.id_lote')
                    ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
                    ->where('cor_extraccion.estado', 'A')->where('cor_extraccion.id_corrida', $id_corrida)->first();

                $extraccionDet = ExtraccionDet::select('cor_extraccion_det.cod_muestra')
                    //->join('db_inspi.inspi_muestra as mue', 'mue.id', '=', 'cor_extraccion_det.id_muestra')
                    ->where('cor_extraccion_det.id_extraccion', $extraccion->id)->get();


                //mezcla
                $mezcla = Mezcla::select('cor_mezcla.id', 'cor_mezcla.numero', 'art.nombre as reactivo', 'lot.nombre as lote', 'lot.f_caduca as f_caduca')
                    ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_mezcla.id_lote')
                    ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
                    ->where('cor_mezcla.estado', 'A')->where('cor_mezcla.id_corrida', $id_corrida)->get();


                //mezclas
                $examenes = MezclaDet::select('db_inspi_labcorrida.cor_mezcla_det.id_examen', 'db_inspi_labcorrida.cor_mezcla_det.cant', 'inspi_examen.nombre')
                    ->join('db_inspi_labcorrida.cor_mezcla', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla', '=', 'db_inspi_labcorrida.cor_mezcla.id')
                    ->join('db_inspi.inspi_examen', 'db_inspi_labcorrida.cor_mezcla_det.id_examen', '=', 'inspi_examen.id')
                    ->where('db_inspi_labcorrida.cor_mezcla.id_corrida', $id_corrida)
                    ->distinct()
                    ->get(); // Cambio pluck() por get() para obtener todos los resultados

                $arrayMezclas = [];

                foreach ($examenes as $examen) {
                    $mezclaDet = MezclaDet::select('db_inspi_labcorrida.cor_mezcla_det.rx', 'db_inspi_labcorrida.cor_mezcla_det.rt', 'db_inspi_labcorrida.cor_mezcla_det.solucion')
                        ->join('db_inspi_labcorrida.cor_mezcla as mez', 'mez.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla')
                        ->join('db_inspi.inspi_examen as exa', 'exa.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_examen')
                        ->join('db_inspi_labcorrida.cor_mezcla', 'cor_mezcla.id', '=', 'db_inspi_labcorrida.cor_mezcla_det.id_mezcla')
                        ->where('db_inspi_labcorrida.cor_mezcla_det.id_examen', $examen->id_examen)
                        ->where('db_inspi_labcorrida.cor_mezcla.id_corrida', $id_corrida)
                        ->get();

                    $arrayMezclas[] = [
                        'id_examen' => $examen->id_examen,
                        'cant' => $examen->cant,
                        'nombre' => $examen->nombre, // Agregar el nombre del examen
                        'mezclaDet' => $mezclaDet,
                    ];
                }

                $resultadosMez = DB::table('db_inspi_labcorrida.cor_mezcla_det as det')
                    ->join('db_inspi_labcorrida.cor_mezcla as mez', 'det.id_mezcla', '=', 'mez.id')
                    ->select(DB::raw('SUM(det.rx) AS total_rx'), DB::raw('SUM(det.rt) AS total_rt'))
                    ->where('mez.id_corrida', $id_corrida)
                    ->groupBy('det.id_mezcla')
                    ->get();



                //monoclonal
                $monoclonal = Monoclonal::select('cor_monoclonal.id', 'db_inspi_labcorrida.cor_monoclonal.fecha',
                        'db_inspi_labcorrida.cor_monoclonal.muestra', 'use.name as usuario_id', 'db_inspi_labcorrida.cor_monoclonal.reactivo_id')
                ->join('bdcoreinspi.users as use', 'use.id', '=', 'cor_monoclonal.usuario_id')
                ->where('cor_monoclonal.estado', 'A')->where('cor_monoclonal.id_corrida', $id_corrida)->get();

                $arrayReactivos = [];

                foreach ($monoclonal as $mono) {

                    $monoclonalReac = ReactivoMono::select('id', 'id_reactivo')
                    ->where('estado', 'A')->where('id_monoclonal', $mono->id)->get();

                    foreach ($monoclonalReac as $reac) {
                        $arrayReactivos[] = [
                            'id' => $reac->id,
                            'id_reactivo' => $reac->id_reactivo,
                        ];
                    }

                }


                $policlonal = Policlonal::select('cor_policlonal.id', 'cor_policlonal.fecha', 'cor_policlonal.muestra', 'use.name as usuario_id', 'cor_policlonal.reactivo_id')
                ->join('bdcoreinspi.users as use', 'use.id', '=', 'cor_policlonal.usuario_id')
                ->where('cor_policlonal.estado', 'A')->where('cor_policlonal.id_corrida', $id_corrida)->get();


                $pdf = \PDF::loadView('pdf.pdfinfluenza', ['usuarios' => $usuarios, 'examenes' => $examenes,
                            'arrayMezclas' => $arrayMezclas, 'resultadosMez' => $resultadosMez, 'mezcla' => $mezcla,
                            'corrida' => $corrida, 'extraccion' => $extraccion, 'extraccionDet' => $extraccionDet,
                            'mezclaDet' => $mezclaDet, 'policlonal' => $policlonal, 'monoclonal' => $monoclonal, 'arrayReactivos' => $arrayReactivos]);

            //============== influenza

            }

        //$pdf = hexantematico($id_corrida, $usuarios);//funcion

        $pdfFileName = 'pdf_' . time() . '.pdf';

        $pdf->save(public_path("pdf/{$pdfFileName}"));

        $pdfUrl = asset("pdf/{$pdfFileName}");

        return response()->json(['pdf_url' => $pdfUrl]);
    }

    /* GENERAR PDF  */



    /* GENERAR PDF MONOCLONAL */
    public function reportMono(Request $request)
    {
        $id_corrida  = $request->query('id_corrida');
        $id_revisado = $request->query('id_revisado');
        $id_autoriza = $request->query('id_autoriza');
        $id_reporta  = $request->query('id_reporta');
        $id_laboratorio = $request->query('id_laboratorio');

        $fFinMono    = $request->query('fFinMono');
        $fInicioMono = $request->query('fInicioMono');

        $usuarios = [
            'revisado' => User::select('name')->where('id', $id_revisado)->first(),
            'autoriza' => User::select('name')->where('id', $id_autoriza)->first(),
            'reporta' => User::select('name')->where('id', $id_reporta)->first(),
        ];


        //============== influenza
            //corrida
            $corrida = Corrida::select('cor_corrida.id', 'cor_corrida.extraccion_equi', 'cor_corrida.equipos', 'cor_corrida.numero'
                , 'cor_corrida.tecnica', 'cor_corrida.servicio', 'cor_corrida.hora', 'cor_corrida.fecha', 'cor_corrida.vigilacia_tipo'
                , 'cor_corrida.observacion', 'use.name', 'cor_corrida.estacional', 'cor_corrida.variante')
                ->join('db_inspi.users as use', 'use.id', '=', 'cor_corrida.id_analista')
                ->where('cor_corrida.estado', 'A')->where('cor_corrida.id', $id_corrida)->first();


            //monoclonal
            $monoclonal = Monoclonal::select('cor_monoclonal.id', 'db_inspi_labcorrida.cor_monoclonal.fecha',
                    'db_inspi_labcorrida.cor_monoclonal.muestra', 'use.name as usuario_id', 'db_inspi_labcorrida.cor_monoclonal.reactivo_id')
            ->join('db_inspi.users as use', 'use.id', '=', 'cor_monoclonal.usuario_id')
            ->where('cor_monoclonal.estado', 'A')->where('cor_monoclonal.id_corrida', $id_corrida)->get();

            $monoclonales = Monoclonal::select(
                    'cor_monoclonal.id',
                    'db_inspi_labcorrida.cor_monoclonal.fecha',
                    'db_inspi_labcorrida.cor_monoclonal.muestra',
                    'use.name as usuario_id',
                    'db_inspi_labcorrida.cor_monoclonal.reactivo_id'
                )
                ->join('db_inspi.users as use', 'use.id', '=', 'cor_monoclonal.usuario_id')
                ->where('cor_monoclonal.estado', 'A')
                ->where('cor_monoclonal.id_corrida', $id_corrida)
                ->orderBy('db_inspi_labcorrida.cor_monoclonal.fecha')
                ->orderBy('use.name')
                ->get()
                ->chunk(2);


            // Normalizar el arreglo
            $normalizedMonoclonales = [];
            foreach ($monoclonales as $group) {
                if (is_array($group)) {
                    foreach ($group as $item) {
                        $normalizedMonoclonales[] = $item;
                    }
                }
            }


            $arrayReactivos = [];

            foreach ($monoclonal as $mono) {

                $monoclonalReac = ReactivoMono::select('cor_reactivo_mono.id', DB::raw('CASE WHEN art.descripcion != "" THEN art.descripcion ELSE art.nombre END AS id_reactivo'), 'cor_reactivo_mono.id_monoclonal')
                    ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'cor_reactivo_mono.id_reactivo')
                    ->where('cor_reactivo_mono.estado', 'A')->where('cor_reactivo_mono.id_monoclonal', $mono->id)->get();

                foreach ($monoclonalReac as $reac) {
                    $arrayReactivos[] = [
                        'id'            => $reac->id,
                        'id_reactivo'   => $reac->id_reactivo,
                        'id_monoclonal' => $reac->id_monoclonal,
                    ];
                }

            }


            $policlonal = Policlonal::select('cor_policlonal.id', 'cor_policlonal.fecha', 'cor_policlonal.muestra', 'use.name as usuario_id', 'cor_policlonal.reactivo_id')
            ->join('db_inspi.users as use', 'use.id', '=', 'cor_policlonal.usuario_id')
            ->where('cor_policlonal.estado', 'A')->where('cor_policlonal.id_corrida', $id_corrida)->get();


            $pdf = \PDF::loadView('pdf.pdfmono', ['usuarios' => $usuarios, 'corrida' => $corrida, 'monoclonales' => $monoclonales,
                                'policlonal' => $policlonal, 'monoclonal' => $monoclonal, 'arrayReactivos' => $arrayReactivos]);

        //============== influenza



        //$pdf = hexantematico($id_corrida, $usuarios);//funcion

        $pdfFileName = 'pdf_' . time() . '.pdf';

        $pdf->save(public_path("pdf/{$pdfFileName}"));

        $pdfUrl = asset("pdf/{$pdfFileName}");

        return response()->json(['pdf_url' => $pdfUrl]);
    }

    /* GENERAR PDF MONOCLONAL */




    // ============================================================ INMUNOHEMATOLOGÍA ============================================================

    /* VISTA - CREAR NUEVO EGRESO INMUNOHEMATOLOGÍA */
    public function crearEgresoInm(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $Modulos = PermisoRolOpcion::select('inspi_modulos.id as id',
                                            'inspi_modulos.nombre as nombre',
                                            'inspi_modulos.estado as estado')->distinct()
        ->join('inspi_opciones', 'inspi_opciones.id', '=', 'inspi_rol_opcion.opcion_id')
        ->join('inspi_modulos', 'inspi_modulos.id', '=', 'inspi_opciones.id_modulo')
        ->join('role_user', 'role_user.role_id', '=', 'inspi_rol_opcion.role_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->join('users', 'users.id', '=', 'role_user.user_id')
        ->whereNotIn('inspi_modulos.estado', ['E', 'I'])->whereIn('users.id', [Auth::id()])
        ->get();

        $Opciones = PermisoRolOpcion::select('inspi_opciones.id as id',
                                                'inspi_opciones.id_modulo as id_modulo',
                                                'inspi_opciones.nombre as nombre',
                                                'inspi_opciones.controller as controller',
                                                'inspi_opciones.icon as icon',
                                                'inspi_opciones.estado as estado')->distinct()
        ->join('inspi_opciones', 'inspi_opciones.id', '=', 'inspi_rol_opcion.opcion_id')
        ->join('role_user', 'role_user.role_id', '=', 'inspi_rol_opcion.role_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->join('users', 'users.id', '=', 'role_user.user_id')
        ->whereNotIn('inspi_opciones.estado', ['E', 'I'])->whereIn('users.id', [Auth::id()])
        ->get();

        $usuarioInf = User::select('db_inspi.r.name as role_name', 'db_inspi.ar.id as id_area')
        ->join('db_inspi.role_user as ro', 'users.id', '=', 'ro.user_id')
        ->join('db_inspi.roles as r', 'r.id', '=', 'ro.role_id')
        ->join('db_inspi.inspi_area as ar', 'ar.id', '=', 'users.id_area')
        ->where('users.id', '=', $id_usuario)
        //->whereIn('r.name', ['Gerente', 'Secretaria'])
        ->first();

        //obtener laboratorio
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        $laboratorios = Laboratorio::where('estado', 'A')->get();

        $cantKits = Kit::where('cantidad', '')->count();

        if(request()->ajax()) {

            return datatables()->of($categoria = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado', 'inv_articulo.precio as precio',
                                    DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad')
                                    ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                                    ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                                    ->where('inv_articulo.estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.create_egreso_inm', compact('Modulos','Opciones', 'unidades', 'categorias', 'laboratorios', 'cantKits', 'labora'));
    }
    /* VISTA - CREAR NUEVO EGRESO INMUNOHEMATOLOGÍA */




    /* OBTENER LOS DATOS DE LA CORRIDA MANUAL - INMUNOHEMATOLOGÍA */
    public function saveCorridaManInm(Request $request)
    {
        //            'nombre'      => 'required|string',
        $data = $request->validate([

            'tecnica' => 'required|string',
            'para'    => 'required|string',
            //'hora'    => 'required|string',
            'fecha'   => 'required|string',
            'tipo'    => 'required|string',
            'equipos' => 'required|string',
            'numero'  => 'required|string',
            'equiposExt' => 'required|string',

            'arn'        => 'required|array',
            'reaccion'   => 'required|array',
            'perfil'     => 'required|array',
            'resultados' => 'required|array',
            'controles'  => 'required|array',
            'estandar'   => 'required|array',
        ]);

        $tecnica = $request->input('tecnica');
        $para    = $request->input('para');
        //$hora = $request->input('hora');
        $fecha   = $request->input('fecha');
        $tipo    = $request->input('tipo');
        $equipos = $request->input('equipos');

        $numero  = $request->input('numero');
        $equiposExt = $request->input('equiposExt');

        $id_usuario = Auth::user()->id;

        //obtener laboratorio
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        $datosCorrida = [
            'id_analista'    => $id_usuario,
            'extraccion_equi' => $equiposExt,
            'equipos'        => $equipos,
            'numero'         => $numero,
            'tecnica'        => $tecnica,
            'servicio'       => $tecnica.' para '. $para,
            'hora'           => 'N/A',
            'fecha'          => $fecha,
            'vigilacia_tipo' => 'N/A',
            'observacion'    => 'N/A',
            'id_laboratorio' => $labora->id,
            'estado'         => 'A',
        ];

        $corrida = Corrida::create($datosCorrida);

        $cant_total = 0;
        $id_movi    = 0;

        if ($corrida) {

            // ===================================== Acceder a los datos de ARN
            $arn = $request->input('arn');

            foreach ($arn as $dato) {

                $kits     = $dato['kits'];
                $muestras = $dato['muestras'];

                foreach ($kits as $kit) {

                    $nombreKit = $kit['nombreKit'];
                    $lote      = $kit['lote'];
                    $fecha     = $kit['fecha'];
                    $observa   = $kit['observa'];
                    $id_movi   = $kit['id_movimiento'];

                    $extracion = Extraccion::create([
                        'id_lote'     => $lote,
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => $observa,
                    ]);

                }

                foreach ($muestras as $muestra) {

                    $codMuestra  = $muestra['codMuestra'];
                    $tipoMuestra = $muestra['tipoMuestra'];

                    $extracionDet = ExtraccionDet::create([
                        'id_muestra'    => $tipoMuestra,
                        'cod_muestra'   => $codMuestra,
                        'id_extraccion' => $extracion->id,
                    ]);

                    $cant_total += 1;

                }

                //se hace el agreso en el inventario
                $id_inventario = $id_movi;
                $rt = $cant_total;
                //$rt = is_numeric($rt) ? (int)$rt : 0;
                $rt = is_numeric($rt) ? $rt : 0;

                //actualiza inventario
                $inventa = Inventario::find($id_inventario);

                $resultadoCal = $inventa->cantidad - $rt;
                if($resultadoCal < 0){
                    $resultadoCal = 0;
                }

                $inventa->cantidad = $resultadoCal;
                $inventa->save();

            }

            // ===================================== Acceder a los datos de reacción
            $reaccion = $request->input('reaccion');

            $id_movi    = 0;
            $cant_total = 0;

            foreach ($reaccion as $dato) {

                $tablaMovimiento = $dato['tablaMovimiento'];
                $tablaMezcla     = $dato['tablaMezcla'];
                $mezclaIDs       = [];

                foreach ($tablaMovimiento as $itemMovimiento) {

                    $mezcla = Mezcla::create([
                        'id_lote'     => $itemMovimiento['lote'],
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => 'N/A',
                    ]);

                    $mezclaIDs[] = $mezcla->id;
                    $id_movi = $itemMovimiento['id_inventario'];

                }

                foreach ($tablaMezcla as $itemMezcla) {

                    //$pruebas = $itemMezcla['pruebas'];


                    foreach ($itemMezcla['datosPruebas'] as $prueba) {

                        //$prueba = $itemMezcla['datosPruebas'][$i];

                        $mezclaDet = MezclaDet::create([
                            'id_examen' => 6,
                            'rx'        => $prueba['rx'],
                            'rt'        => $prueba['rt'],
                            'cant'      => $itemMezcla['cantidad'],
                            'solucion'  => $prueba['solucion'],
                            'id_mezcla' => $mezcla->id,
                        ]);

                        $cant_total = $itemMezcla['cantidad'];

                    }


                    //$numElementos = count($mezclaIDs);
                    //for ($i = 0; $i < $numElementos; $i++) {
                        //$id_mezcla = $mezclaIDs[$i];



                    //}

                }


                //se hace el agreso en el inventario
                $id_inventario = $id_movi;
                $rt = $cant_total;
                //$rt = is_numeric($rt) ? (int)$rt : 0;
                $rt = is_numeric($rt) ? $rt : 0;

                //actualiza inventario
                $inventa = Inventario::find($id_inventario);

                $resultadoCal = $inventa->cantidad - $rt;
                if($resultadoCal < 0){
                    $resultadoCal = 0;
                }

                $inventa->cantidad = $resultadoCal;
                $inventa->save();


            }

            // ===================================== Acceder a los datos de perfil
            $perfil = $request->input('perfil');
            foreach ($perfil as $dato) {
                // Acceder a los datos de cada elemento de perfil
                $datosTermico = $dato['datosTermico'];
                $canales = $dato['canales'];

                $perfil = Perfil::create([
                    'id_corrida' => $corrida->id,
                    'canales'    => $canales,
                ]);

                foreach ($datosTermico as $termico) {

                    PerfilDet::create([
                        'temperatura' => $termico['temperatura'],
                        'tiempo'      => $termico['tiempo'],
                        'ciclos'      => $termico['ciclos'],
                        'id_perfil'   => $perfil->id,
                    ]);

                }

            }



            // ===================================== Acceder a los datos de controles
            $controles = $request->input('controles');

            foreach ($controles as $contr) {
                $umbral    = $contr['umbral'];
                $isChecked = $contr['isChecked'];
                $datosControl = $contr['datosControl'];

                $control = Control::create([
                    'id_corrida' => $corrida->id,
                    'total'      => '0',
                    'umbral'     => $umbral,
                    'automatic'  => $isChecked,
                ]);

                foreach ($datosControl as $dato) {

                    $controlCon   = $dato['controlCon'];
                    $ctControl    = $dato['ctControl'];
                    $resultadoCon = $dato['resultadoCon'];
                    $validaControl = $dato['validaControl'];

                    ControlDet::create([

                        'control_id' => $controlCon,
                        'ct'         => $ctControl,
                        'resultado'  => $resultadoCon,
                        'criterios'  => $validaControl,
                        'id_control' => $control->id,

                    ]);

                }

            }


            // ===================================== Acceder a los datos de standar
            $estandar = $request->input('estandar');

            foreach ($estandar as $dato) {

                $estandar  = $dato['estandar'];
                $concentra = $dato['concentra'];
                $ct        = $dato['ct'];
                $interpreta = $dato['interpreta'];

                Estandar::create([
                    'id_corrida' => $corrida->id,
                    'estandar'   => $estandar,
                    'concentra'  => $concentra,
                    'ct'         => $ct,
                    'interpreta' => $interpreta,
                ]);

            }




            // ===================================== Acceder a los datos de resultados

            $resultados = $request->input('resultados');
            foreach ($resultados as $result) {
                $observaci = $result['observaci'];

                $datosResult = $result['datosResult'];//arreglo

                if($observaci == ''){
                    $observaci = 'N/A';
                }

                $resultado = Resultado::create([

                    'id_corrida'  => $corrida->id,
                    'observacion' => $observaci,
                    'estado'      => 'A',

                ]);

                foreach ($datosResult as $dato) {

                    $codigo      = $dato['codigo'];
                    $paciente    = $dato['paciente'];
                    $procedencia = $dato['procedencia'];
                    $resultados   = $dato['resultado'];
                    $ct          = $dato['ct'];
                    $concentra   = $dato['concentra'];
                    $observa     = $dato['observa'];

                    if($ct == ''){
                        $ct = 'N/A';
                    }

                    $resultadoDet = ResultadoDet::create([
                        'codigo'        => $codigo,
                        'paciente'      => $paciente,
                        'procedencia'   => $procedencia,
                        'ct'            => $ct,
                        'resultado'     => $resultados,
                        'concentracion' => $concentra,
                        'observacion'   => $observa,
                        'id_resultado'  => $resultado->id,
                        'id_muestra'    => 3,
                    ]);

                }

            }

            return response()->json(['message' => 'Corrida guardada exitosamente', 'data' => true, '$id_inventario'=> $id_inventario, '$rt' => $rt], 200);


        } else {

            return response()->json(['message' => 'Error al guardar la corrida', 'data' => false], 500);


        }


    }
    /* OBTENER LOS DATOS DE LA CORRIDA MANUAL - INMUNOHEMATOLOGÍA */




    /* OBTENER LOS DATOS DE LA CORRIDA - INMUNOHEMATOLOGÍA */
    public function saveCorridaInm(Request $request)
    {
        $id_usuario = Auth::user()->id;

        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();

        //datos generales
        $tecnica = $request->input('tecnica');
        $para    = $request->input('para');
        //$hora    = $request->input('hora');
        $fecha   = $request->input('fecha');
        $tipo    = $request->input('tipo');
        $equipos = $request->input('equipos');

        // Acceder a los datos enviados desde el formulario
        $f_reporte = $request->input('f_reporte');
        $f_procesa = $request->input('f_procesa');
        $observacionRes = $request->input('observacion');
        $numero     = $request->input('numero');
        $equiposExt = $request->input('equiposExt');

        $datosCorrida = [
            'id_analista'    => $id_usuario,
            'extraccion_equi' => $equiposExt,
            'equipos'        => $equipos,
            'numero'         => $numero,
            'tecnica'        => $tecnica,
            'servicio'       => $tecnica.' para '. $para,
            'hora'           => 'N/A',
            'fecha'          => $fecha,
            'vigilacia_tipo' => 'N/A',
            'observacion'    => 'N/A',
            'id_laboratorio' => $labora->id,
            'estado'         => 'A',
        ];

        $corrida = Corrida::create($datosCorrida);

        if ($corrida) {

            // ===================================== Acceder a los datos de ARN
            $arn = $request->input('arn');
            $id_moviADN = 0;
            foreach ($arn as $dato) {
                $kits     = $dato['kits'];
                $muestras = $dato['muestras'];

                foreach ($kits as $kit) {

                    $nombreKit = $kit['nombreKit'];
                    $lote      = $kit['lote'];
                    $fecha     = $kit['fecha'];
                    $observa   = $kit['observa'];
                    $id_moviADN = $kit['id_movimiento'];

                    $extracion = Extraccion::create([
                        'id_lote'     => $lote,
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => $observa,
                    ]);
                }
                /*
                foreach ($muestras as $muestra) {

                    $codMuestra  = $muestra['codMuestra'];
                    $tipoMuestra = $muestra['tipoMuestra'];

                    $extracionDet = ExtraccionDet::create([
                        'id_muestra'    => $tipoMuestra,
                        'cod_muestra'   => $codMuestra,
                        'id_extraccion' => $extracion->id,
                    ]);

                }
                */

            }

            // ===================================== Acceder a los datos de reacción
            $reaccion = $request->input('reaccion');
            $id_movi = 0;
            $cant_total = 0;
            foreach ($reaccion as $dato) {

                $tablaMovimiento = $dato['tablaMovimiento'];
                $tablaMezcla     = $dato['tablaMezcla'];
                $mezclaIDs       = [];

                foreach ($tablaMovimiento as $itemMovimiento) {

                    $mezcla = Mezcla::create([
                        'id_lote'     => $itemMovimiento['lote'],
                        'id_corrida'  => $corrida->id,
                        'numero'      => '0',
                        'observacion' => 'N/A',
                    ]);

                    $mezclaIDs[] = $mezcla->id;

                    $id_movi = $itemMovimiento['id_inventario'];

                }

                foreach ($tablaMezcla as $itemMezcla) {

                    foreach ($itemMezcla['datosPruebas'] as $prueba) {

                        $mezclaDet = MezclaDet::create([
                            'id_examen' => 6,
                            'rx'        => $prueba['rx'],
                            'rt'        => $prueba['rt'],
                            'cant'      => $itemMezcla['cantidad'],
                            'solucion'  => $prueba['solucion'],
                            'id_mezcla' => $mezcla->id,
                        ]);

                        $cant_total = $itemMezcla['cantidad'];

                    }



                    //se hace el agreso en el inventario
                    $id_inventario = $id_movi;
                    $rt = $cant_total;
                    //$rt = is_numeric($rt) ? (int)$rt : 0;
                    $rt = is_numeric($rt) ? $rt : 0;

                    //actualiza inventario
                    $inventa = Inventario::find($id_inventario);

                    $resultadoCal = $inventa->cantidad - $rt;
                    if($resultadoCal < 0){
                        $resultadoCal = 0;
                    }

                    $inventa->cantidad = $resultadoCal;
                    $inventa->save();



                }



            }



            // ===================================== Acceder a los datos de standar
            $estandar = $request->input('estandar');

            foreach ($estandar as $dato) {

                $estandar  = $dato['estandar'];
                $concentra = $dato['concentra'];
                $ct        = $dato['ct'];
                $interpreta = $dato['interpreta'];

                Estandar::create([
                    'id_corrida' => $corrida->id,
                    'estandar'   => $estandar,
                    'concentra'  => $concentra,
                    'ct'         => $ct,
                    'interpreta' => $interpreta,
                ]);

            }


            // ===================================== Acceder a los datos de perfil
            $perfil = $request->input('perfil');
            foreach ($perfil as $dato) {
                // Acceder a los datos de cada elemento de perfil
                $datosTermico = $dato['datosTermico'];
                $canales = $dato['canales'];

                $perfil = Perfil::create([
                    'id_corrida' => $corrida->id,
                    'canales'    => $canales,
                ]);

                foreach ($datosTermico as $termico) {

                    PerfilDet::create([
                        'temperatura' => $termico['temperatura'],
                        'tiempo'      => $termico['tiempo'],
                        'ciclos'      => $termico['ciclos'],
                        'id_perfil'   => $perfil->id,
                    ]);

                }

            }

            // ===================================== Acceder a los datos de controles
            $controles = $request->input('controles');

            foreach ($controles as $contr) {
                $umbral    = $contr['umbral'];
                $isChecked = $contr['isChecked'];
                $datosControl = $contr['datosControl'];

                $control = Control::create([
                    'id_corrida' => $corrida->id,
                    'total'      => '0',
                    'umbral'     => $umbral,
                    'automatic'  => $isChecked,
                ]);

                foreach ($datosControl as $dato) {

                    $controlCon   = $dato['controlCon'];
                    $ctControl    = $dato['ctControl'];
                    $resultadoCon = $dato['resultadoCon'];
                    $validaControl = $dato['validaControl'];

                    ControlDet::create([

                        'control_id' => $controlCon,
                        'ct'         => $ctControl,
                        'resultado'  => $resultadoCon,
                        'criterios'  => $validaControl,
                        'id_control' => $control->id,

                    ]);

                }

            }



            // ===================================== CREAMOS LA CABEZERA DE RESULTADOS
            if($observacionRes == ''){
                $observacionRes = 'N/A';
            }
            $resultado = Resultado::create([

                'id_corrida'  => $corrida->id,
                'f_procesa'   => $f_procesa,
                'f_reporte'   => $f_reporte,
                'observacion' => $observacionRes,
                'estado'      => 'A',

            ]);


            $fileADN = $request->file('fileADN');
            $fileNameADN = time() . '_' . $fileADN->getClientOriginalName();
            $fileADN->move(public_path('uploads'), $fileNameADN);
            //Excel::import(new ExtracionImport($extracion->id), public_path('uploads') . '/' . $fileNameADN);

            $import = new ExtracionImport($extracion->id);
            Excel::import($import, public_path('uploads') . '/' . $fileNameADN);

            //se hace el agreso en el inventario
            $id_inventario = $id_moviADN;
            $rt = $import->getRowCount();
            //$rt = is_numeric($rt) ? (int)$rt : 0;
            $rt = is_numeric($rt) ? $rt : 0;

            //actualiza inventario
            $inventa = Inventario::find($id_inventario);

            $resultadoCal = $inventa->cantidad - $rt;
            if($resultadoCal < 0){
                $resultadoCal = 0;
            }

            $inventa->cantidad = $resultadoCal;
            $inventa->save();



            $file = $request->file('file');
            // Generar un nombre único para el archivo
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Mover el archivo a una ubicación específica
            $file->move(public_path('uploads'), $fileName);

            // Importar el archivo usando el nombre único y los datos adicionales
            Excel::import(new ResultadosImportInm($resultado->id), public_path('uploads') . '/' . $fileName);

            return response()->json(['message' => 'Corrida guardada exitosamente', 'data' => true, '$id_inventario'=> $id_inventario, '$rt' => $rt], 200);


        } else {

            return response()->json(['message' => 'Error al guardar la corrida', 'data' => false], 500);


        }


    }
    /* OBTENER LOS DATOS DE LA CORRIDA - INMUNOHEMATOLOGÍA */



    // ============================================================ INMUNOHEMATOLOGÍA ============================================================





    // ============================================================ INFLUENZA ============================================================

    /* VISTA - CREAR NUEVO EGRESO INFLUENZA */
    public function crearEgresoInf(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        //obtener laboratorio
        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();


        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        $laboratorios = CRN::where('estado', 'A')->get();

        $cantKits = Kit::where('cantidad', '')->count();

        if(request()->ajax()) {

            return datatables()->of($categoria = Articulo::select('inv_articulo.id as id', 'inv_articulo.nombre as nombre', 'inv_articulo.estado as estado', 'inv_articulo.precio as precio',
                                    DB::raw('DATE_FORMAT(inv_articulo.created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'cat.nombre as categoria', 'uni.abreviatura as unidad')
                                    ->join('db_inspi_inventario.inv_categoria as cat', 'cat.id', '=', 'inv_articulo.id_categoria')
                                    ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv_articulo.id_unidad')
                                    ->where('inv_articulo.estado', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.create_egreso_inf', compact('unidades', 'categorias', 'laboratorios',
            'cantKits', 'labora', 'id_usuario'));
    }
    /* VISTA - CREAR NUEVO EGRESO INFLUENZA */




    // ============================================================

    public function realizarEgresoExamen($array, $corrida){

        $horaActual = date('H:i:s');
        // ===================================== Acceder a los datos Extracción
        $datosExtra = $array;

        if ($datosExtra) {

            foreach ($datosExtra as $prueba) {

                $nombrePrueba = $prueba['prueba'];
                $fecha        = $prueba['fecha'];
                $usuario      = $prueba['usuario'];

                foreach ($prueba['filas'] as $fila) {
                    $id_movimiento = $fila['id_movimiento'];
                    $articulo      = $fila['articulo'];
                    $lote          = $fila['lote'];
                    $valorDef      = $fila['valorDef'];
                    $cantidadIn    = $fila['cantidad'];
                    $total         = $fila['total'];


                    if($lote != '0' /*|| $lote != 0 || $id_movimiento != 0 || $id_movimiento != '0'*/){

                        //se hace el egreso en el inventario
                        $id_inventario = $id_movimiento;
                        $rt = $total;
                        //$rt = is_numeric($rt) ? (int)$rt : 0;
                        $rt = is_numeric($rt) ? $rt : 0;

                        $movimientos = Inventario::select('inv_inventario.id', 'inv_inventario.cantidad as unidades', 'inv_kit.cantidad', 'inv_kit.id as id_kit',
                            'inv_kit.cant_actual as cant_actual')
                            ->join('db_inspi_inventario.inv_kit', 'inv_kit.id_inventario', '=', 'inv_inventario.id')
                            ->where('inv_inventario.id', '=', $id_inventario)
                            ->first();

                        $id_inv      = $movimientos->id;
                        $unidades    = $movimientos->unidades;
                        $unidades = is_numeric($unidades) ? $unidades : 0;

                        $cantidad    = $movimientos->cantidad;
                        $cantidad = is_numeric($cantidad) ? $cantidad : 0;

                        $id_kit      = $movimientos->id_kit;
                        $cant_actual = $movimientos->cant_actual;
                        $cant_actual = is_numeric($cant_actual) ? $cant_actual : 0;

                        $resultadoCal = $cant_actual - $rt;

                        $aux = 0;

                        $inventa = Inventario::find($id_inventario);
                        $ini_saldo = $inventa->cantidad;
                        $fin_saldo = $inventa->cantidad;

                        if ($resultadoCal <= 0) {

                            $cantidad_total_unidades = $rt; // La cantidad total de unidades consumidas
                            $unidades_por_reactivo   = $cantidad; // La cantidad de unidades por reactivo

                            // Calcula cuántos reactivos completos has consumido
                            $cantidad_reactivos_consumidos = floor($cantidad_total_unidades / $unidades_por_reactivo);
                            $kits = Kit::find($id_kit);

                            if($unidades_por_reactivo != 1){ //si lo reactivos son de 1 a 1, se salta este proceso



                                // Calcula cuántas unidades de un reactivo tienes aún
                                //$unidades_restantes = $resultadoCal;

                                //actualiza inventario
                                $aux = $resultadoCal;

                                if($aux < 0){

                                    do {
                                        $aux = $kits->cantidad + $aux;
                                    } while ($aux < 0);

                                    if($aux == 0){
                                        $aux = $kits->cantidad;
                                        $cantidad_reactivos_consumidos += 1;
                                    }

                                }else if($aux == 0){
                                    $aux = $kits->cantidad;
                                    //$cantidad_reactivos_consumidos += 1;
                                }else{
                                    $cantidad_reactivos_consumidos += 1;
                                }

                                //$kits->cant_actual = $kits->cant_actual - $unidades_restantes;
                                $kits->cant_actual = $aux;

                            }

                            $kits->consumido   = $rt + $kits->consumido;
                            $kits->save();

                            //actualiza inventario
                            $inventa->cantidad    = $inventa->cantidad  - $cantidad_reactivos_consumidos;
                            $inventa->save();

                            //para la tabla movimiento
                            $fin_saldo = $fin_saldo - $cantidad_reactivos_consumidos;

                        }else{

                            $kits = Kit::find($id_kit);
                            $kits->cant_actual = $resultadoCal;
                            $kits->consumido   = $rt + $kits->consumido;

                            $kits->save();

                        }

                        $movimiento = MovimientoCor::create([

                            'id_usuario'   => $usuario,
                            'id_lote'      => $lote,
                            'cantidad'     => $cantidadIn,
                            'valor'        => $valorDef,
                            'total'        => $total,

                            'prueba'       => 'Extracción de ARN',
                            'fecha'        => $fecha. ' ' . $horaActual,
                            'ini_saldo'    => $ini_saldo,
                            'fin_saldo'    => $fin_saldo,
                            'id_movimiento_inv' => $id_movimiento,
                            'id_corrida'   => $corrida->id

                        ]);

                    }

                }
            }
        }
        


    }

    // ============================================================





    /* OBTENER LOS DATOS DE LA CORRIDA MANUAL - INFLUENZA */
    public function saveCorridaManInf(Request $request)
    {

        $data = $request->validate([

            'tecnica' => 'required|string',
            'fecha'   => 'required|string',
            'tipo'    => 'required|string',
            'protocolo'   => 'required|string',
            'observacion' => 'required|string',
            //'estacional'  => 'required|array',
            //'variante'    => 'required|array',

        ]);

        $tecnica     = $request->input('tecnica');
        $fecha       = $request->input('fecha');
        $tipo        = $request->input('tipo');
        $protocolo   = $request->input('protocolo');
        $observacion = $request->input('observacion');

        /*
        $estacional = $request->input('estacional');
        if (count($estacional) === 1) {
            $estacionalString = reset($estacional);
        } else {
            $estacionalString = implode(',', $estacional);
        }

        $variante = $request->input('variante');
        if (count($variante) === 1) {
            $varianteString = reset($variante);
        } else {
            $varianteString = implode(',', $variante);
        }
        */

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id', 'lab.descripcion as nombre')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $datosCorrida = [
            'id_analista'    => $id_usuario,
            'extraccion_equi' => 'N/A',
            'equipos'        => 'N/A',
            'numero'         => 'N/A',
            'tecnica'        => $tecnica,
            'servicio'       => $protocolo,
            'hora'           => 'N/A',
            'fecha'          => $fecha,
            'vigilacia_tipo' => 'N/A',
            'estacional'     => 'N/A',
            'variante'       => 'N/A',
            'observacion'    => $observacion,
            'id_laboratorio' => $labora->id,
            'estado'         => 'A',
        ];

        $corrida = Corrida::create($datosCorrida);

        if ($corrida) {


            // ===================================== Acceder a los datos Extracción
            $datosExtra = $request->input('extraccion');
            $this->realizarEgresoExamen($datosExtra, $corrida);


            // ===================================== Acceder a los datos RT-PCR
            $datosPCR = $request->input('pcr');
            $this->realizarEgresoExamen($datosPCR, $corrida);


            // ===================================== Acceder a los datos Monoclonales
            $datosMono = $request->input('mono');
            $this->realizarEgresoExamen($datosMono, $corrida);


            // ===================================== Acceder a los datos Policlonales
            $datosPoli = $request->input('poli');
            $this->realizarEgresoExamen($datosPoli, $corrida);


            // ===================================== Acceder a los datos Influenza A
            $influA = $request->input('influA');
            $this->realizarEgresoExamen($influA, $corrida);


            // ===================================== Acceder a los datos Influenza B
            $influB = $request->input('influB');
            $this->realizarEgresoExamen($influB, $corrida);


            // ===================================== Acceder a los datos Covid
            $covid = $request->input('covid');
            $this->realizarEgresoExamen($covid, $corrida);


            // ===================================== Acceder a los datos Virus sincitial respiratorio
            $sincitial = $request->input('sincitial');
            $this->realizarEgresoExamen($sincitial, $corrida);


            // ===================================== Acceder a los datos Covid
            $insumos = $request->input('insumos');
            $this->realizarEgresoExamen($insumos, $corrida);


            return response()->json(['message' => 'Corrida guardada exitosamente', 'data' => true], 200);


        } else {

            return response()->json(['message' => 'Error al guardar la corrida', 'data' => false], 500);

        }
    }
    /* OBTENER LOS DATOS DE LA CORRIDA MANUAL - INFLUENZA */





    /* GENERAR PDF REACTIVOS */
    public function reportReactivo(Request $request)
    {
        $id_articulo    = $request->query('id_articulo');
        $id_laboratorio = $request->query('id_laboratorio');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $datosArt = Articulo::select('nombre', 'descripcion')->where('estado', '=', 'A')->where('id', '=', $id_articulo)->first();

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();
            
        $movimientos = DB::table('db_inspi_labcorrida.cor_movimiento as movC')
        ->join('db_inspi_inventario.inv_lote as lot', 'movC.id_lote', '=', 'lot.id')
        ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
        ->join('bdcoreinspi.users as usu', 'movC.id_usuario', '=', 'usu.id')
        ->join('db_inspi_inventario.inv_inventario as inv', 'lot.id', '=', 'inv.id_lote')
        ->select(
            'usu.name as usuario',
            'art.nombre as reactivo',
            'movC.valor',
            'movC.cantidad',
            'movC.total',
            'movC.fecha',
            DB::raw('"Egreso" as tipo_movimiento'),
            'movC.prueba',
            'movC.ini_saldo as ini_saldo',
            'movC.fin_saldo as fin_saldo',
            'inv.cant_minima',
            'movC.created_at'
        )
        ->where('inv.id_laboratorio', $id_laboratorio)
        ->where('art.id', $id_articulo)
        ->whereBetween('movC.fecha', [$fInicio, $fFin])
        ->unionAll(
            DB::table('db_inspi_inventario.inv_movimiento as mov')
                ->join('db_inspi_inventario.inv_lote as lot', 'mov.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('bdcoreinspi.users as usu', 'mov.id_usuario', '=', 'usu.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'mov.uni_medida', '=', 'uni.id')
                ->join('db_inspi_inventario.inv_acta as act', 'mov.id_acta', '=', 'act.id')
                ->select(
                    'usu.name as usuario',
                    'art.nombre as reactivo',
                    DB::raw('"" as valor'),
                    'mov.unidades as cantidad',
                    'mov.precio_total as total',
                    DB::raw("DATE_FORMAT(mov.created_at, '%Y-%m-%d') as fecha"),
                    DB::raw("
                    CASE
                        WHEN act.tipo = 'I' THEN 'Ingreso'
                        WHEN act.tipo = 'E' THEN 'Egreso'
                        WHEN act.tipo = 'C' THEN 'Compra local'
                        WHEN act.tipo = 'D' THEN 'Donación'
                        WHEN act.tipo = 'A' THEN 'Ajuste'
                        WHEN act.tipo = 'T' THEN 'Transferencia'
                        ELSE act.tipo
                    END as tipo_movimiento"),
                    DB::raw('"" as prueba'),
                    'mov.saldo_ini as ini_saldo',
                    'mov.saldo_fin as fin_saldo',
                    DB::raw('"" as cant_minima'), // Ajuste ya que inv_movimiento no tiene el campo cant_minima
                    'mov.created_at'
                )
                ->where('mov.estado', '=', 'A')
                ->where('lot.id_articulo', '=', $id_articulo)
                ->where('act.origen', '=', $id_laboratorio)
                ->whereBetween('mov.created_at', [$fInicio, $fFin])
        )
        ->orderBy('created_at', 'asc')
        ->get();

        $pdf = \PDF::loadView('pdf.pdfreactivos', ['movimientos' => $movimientos, 'results' => $results, 'datosArt' => $datosArt])->setPaper('a4', 'landscape');

        return $pdf->download('pdfreactivos.pdf');
    }
    /* GENERAR PDF REACTIVOS */



    /* GENERAR PDF REACTIVOS KARDEX */
    public function reportReactivoKardex(Request $request)
    {
        $id_articulo    = $request->query('id_articulo');
        $id_laboratorio = $request->query('id_laboratorio');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $datosArt = Articulo::select('nombre', 'descripcion')->where('estado', '=', 'A')->where('id', '=', $id_articulo)->first();

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        //total de los ingresados
        $totalIng = DB::table('db_inspi_inventario.inv_movimiento as mov')
            ->join('db_inspi_inventario.inv_lote as lot', 'mov.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_acta as act', 'mov.id_acta', '=', 'act.id')
            ->where('mov.estado', '=', 'A')
            ->where('lot.id_articulo', '=', $id_articulo)
            ->where('act.origen', '=', $id_laboratorio)
            ->whereBetween('mov.created_at', [$fInicio, $fFin])
            ->sum('mov.unidades');

        $totalEgr = DB::table('db_inspi_labcorrida.cor_movimiento as movC')
            ->join('db_inspi_inventario.inv_lote as lot', 'movC.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('db_inspi_inventario.inv_inventario as inv', 'lot.id', '=', 'inv.id_lote')
            ->where('inv.id_laboratorio', $id_laboratorio)
            ->where('art.id', $id_articulo)
            ->whereBetween('movC.fecha', [$fInicio, $fFin])
            ->sum('movC.total');  


        $movimientos = DB::table('db_inspi_labcorrida.cor_movimiento as movC')
        ->join('db_inspi_inventario.inv_lote as lot', 'movC.id_lote', '=', 'lot.id')
        ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
        ->join('bdcoreinspi.users as usu', 'movC.id_usuario', '=', 'usu.id')
        ->join('db_inspi_inventario.inv_inventario as inv', 'lot.id', '=', 'inv.id_lote')
        ->join('db_inspi_inventario.inv_unidad as uni', 'inv.id_unidad', '=', 'uni.id')
        ->select(
            'usu.name as usuario',
            'art.nombre as reactivo',
            'lot.nombre as nom_lote',
            'uni.nombre as uni_nombre',
            'uni.abreviatura as uni_abreviatura',
            'movC.valor',
            'movC.cantidad',
            'movC.total',
            'movC.fecha',
            DB::raw('"E" as tipo'),
            'movC.prueba',
            'movC.ini_saldo as saldo_ini',
            'movC.fin_saldo as fin_saldo',
            'inv.cant_minima',
            'movC.created_at'
        )
        ->where('inv.id_laboratorio', $id_laboratorio)
        ->where('art.id', $id_articulo)
        ->whereBetween('movC.fecha', [$fInicio, $fFin])
        ->unionAll(
            DB::table('db_inspi_inventario.inv_movimiento as mov')
                ->join('db_inspi_inventario.inv_lote as lot', 'mov.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('bdcoreinspi.users as usu', 'mov.id_usuario', '=', 'usu.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'mov.uni_medida', '=', 'uni.id')
                ->join('db_inspi_inventario.inv_acta as act', 'mov.id_acta', '=', 'act.id')
                ->select(
                    'usu.name as usuario',
                    'art.nombre as reactivo',
                    'lot.nombre as nom_lote',
                    'uni.nombre as uni_nombre',
                    'uni.abreviatura as uni_abreviatura',
                    'mov.precio as valor',
                    'mov.unidades as cantidad',
                    'mov.precio_total as total',
                    'mov.created_at as fecha',
                    'act.tipo as tipo',
                    DB::raw('"Ingreso de reactivos" as prueba'),
                    'mov.saldo_ini as saldo_ini',
                    'mov.saldo_fin as fin_saldo',
                    DB::raw('"" as cant_minima'), // Ajuste ya que inv_movimiento no tiene el campo cant_minima
                    'mov.created_at'
                )
                ->where('mov.estado', '=', 'A')
                ->where('lot.id_articulo', '=', $id_articulo)
                ->where('act.origen', '=', $id_laboratorio)
                ->whereBetween('mov.created_at', [$fInicio, $fFin])
        )
        ->orderBy('fecha', 'asc')
        ->get();

        $pdf = \PDF::loadView('pdf.reporte_laboratorios.pdf_kardex', 
            ['movimientos' => $movimientos, 
            'results'  => $results, 
            'datosArt' => $datosArt,
            'fFin'     => $fFin,
            'fInicio'  => $fInicio,
            'totalIng' => $totalIng,
            'totalEgr' => $totalEgr])->setPaper('a4', 'landscape');

        return $pdf->download('pdfreactivos.pdf');
    }
    /* GENERAR PDF REACTIVOS KARDEX */




    /* GENERAR PDF REPORTE DE ARTICULOS DE INVENTARIO */
    public function reportBodegaInvetario(Request $request)
    {
        $id_articulo    = $request->query('id_articulo');
        $id_laboratorio = $request->query('id_laboratorio');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $datosArt = Articulo::select('nombre', 'descripcion')->where('estado', '=', 'A')->where('id', '=', $id_articulo)->first();

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        $movimientos = Movimiento::select('usu.name as usuario', 'art.nombre as reactivo', 'inv_movimiento.unidades',
            'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura', 'lot.nombre as nom_lote', 'inv_movimiento.precio',
            'inv_movimiento.precio_total', 'inv_movimiento.saldo_ini', 'inv_movimiento.saldo_fin', 'act.tipo',
            DB::raw("DATE_FORMAT(inv_movimiento.created_at, '%Y-%m-%d') as fecha"), 'act.transaccion',
            DB::raw("
            CASE
                WHEN act.tipo = 'I' THEN 'Ingreso'
                WHEN act.tipo = 'E' THEN 'Egreso'
                WHEN act.tipo = 'C' THEN 'Compra local'
                WHEN act.tipo = 'D' THEN 'Donación'
                WHEN act.tipo = 'A' THEN 'Ajuste'
                WHEN act.tipo = 'T' THEN 'Transferencia'
                ELSE act.tipo
            END as tipo_movimiento
            "))
            ->join('db_inspi_inventario.inv_lote as lot', 'inv_movimiento.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('bdcoreinspi.users as usu', 'inv_movimiento.id_usuario', '=', 'usu.id')

            ->join('db_inspi_inventario.inv_unidad as uni', 'inv_movimiento.uni_medida', '=', 'uni.id')
            ->join('db_inspi_inventario.inv_acta as act', 'inv_movimiento.id_acta', '=', 'act.id')

            ->where('inv_movimiento.estado', '=', 'A')
            ->where('lot.id_articulo', '=', $id_articulo)  
            ->where('act.origen', '=', $id_laboratorio)
            ->whereBetween('inv_movimiento.created_at', [$fInicio, $fFin])
            ->orderBy('inv_movimiento.created_at', 'asc')
            ->get();

        $pdf = \PDF::loadView('pdf.pdf_kardex', ['movimientos' => $movimientos, 'results' => $results, 'datosArt' => $datosArt])->setPaper('a4', 'landscape');

        return $pdf->download('Kardex.pdf');
    }
    /* GENERAR PDF REPORTE DE ARTICULOS DE INVENTARIO */

    

    public function kardexInventario(Request $request){
        $id_articulo    = $request->query('id_articulo');
        $id_laboratorio = $request->query('id_laboratorio');
        $id_inventario  = $request->query('id_inventario');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $datosArt = Articulo::select('nombre', 'descripcion')->where('estado', '=', 'A')->where('id', '=', $id_articulo)->first();

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        $datosLabo = Inventario::select('lab.descripcion as laboratorio')
            ->join('inspi_crns.crns as lab','inv_inventario.id_laboratorio','=','lab.id')
            ->where('inv_inventario.id','=', $id_inventario)
            ->first();

        $movimientos = Movimiento::select('usu.name as usuario','art.nombre as reactivo', 'inv_movimiento.unidades',
            'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura', 'lot.nombre as nom_lote', 'inv_movimiento.precio',
            'inv_movimiento.precio_total', 'inv_movimiento.saldo_ini', 'inv_movimiento.saldo_fin', 'act.tipo',
            DB::raw("DATE_FORMAT(inv_movimiento.created_at, '%Y-%m-%d') as fecha"), 'act.transaccion',
            DB::raw("
                CASE
                    WHEN act.tipo = 'I' THEN 'Ingreso'
                    WHEN act.tipo = 'E' THEN 'Egreso'
                    WHEN act.tipo = 'C' THEN 'Compra local'
                    WHEN act.tipo = 'D' THEN 'Donación'
                    WHEN act.tipo = 'A' THEN 'Ajuste'
                    WHEN act.tipo = 'T' THEN 'Transferencia'
                    ELSE act.tipo
                END as tipo_movimiento
            "))
            ->join('db_inspi_inventario.inv_lote as lot', 'inv_movimiento.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('bdcoreinspi.users as usu', 'inv_movimiento.id_usuario', '=', 'usu.id')

            ->join('db_inspi_inventario.inv_unidad as uni', 'inv_movimiento.uni_medida', '=', 'uni.id')
            ->join('db_inspi_inventario.inv_acta as act', 'inv_movimiento.id_acta', '=', 'act.id')

            ->where('inv_movimiento.estado', '=', 'A')
            ->where('lot.id_articulo', '=', $id_articulo)
            ->whereBetween('inv_movimiento.created_at', [$fInicio, $fFin])
            ->orderBy('inv_movimiento.created_at', 'asc')
        ->get();

        $pdf = \PDF::loadView('pdf.kardex_inv', ['movimientos' => $movimientos, 'results' => $results, 'datosArt' => $datosArt, 'datosLabo' => $datosLabo])->setPaper('a4', 'landscape');

        return $pdf->download('Kardex_inventario.pdf');
        //return response()->json(['message' => $movimientos, 'data' => true], 200);
    }

    // ============================================================ INFLUENZA ============================================================






    /* GENERAR PDF REPORTE DE INVENTARIO */
    public function reportInventario(Request $request)
    {
        $id_laboratorio = $request->query('id_laboratorio');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $fCategoria   = $request->query('fCategoria');
        $fLaboratorio = $request->query('fLaboratorio');

        $fCategoriaArray = explode(',', $fCategoria);
        $fLaboratorioArray = explode(',', $fLaboratorio);

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        //$fechaInicio = Carbon::parse($request->input('fInicio'))->startOfDay();
        //$fechaFin = Carbon::parse($request->input('fFin'))->endOfDay();

            // Primer Query: Consumo
            $queryConsumo = DB::table('db_inspi_labcorrida.cor_movimiento as movC')
                ->join('db_inspi_inventario.inv_lote as lot', 'movC.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_categoria as cat', 'art.id_categoria', '=', 'cat.id')
                ->join('db_inspi_labcorrida.cor_corrida as cor', 'movC.id_corrida', '=', 'cor.id')
                ->join('inspi_crns.crns as lab', 'cor.id_laboratorio', '=', 'lab.id')
                ->select(
                    'art.id as reactivo_id',
                    'art.nombre as reactivo',
                    DB::raw('SUM(movC.total) as consumo')
                )
                ->whereBetween('movC.fecha', [$fInicio, $fFin])
                //->where('cor.id_laboratorio', $id_laboratorio)
                ->groupBy('art.id', 'art.nombre');

                /*
            if (!empty($fCategoriaArray) && $fCategoriaArray[0] != '') {
                $queryConsumo->whereIn('cat.id', $fCategoriaArray);
            }
                */
            if (!empty($fLaboratorioArray) && $fLaboratorioArray[0] != '') {
                $queryConsumo->whereIn('cor.id_laboratorio', $fLaboratorioArray);
            }
            
            $consumos = $queryConsumo->get();


            // Segundo Query: Stock en bodega
            $queryStock = DB::table('db_inspi_inventario.inv_inventario as inv_inventario')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->select(
                    'art.id as reactivo_id',
                    DB::raw('SUM(inv_inventario.cantidad) as saldo_final')
                )
                //->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->groupBy('art.id');

            /*
            if (!empty($fCategoriaArray) && $fCategoriaArray[0] != '') {
                $queryStock->whereIn('art.id_categoria', $fCategoriaArray);
            }
            */
            if (!empty($fLaboratorioArray) && $fLaboratorioArray[0] != '') {
                $queryStock->whereIn('inv_inventario.id_laboratorio', $fLaboratorioArray);
            }
            
            $stocks = $queryStock->get();




            $queryIngresa = DB::table('db_inspi_inventario.inv_movimiento as mov')
                ->join('db_inspi_inventario.inv_lote as lot', 'mov.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('bdcoreinspi.users as usu', 'mov.id_usuario', '=', 'usu.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'mov.uni_medida', '=', 'uni.id')
                ->join('db_inspi_inventario.inv_acta as act', 'mov.id_acta', '=', 'act.id')
                ->select(
                    'art.id as reactivo_id',
                    DB::raw('SUM(mov.unidades) as ingresado')
                )
                ->where('mov.estado', '=', 'A')
                //->where('act.origen', '=', $id_laboratorio)
                ->whereBetween('mov.created_at', [$fInicio, $fFin])
                ->groupBy('art.id');

                if (!empty($fLaboratorioArray) && $fLaboratorioArray[0] != '') {
                    $queryIngresa->whereIn('act.origen', $fLaboratorioArray);
                }
                $ingresas = $queryIngresa->get();



            // Combinar resultados en un arreglo
            $resultadoFinal = [];
            foreach ($consumos as $consumo) {
                $reactivoId = $consumo->reactivo_id;
            
                // Buscar el stock correspondiente
                $stock = $stocks->firstWhere('reactivo_id', $reactivoId);
                $ingresa = $ingresas->firstWhere('reactivo_id', $reactivoId);

                $movimiento = DB::table('db_inspi_labcorrida.cor_movimiento as mov')
                    ->join('db_inspi_inventario.inv_lote as lot', 'mov.id_lote', '=', 'lot.id')
                    ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                    ->where('art.id', $reactivoId)
                    ->where('mov.fecha', '<', $fInicio)
                    ->orderBy('mov.fecha', 'desc') 
                    ->first();

                // Obtener el saldo final o 0 si no se encuentra el registro
            
                $resultadoFinal[] = [
                    'reactivo_id' => $consumo->reactivo_id,
                    'reactivo' => $consumo->reactivo,
                    'consumo' => $consumo->consumo,
                    'saldo_final' => $stock ? $stock->saldo_final : 0,
                    'ingresado' => $ingresa ? $ingresa->ingresado : 0,
                    'saldo_inicial' => $movimiento ? $movimiento->fin_saldo : 0,
                ];
            }

            // $resultadoFinal ahora contiene la combinación de consumo y stock


        
            /*
            // Combinar los resultados
            $movimientosR = DB::table(DB::raw("({$queryConsumo->toSql()}) as consumo"))
                ->mergeBindings($queryConsumo) // Para mantener los bindings de la primera consulta
                ->leftJoin(DB::raw("({$queryStock->toSql()}) as stock"), 'consumo.reactivo_id', '=', 'stock.reactivo_id')
                ->mergeBindings($queryStock) // Para mantener los bindings de la segunda consulta
                ->select(
                    'consumo.reactivo_id',
                    'consumo.reactivo',
                    'stock.saldo_final',
                    'consumo.consumo'
                )
                ->orderBy('consumo.reactivo_id')
                ->get();
            */


        $pdf = \PDF::loadView('pdf.pdfreactivos_invent', ['fInicio' => $fInicio, 'fFin' => $fFin, 'results' => $results, 
            'resultadoFinal' => $resultadoFinal, 'stocks' => $stocks, 'consumos' => $consumos])->setPaper('a4', 'landscape');
        return $pdf->download('pdfreactivos_invent.pdf');

    }
    /* GENERAR PDF REPORTE DE INVENTARIO */


    /* GENERAR PDF REPORTE DE MOVIMIENTO DE INVENTARIO GENERAL */
    public function reportMovimientoGeneral(Request $request)
    {
        $id_laboratorio = $request->query('id_laboratorio');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $fCategoria   = $request->query('fCategoria');
        $fCategoriaArray = explode(',', $fCategoria);

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        $movimientos = Movimiento::select('usu.name as usuario', 'art.nombre as reactivo', 'inv_movimiento.unidades',
            'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura', 'lot.nombre as nom_lote', 'inv_movimiento.precio',
            'inv_movimiento.precio_total', 'inv_movimiento.saldo_ini', 'inv_movimiento.saldo_fin', 'act.tipo',
            DB::raw("DATE_FORMAT(inv_movimiento.created_at, '%Y-%m-%d') as fecha"), 'act.transaccion',
            DB::raw("
            CASE
                WHEN act.tipo = 'I' THEN 'Ingreso'
                WHEN act.tipo = 'E' THEN 'Egreso'
                WHEN act.tipo = 'C' THEN 'Compra local'
                WHEN act.tipo = 'D' THEN 'Donación'
                WHEN act.tipo = 'A' THEN 'Ajuste'
                WHEN act.tipo = 'T' THEN 'Transferencia'
                ELSE act.tipo
            END as tipo_movimiento
            "))
            ->join('db_inspi_inventario.inv_lote as lot', 'inv_movimiento.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('bdcoreinspi.users as usu', 'inv_movimiento.id_usuario', '=', 'usu.id')
            ->join('db_inspi_inventario.inv_categoria as cat', 'art.id_categoria', '=', 'cat.id')

            ->join('db_inspi_inventario.inv_unidad as uni', 'inv_movimiento.uni_medida', '=', 'uni.id')
            ->join('db_inspi_inventario.inv_acta as act', 'inv_movimiento.id_acta', '=', 'act.id')

            ->where('inv_movimiento.estado', '=', 'A')
            ->where('act.origen', '=', $id_laboratorio)
            ->whereBetween('inv_movimiento.created_at', [$fInicio, $fFin]);

            if (!empty($fCategoriaArray) && $fCategoriaArray[0] != '') {
                $movimientos->whereIn('cat.id', $fCategoriaArray);
            }

            $movimientos = $movimientos
            ->orderBy('inv_movimiento.created_at', 'asc')
            ->get();

        $pdf = \PDF::loadView('pdf.pdf_kardex_general', ['fInicio' => $fInicio, 'fFin' => $fFin, 'results' => $results, 'movimientos' => $movimientos ])->setPaper('a4', 'landscape');
        return $pdf->download('pdfreactivos_invent.pdf');

    }
    /* GENERAR PDF REPORTE DE MOVIMIENTO DE INVENTARIO GENERAL */


    
    /* GENERAR PDF REPORTE DE MOVIMIENTO DE INVENTARIO GENERAL */
    public function reportInventarioGeneral(Request $request)
    {
        $id_laboratorio = $request->query('id_laboratorio');

        $fFin    = $request->query('fFin');
        $fInicio = $request->query('fInicio');

        $fCategoria   = $request->query('fCategoria');

        $fCategoriaArray = explode(',', $fCategoria);

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        $movimientos = Movimiento::select('usu.name as usuario', 'art.nombre as reactivo', 'inv_movimiento.unidades',
            'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura', 'lot.nombre as nom_lote', 'inv_movimiento.precio',
            'inv_movimiento.precio_total', 'inv_movimiento.saldo_ini', 'inv_movimiento.saldo_fin', 'act.tipo',
            DB::raw("DATE_FORMAT(inv_movimiento.created_at, '%Y-%m-%d') as fecha"), 'act.transaccion',
            DB::raw("
            CASE
                WHEN act.tipo = 'I' THEN 'Ingreso'
                WHEN act.tipo = 'E' THEN 'Egreso'
                WHEN act.tipo = 'C' THEN 'Compra local'
                WHEN act.tipo = 'D' THEN 'Donación'
                WHEN act.tipo = 'A' THEN 'Ajuste'
                WHEN act.tipo = 'T' THEN 'Transferencia'
                ELSE act.tipo
            END as tipo_movimiento
            "))
            ->join('db_inspi_inventario.inv_lote as lot', 'inv_movimiento.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('bdcoreinspi.users as usu', 'inv_movimiento.id_usuario', '=', 'usu.id')
            ->join('db_inspi_inventario.inv_categoria as cat', 'art.id_categoria', '=', 'cat.id')

            ->join('db_inspi_inventario.inv_unidad as uni', 'inv_movimiento.uni_medida', '=', 'uni.id')
            ->join('db_inspi_inventario.inv_acta as act', 'inv_movimiento.id_acta', '=', 'act.id')

            ->where('inv_movimiento.estado', '=', 'A')
            //->where('inv_movimiento.id', '=', $id_articulo)
            ->whereBetween('inv_movimiento.created_at', [$fInicio, $fFin]);

            if (!empty($fCategoriaArray) && $fCategoriaArray[0] != '') {
                $movimientos->whereIn('cat.id', $fCategoriaArray);
            }

            $movimientos = $movimientos
            ->orderBy('inv_movimiento.created_at', 'asc')
            ->get();

        $pdf = \PDF::loadView('pdf.kardex_inv_general', ['fInicio' => $fInicio, 'fFin' => $fFin, 'results' => $results, 'movimientos' => $movimientos ])->setPaper('a4', 'landscape');
        return $pdf->download('pdfreactivos_invent.pdf');

    }
    /* GENERAR PDF REPORTE DE MOVIMIENTO DE INVENTARIO GENERAL */





    /* GENERAR PDF REPORTE DE INVENTARIO - STOCK */
    public function reportInventarioStock(Request $request)
    {
        $id_laboratorio = $request->query('id_laboratorio');

        $rFiltro   = $request->query('rFiltro');

        if($rFiltro == 'todos'){

            $reportes = Inventario::select('art.nombre as art_nombre', 'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura',
                'lot.nombre as lot_nombre', 'lot.f_elabora as f_elabora', 'lot.f_caduca as f_caduca',
                'inv_inventario.cantidad as cantidad', 'inv_inventario.cant_minima as cant_minima',
                'art.id as codigo')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'inv_inventario.id_unidad', '=', 'uni.id')
                ->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->get();

        }else if($rFiltro == 'sin'){

            $reportes = Inventario::select('art.nombre as art_nombre', 'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura',
                'lot.nombre as lot_nombre', 'lot.f_elabora as f_elabora', 'lot.f_caduca as f_caduca',
                'inv_inventario.cantidad as cantidad', 'inv_inventario.cant_minima as cant_minima',
                'art.id as codigo')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'inv_inventario.id_unidad', '=', 'uni.id')
                ->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->where('inv_inventario.cantidad', '=', 0)
                ->get();

        }else if($rFiltro == 'dispo'){

            $reportes = Inventario::select('art.nombre as art_nombre', 'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura',
                'lot.nombre as lot_nombre', 'lot.f_elabora as f_elabora', 'lot.f_caduca as f_caduca',
                'inv_inventario.cantidad as cantidad', 'inv_inventario.cant_minima as cant_minima',
                'art.id as codigo')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'inv_inventario.id_unidad', '=', 'uni.id')
                ->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->where('inv_inventario.cantidad', '>', 0)
                ->get();

        }

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        $fecha = date("d-m-Y");
        $pdf = \PDF::loadView('pdf.pdf_inventario_stock', ['fecha' => $fecha, 'results' => $results, 'reportes' => $reportes ])->setPaper('a4', 'landscape');
        return $pdf->download('pdf_inventario_stock.pdf');

    }
    /* GENERAR PDF REPORTE DE INVENTARIO - STOCK */



    /* GENERAR PDF REPORTE DE INVENTARIO - STOCK */
    public function reportInventarioStockGeneral(Request $request)
    {
        $id_laboratorio = $request->query('id_laboratorio');

        $rFiltro   = $request->query('rFiltro');

        if($rFiltro == 'todos'){

            $reportes = Inventario::select('art.nombre as art_nombre', 'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura',
                'lot.nombre as lot_nombre', 'lot.f_elabora as f_elabora', 'lot.f_caduca as f_caduca',
                'inv_inventario.cantidad as cantidad', 'inv_inventario.cant_minima as cant_minima',
                'art.id as codigo', 'lab.descripcion as laboratorio')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'inv_inventario.id_unidad', '=', 'uni.id')
                ->join('inspi_crns.crns as lab', 'inv_inventario.id_laboratorio', '=', 'lab.id')
                //->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->get();

        }else if($rFiltro == 'sin'){

            $reportes = Inventario::select('art.nombre as art_nombre', 'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura',
                'lot.nombre as lot_nombre', 'lot.f_elabora as f_elabora', 'lot.f_caduca as f_caduca',
                'inv_inventario.cantidad as cantidad', 'inv_inventario.cant_minima as cant_minima',
                'art.id as codigo', 'lab.descripcion as laboratorio')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'inv_inventario.id_unidad', '=', 'uni.id')
                ->join('inspi_crns.crns as lab', 'inv_inventario.id_laboratorio', '=', 'lab.id')
                //->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->where('inv_inventario.cantidad', '=', 0)
                ->get();

        }else if($rFiltro == 'dispo'){

            $reportes = Inventario::select('art.nombre as art_nombre', 'uni.nombre as uni_nombre', 'uni.abreviatura as uni_abreviatura',
                'lot.nombre as lot_nombre', 'lot.f_elabora as f_elabora', 'lot.f_caduca as f_caduca',
                'inv_inventario.cantidad as cantidad', 'inv_inventario.cant_minima as cant_minima',
                'art.id as codigo', 'lab.descripcion as laboratorio')
                ->join('db_inspi_inventario.inv_lote as lot', 'inv_inventario.id_lote', '=', 'lot.id')
                ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
                ->join('db_inspi_inventario.inv_unidad as uni', 'inv_inventario.id_unidad', '=', 'uni.id')
                ->join('inspi_crns.crns as lab', 'inv_inventario.id_laboratorio', '=', 'lab.id')
                //->where('inv_inventario.id_laboratorio', $id_laboratorio)
                ->where('inv_inventario.cantidad', '>', 0)
                ->get();

        }

        $results = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $id_laboratorio)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        $fecha = date("d-m-Y");
        $pdf = \PDF::loadView('pdf.pdf_inventario_stock_general', ['fecha' => $fecha, 'results' => $results, 'reportes' => $reportes ])->setPaper('a4', 'landscape');
        return $pdf->download('pdf_inventario_stock.pdf');

    }
    /* GENERAR PDF REPORTE DE INVENTARIO - STOCK */



    /* VISTA CREAR AJUSTE */
    public function crearAjuste(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $usuarios = User::select('id', 'name')
            ->where('status', '=', 'A')
            ->get();

        $unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();

        //$laboratorios = Laboratorio::where('estado', 'A')->get();
        $laboratorios = Crn::where('estado', 'A')->get();

        //respuesta para la vista
        return view('inventarios.create_ajuste', compact('unidades', 'categorias', 'laboratorios', 'usuarios'));
    }
    /* VISTA CREAR AJUSTE */



    /* GUARDAR AJUSTE */
    public function saveAjuste(Request $request)
    {

        $id_usuario = Auth::user()->id;

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombre'      => 'required|string',
            'fecha'       => 'required|string',
            'tipo'        => 'required|string',
            'transaccion' => 'required|string',
            'destino'     => 'required|string',
            'descripcion' => 'required|string',
            'arraryData'  => 'required|array',
        ]);

        $counter = Contador::first();

        if (!$counter) {
            $counter = Contador::create([
                'no_ingreso'  => 0,
                'no_egreso'   => 0,
                'no_donacion' => 0,
                'no_traspaso' => 0,
                'no_ajuste'   => 0,
            ]);
        }

        $tipoMovimi = $request->tipo;
        $nameMovi = '';
        $numero   = '';
        if($tipoMovimi == 'A'){
            $nameMovi = 'Ajuste';
            $numero = 'N-ADJ-' . ($counter->no_ajuste + 1);
            $counter->increment('no_ajuste');
        }else{
            $nameMovi = 'Movimiento';
        }


        $acta = Acta::create([
            'nombre'      => $request->nombre,
            'proveedor'   => 'N/A',
            'fecha'       => $request->fecha,
            'tipo'        => $request->tipo,
            'origen'      => $request->destino,
            'transaccion' => $request->transaccion,
            'recibe'      => 'N/A',
            'id_laboratorio' => $request->destino,
            'no_ingreso'  => 'N/A',
            'numero'      => $numero,

            'descripcion' => $request->descripcion,
            'total'       => 0,
            'transferible' => 'true',
        ]);

        $actaId = $acta->id;

        $movimientos = $request->input('arraryData');

        foreach ($movimientos as $movimiento) {

            $precio = 0;
            $unidad = 0;
            //$uTotal = 0;

            $unidad        = $movimiento['unidad'];
            $id_inventario = $movimiento['id_inventario'];
            $uTotal        = $movimiento['uTotal'];
            $id_lote       = $movimiento['lote'];
            $id_articulo   = $movimiento['id_articulo'];

            //trae el id_lote
            $datoMovimiento = Movimiento::select('precio', 'uni_medida', 'id_lote')->where('id_lote', $id_lote)->first();

            $datoInven = Inventario::where('id', $id_inventario)->first();

            $precio = is_numeric($datoMovimiento->precio) ? (int)$datoMovimiento->precio : 0;
            $unidad = is_numeric($unidad) ? (int)$unidad : 0;

            /*
            if($request->transaccion == 'negativo'){
                $unidad = $unidad * -1;
            }
            */

            $costoTotal = $precio * $unidad;
            //$uniActual  = $uTotal - $unidad;

            // Calcular saldo inicial y final para el origen
            $saldo_ini = $datoInven ? $datoInven->cantidad : 0;
            // $saldo_fin = $saldo_ini - $uniActual;
            $saldo_fin = $saldo_ini + $unidad;


            $movimientoCreate = Movimiento::create([
                'id_usuario'   => $id_usuario,
                'id_lote'      => $id_lote,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'saldo_ini'    => $saldo_ini,
                'saldo_fin'    => $saldo_fin,
                'id_acta'      => $actaId,
            ]);

            //se crea o se actualiza el registro dependiendo de la transferencia
            //Inventario::actualizarInventario($id_lote, $unidad, $request->destino, $datoInven->id_unidad);


            // ================= se guarda un registro para ver el movimiento en articulos
            $datosArticulo = Lote::where('id', $datoMovimiento->id_lote)->first();
            $inventarioExistenteArt = Inventario::join('inv_lote as lote', 'inv_inventario.id_lote', '=', 'lote.id')
            ->where('lote.id_articulo', $datosArticulo->id_articulo)
            ->where('inv_inventario.id_laboratorio', $request->destino)
            ->where('inv_inventario.id_unidad', $datoInven->id_unidad)
            ->sum('inv_inventario.cantidad');

            //Determinar el saldo inicial
            $saldoInicialArt = $inventarioExistenteArt ? $inventarioExistenteArt : 0;

            //Calcular el saldo final
            $saldoFinalArt = $saldoInicialArt + $unidad;
            $movimientoArtCreate = MovimientoArticulo::create([
                'id_usuario'   => $id_usuario,
                'id_articulo'  => $id_articulo,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $datoMovimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'id_acta'      => $actaId,
                'saldo_ini'    => $saldoInicialArt,
                'saldo_fin'    => $saldoFinalArt,
            ]);
            // ================= 

        }

        if ($acta) {

            return response()->json(['message' => 'Movimiento de '.$nameMovi.' guardado exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear el '.$nameMovi, 'data' => false], 500);

        }

    }
    /* GUARDAR AJUSTE */





    /* TRAE LOS DATOS DEL MOVIMIENTO */
    public function get_tranferir(Request $request)
    {
        $id_acta = $request->query('id_acta');

        $datosActa = Acta::where('id', $id_acta)->first();

        $datosMovimiento = Movimiento::select('inv_movimiento.unidades as unidad', 'art.nombre as articulo', 'uni.nombre as presentacion',
            'lot.nombre as lote', 'inv_movimiento.precio as costo_unitario', 'inv_movimiento.precio_total as costo_total')
            ->join('db_inspi_inventario.inv_lote as lot', 'inv_movimiento.id_lote', '=', 'lot.id')
            ->join('db_inspi_inventario.inv_articulo as art', 'lot.id_articulo', '=', 'art.id')
            ->join('db_inspi_inventario.inv_unidad as uni', 'inv_movimiento.uni_medida', '=', 'uni.id')
            ->where('inv_movimiento.id_acta', $id_acta)
            ->get();

        if($datosActa){
            return response()->json(['message' => 'Datos traidos exitosamentre', 'data' => true, 'datosActa' => $datosActa, 'datosMovimiento' => $datosMovimiento], 200);

        }else{
            return response()->json(['message' => 'Error al traer los datos del movimiento', 'data' => false], 500);

        }

    }
    /* TRAE LOS DATOS DEL MOVIMIENTO */



    /* EFECTUA LA TRANSFERENCIA DIRECTA DE LOS LABORATORIOS */
    public function sendTransferencia(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_acta'        => 'required|string',
            'id_laboratorio' => 'required|string',
        ]);

        $id_acta = $request->id_acta;
        $id_laboratorio = $request->id_laboratorio;

        $id_usuario = Auth::user()->id;

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();


        $counter = Contador::first();

        if (!$counter) {
            $counter = Contador::create([
                'no_ingreso'  => 0,
                'no_egreso'   => 0,
                'no_donacion' => 0,
                'no_traspaso' => 0,
            ]);
        }

        $tipoMovimi = 'T';
        $nameMovi = '';
        $numero   = '';

        $nameMovi = 'Traspaso';
        $numero   = 'N-TRA-' . ($counter->no_traspaso + 1);
        $counter->increment('no_traspaso');

        $fecha = date("d/m/Y");

        //TRAEMOS LOS DATOS DEL ACTA
        $datosActa = Acta::where('id', $id_acta)->first();

        if ($datosActa) {
            // Actualizar el campo 'transferible'
            $datosActa->transferible = 'true';
            $datosActa->save();
        }

        $acta = Acta::create([
            'nombre'      => $datosActa->nombre,
            'proveedor'   => 'N/A',
            'fecha'       => $fecha,
            'tipo'        => $tipoMovimi,
            'origen'      => $labora->crns_id,

            'recibe'      => 'N/A',
            'id_laboratorio' => $id_laboratorio,
            'no_ingreso'  => 'N/A',
            'numero'      => $numero,

            'descripcion' => $datosActa->descripcion,
            'total'       => $datosActa->total,
        ]);

        $actaId = $acta->id;

        //TRAEMOS LOS DATOS DEL MOVIMIENTO
        $datosMovimiento = Movimiento::where('id_acta', $id_acta)->get();


        foreach ($datosMovimiento as $movimiento) {

            $precio = 0;
            $unidad = 0;

            $unidad    = $movimiento->unidades;
            $id_lote   = $movimiento->id_lote;
            $id_unidad = $movimiento->uni_medida;

            $datoInven = Inventario::where('id_lote', $id_lote)->where('id_unidad', $id_unidad)->first();

            $precio = is_numeric($movimiento->precio) ? (int)$movimiento->precio : 0;
            $unidad = is_numeric($unidad) ? (int)$unidad : 0;

            $uniActual = (int)$unidad * -1;

            $costoTotal = $precio * $unidad;
            $saldo_ini  = $datoInven->cantidad;
            $saldo_fin  = $datoInven->cantidad + $unidad;


            $movimientoCreate = Movimiento::create([
                'id_usuario'   => $id_usuario,
                'id_lote'      => $id_lote,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $movimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'id_acta'      => $actaId,
                'saldo_ini'    => $saldo_ini,
                'saldo_fin'    => $saldo_fin,
            ]);

            //se crea o se actualiza el registro dependiendo de la transferencia
            //Inventario::actualizarInventario($id_lote, $unidad, $id_laboratorio, $datoInven->id_unidad);

            //se actualiza el registro existente
            Inventario::actualizarInventario($id_lote, $uniActual, $labora->crns_id, $datoInven->id_unidad);

        }


                // ==================================================================
        //ahora se hace el mismo movimiento para que se vea la transferencia a otra area o laboratorio

        $numero   = '';
        $origen   = '';
        $total_acta = 0;

        $numero = 'N-INT-' . ($counter->no_ingreso + 1);
        $counter->increment('no_ingreso');

        $acta = Acta::create([
            'nombre'      => $datosActa->nombre,
            'proveedor'   => 'N/A',
            'fecha'       => $fecha,
            'tipo'        => 'C',
            'origen'      => $id_laboratorio,

            'recibe'      => 'N/A',
            'id_laboratorio' => $id_laboratorio,
            'no_ingreso'  => $numero,
            'numero'      => $numero,

            'descripcion' => 'Ingreso '. date('Y-m-d'),
            'total'       => $datosActa->total,
            'transferible' => 'true',
        ]);

        $actaId = $acta->id;

        foreach ($datosMovimiento as $movimiento) {

            $precio = 0;
            $unidad = 0;

            $unidad    = $movimiento->unidades;
            $id_lote   = $movimiento->id_lote;
            $id_unidad = $movimiento->uni_medida;

            $datoInven = Inventario::where('id_lote', $id_lote)->where('id_unidad', $id_unidad)->first();

            $precio = is_numeric($movimiento->precio) ? (int)$movimiento->precio : 0;
            $unidad = is_numeric($unidad) ? (int)$unidad : 0;

            $uniActual = (int)$unidad;

            $costoTotal = $precio * $unidad;
            $saldo_ini  = $datoInven->cantidad;
            $saldo_fin  = $datoInven->cantidad + $unidad;


            $movimientoCreate = Movimiento::create([
                'id_usuario'   => $id_usuario,
                'id_lote'      => $id_lote,
                'unidades'     => $unidad, //cantidad
                'uni_medida'   => $movimiento->uni_medida, //en unidadesd de medidas
                'precio'       => $precio,  //precio unitario
                'precio_total' => $costoTotal,  //precio total
                'id_acta'      => $actaId,
                'saldo_ini'    => $saldo_ini,
                'saldo_fin'    => $saldo_fin,
            ]);

            //se crea o se actualiza el registro dependiendo de la transferencia
            Inventario::actualizarInventario($id_lote, $unidad, $id_laboratorio, $datoInven->id_unidad);

            //se actualiza el registro existente
            //Inventario::actualizarInventario($id_lote, $uniActual, $labora->id, $datoInven->id_unidad);

        }

        // ==================================================================


        if ($acta) {

            return response()->json(['message' => 'Transferencia realizada con Éxito', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al realizar la transferencia', 'data' => false], 500);

        }

    }
    /* EFECTUA LA TRANSFERENCIA DIRECTA DE LOS LABORATORIOS */




    /* VISTA - LISTA TODOS LOS AJUSTES EXISTENTES PARA HABILITARLOS  */
    public function list_ajuste(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $unidades   = Unidad::where('estado', 'A')->get();
        //$unidades   = Unidad::where('estado', 'A')->get();
        $categorias = Categoria::where('estado', 'A')->get();
        $laboratorios = Crn::where('estado', 'A')->get();

        if(request()->ajax()) {

            return datatables()->of($acta = Acta::select('id as id', 'nombre as nombre', 'estado as estado', 'fecha as fechaI', 'proveedor as proveedor',
                                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as fecha'), 'tipo as tipo', 'origen as origen', 'total as total',
                                    'transferible as transferible', 'numero')
                                    ->whereIn('estado', ['A','V','R'])->where('tipo', 'A'))
                ->addIndexColumn()
                ->make(true);

        }

        //respuesta para la vista
        return view('inventarios.list_ajuste', compact('unidades', 'categorias', 'laboratorios'));
    }
    /* VISTA - LISTA TODOS LOS AJUSTES EXISTENTES PARA HABILITARLOS  */




    /* VALIDA O RECHAZA EL AJUSTE */
    public function validaAjuste(Request $request)
    {
        $id_acta = $request->query('id_acta');
        $valida = $request->query('valida');

        if($valida == 'SI'){

            $datosActa = Acta::where('id', $id_acta)->first();
            $movimientos = Movimiento::where('id_acta', $id_acta)->get();

            $destino = $datosActa->id_laboratorio;

            foreach ($movimientos as $movimiento) {

                $precio = 0;
                $unidad = 0;

                $id_movimiento = $movimiento->id;
                $unidad    = $movimiento->unidades;
                $id_lote   = $movimiento->id_lote;
                $id_unidad = $movimiento->uni_medida;

                $datoInven = Inventario::where('id_lote', $id_lote)->where('id_unidad', $id_unidad)->first();

                $precio = is_numeric($movimiento->precio) ? (int)$movimiento->precio : 0;
                $unidad = is_numeric($unidad) ? (int)$unidad : 0;

                if($datosActa->transaccion == 'negativo'){
                    $unidad = $unidad * -1;
                }

                $costoTotal = $precio * $unidad;

                $saldo_ini = $datoInven ? $datoInven->cantidad : 0;
                $saldo_fin = $saldo_ini - $unidad;

                $movimientoUpdate = Movimiento::find($id_movimiento);
                if ($movimientoUpdate) {
                    $movimientoUpdate->update([
                        'saldo_ini'    => $saldo_ini,
                        'saldo_fin'    => $saldo_fin,
                    ]);
                }

                //se crea o se actualiza el registro dependiendo de la transferencia
                Inventario::actualizarInventario($id_lote, $unidad, $destino, $datoInven->id_unidad);

            }

            if ($datosActa) {
                $datosActa->update([
                    'estado'    => 'V',
                ]);
            }

        }else{

            $actaUpdate = Acta::find($id_acta);
            if ($actaUpdate) {
                $actaUpdate->update([
                    'estado'    => 'R',
                ]);
            }

        }

        if ($id_acta) {

            return response()->json(['message' => 'Ajuste realizado con Éxito', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al realizar el Ajuste', 'data' => false], 500);

        }

    }
    /* VALIDA O RECHAZA EL AJUSTE */





    /* GENERAR PDF DE CORRIDA */
    public function pdf_corrida( Request $request )
    {

        $id_corrida = $request->query('id_corrida');

        $id_usuario = Auth::user()->id;

        /*
        $labora = DB::table('users as usu')
            ->join('inspi_area as are', 'are.id', '=', 'usu.id_area')
            ->join('inspi_laboratorio as lab', 'lab.area_id', '=', 'are.id')
            ->select('lab.id', 'lab.nombre')
            ->where('usu.id', '=', $id_usuario)
            ->first();
        */

        $labora = DB::table('inspi_crns.responsables as lab')
            ->select('lab.crns_id as id')
            ->where('lab.usuario_id', '=', $id_usuario)
            ->first();

        $datosLaboratorio = DB::table('inspi_crns.crns as lab')
            ->join('inspi_crns.sedes_crns as scs', 'lab.id', '=', 'scs.crns_id')
            ->join('inspi_crns.sedes as zonal', 'scs.sedes_id', '=', 'zonal.id')
            ->where('lab.id', $labora->id)
            ->select('lab.descripcion as nombre_laboratorio', 'zonal.descripcion as nombre_zonal')
            ->first();

        /*
        $datosLaboratorio = DB::table('inspi_laboratorio as lab')
        ->join('inspi_area as area', 'lab.area_id', '=', 'area.id')
        ->join('inspi_czonal as zonal', 'area.czonal_id', '=', 'zonal.id')
        ->where('lab.id', $labora->id)
        ->select('lab.nombre as nombre_laboratorio', 'zonal.nombre as nombre_zonal')
        ->first();
        */

        $corrida = Corrida::select('cor_corrida.id', 'cor_corrida.extraccion_equi', 'cor_corrida.equipos', 'cor_corrida.numero', 
            'cor_corrida.tecnica', 'cor_corrida.servicio', 'cor_corrida.hora', 'cor_corrida.fecha', 'cor_corrida.vigilacia_tipo', 
            'cor_corrida.observacion', 'use.name')
            ->join('bdcoreinspi.users as use', 'use.id', '=', 'cor_corrida.id_analista')
            ->where('cor_corrida.estado', 'A')->where('cor_corrida.id', $id_corrida)->first();

        /*
        $acta = Acta::select('inv_acta.nombre', 'inv_acta.fecha', 'inv_acta.tipo', 'inv_acta.origen'
        ,'inv_acta.numero', 'inv_acta.descripcion', 'lab.nombre as laboratorio')
        ->join('db_inspi.inspi_laboratorio as lab', 'lab.id', '=', 'inv_acta.id_laboratorio')
        // ->join('db_inspi.users as usu', 'usu.id', '=', 'inv_acta.recibe')
        ->where('inv_acta.id', $id_acta)
        ->first();
        */
        
        $movimientos = MovimientoCor::select('art.nombre', 'cor_movimiento.cantidad as pruebas', 'uni.nombre as uniNombre', 'lot.nombre as lote',
        'cor_movimiento.valor as cantidad', 'cor_movimiento.valor as total', 'cor_movimiento.prueba as nombre_prueba', 
        'uni.abreviatura as abreviatura')
        ->join('db_inspi_inventario.inv_lote as lot', 'lot.id', '=', 'cor_movimiento.id_lote')
        ->join('db_inspi_inventario.inv_articulo as art', 'art.id', '=', 'lot.id_articulo')
        ->join('db_inspi_inventario.inv_inventario as inv', 'inv.id', '=', 'cor_movimiento.id_movimiento_inv')
        ->join('db_inspi_inventario.inv_unidad as uni', 'uni.id', '=', 'inv.id_unidad')
        ->where('cor_movimiento.id_corrida', $id_corrida)
        ->get();
        

        //$datosActa = $corrida->toArray();

        $pdf = \PDF::loadView('pdf.reporte_laboratorios.corrida_egreso', 
            ['corrida' => $corrida, 
            'datosLaboratorio' => $datosLaboratorio,
            'movimientos' => $movimientos]);

        //$pdf = \Barryvdh\DomPDF\Facade::loadView('pdf.ejemplo');

        return $pdf->download('reporte_corrida.pdf');
    }
    /* GENERAR PDF DE CORRIDA */




}
