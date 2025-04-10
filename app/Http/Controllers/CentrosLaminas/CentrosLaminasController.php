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

//datos de la laminas
use App\Models\CentrosReferencia\Provincia;
use App\Models\CentrosReferencia\Canton;
use App\Models\CentrosReferencia\Tecnica;
use App\Models\CentrosReferencia\Evento;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Responsable;


use App\Models\Lamina\Lamina\Lamina;
use App\Models\Lamina\Tincion\Tincion;
use App\Models\Lamina\Apariencia\Apariencia;
use App\Models\Lamina\Desglose\Desglose;
use App\Models\Lamina\Frotis\Frotis;
use App\Models\Lamina\Resultado\Resultado;


//use App\Models\Area\Area;
use App\Models\CoreBase\Area;

use App\Traits\GetDireccionTrait;

class CentrosLaminasController extends Controller
{

    use GetDireccionTrait;

    public function index(Request $request){

        $estado = $request->input('estado');

        if (request()->ajax()) {
            $query = Lamina::select(
                'ingreso_laminas.id as id',
                'ingreso_laminas.mes_recepcion as mes_recepcion',
                'ingreso_laminas.fecha_recep as fecha_recep',
                'ingreso_laminas.total_laminas as total_laminas',
                'ins.descripcion as instituto',
                'recep.name as recepta',
                'anali.name as analita',
                'ins.unicodigo as unicodigo',
                DB::raw('EXISTS (
                    SELECT 1 FROM desglose_lamina 
                    WHERE desglose_lamina.id_lamina = ingreso_laminas.id 
                      AND desglose_lamina.estado = \'A\'
                ) as tiene_desglose')
            )
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
            ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
            ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
            ->where('ingreso_laminas.estado', 'A'); 
        
            return datatables()->of($query)->addIndexColumn()->make(true);
        }

        //respuesta para la vista
        return view('lamina.index');

    }


    public function crear()
    {
        // Obtener todos los registros de los modelos
        $tecnicas = Tecnica::all();
        $eventos = Evento::all();
        $instituciones = Institucion::select('instituciones_salud.id as id', 'instituciones_salud.descripcion as nombre', 'can.descripcion as canton')
        ->join('inspi_crns.cantones as can', 'can.id', '=', 'instituciones_salud.canton_id')->get();

        $responsables = Responsable::where('crns_id', 1)
            ->with('usuario')
            ->get();

        
        //dd($responsables);
    
        // Enviar datos a la vista
        return view('lamina.crear', compact('tecnicas', 'eventos', 'instituciones', 'responsables'));
    }


    public function guardar(Request $request)
    {

        $fecha_recep   = $request->input('fecha_recep'); 
        $centro_salud  = $request->input('centro_salud'); 
        $responsable   = $request->input('responsable'); 
        $analista      = $request->input('analista'); 
        $mes_recepcion = $request->input('mes_recepcion'); 
        $observaciones = $request->input('observaciones'); 
        $total_laminas = $request->input('total_laminas'); 

        $director_us   = $request->input('director_us'); 
        $total_laminas_super = $request->input('total_laminas_super'); 

        $laminas_empacadas       = filter_var($request->input('laminas_empacadas'), FILTER_VALIDATE_BOOLEAN);
        $laminas_legibles        = filter_var($request->input('laminas_legibles'), FILTER_VALIDATE_BOOLEAN);
        $laminas_sin_id          = filter_var($request->input('laminas_sin_id'), FILTER_VALIDATE_BOOLEAN);
        $laminas_sin_aceite      = filter_var($request->input('laminas_sin_aceite'), FILTER_VALIDATE_BOOLEAN);
        $laminas_frotis_adecuado = filter_var($request->input('laminas_frotis_adecuado'), FILTER_VALIDATE_BOOLEAN);
        $laminas_integras        = filter_var($request->input('laminas_integras'), FILTER_VALIDATE_BOOLEAN);
        $laminas_documentacion   = filter_var($request->input('laminas_documentacion'), FILTER_VALIDATE_BOOLEAN);
        

        $anio = $fecha_recep ? date('Y', strtotime($fecha_recep)) : null;
        
        // Guardar en la base de datos
        $ingreso = new Lamina();
        $ingreso->fecha_recep     = $fecha_recep;
        $ingreso->id_unidad_salud = $centro_salud;
        $ingreso->id_responsable  = $responsable;
        $ingreso->id_analista     = $analista;
        $ingreso->mes_recepcion   = $mes_recepcion;
        $ingreso->observaciones   = $observaciones;
        $ingreso->anio            = $anio;
        $ingreso->total_laminas   = $total_laminas;
        $ingreso->director_us     = $director_us;
        $ingreso->total_laminas_recib = $total_laminas_super;

        $ingreso->id_evento       = 9;
        $ingreso->id_tecnica      = 9;

        // Asignación de valores booleanos
        $ingreso->laminas_empacadas      = $laminas_empacadas;
        $ingreso->laminas_legibles       = $laminas_legibles;
        $ingreso->laminas_sin_id         = $laminas_sin_id;
        $ingreso->laminas_sin_aceite     = $laminas_sin_aceite;
        $ingreso->laminas_frotis_adecuado= $laminas_frotis_adecuado;
        $ingreso->laminas_integras       = $laminas_integras;
        $ingreso->laminas_documentacion  = $laminas_documentacion;

        $ingreso->save();

        if ($ingreso) {

            return response()->json(['message' => 'Se ingresaron las Láminas correctamente.', 'success' => true], 200);

        } else {

            return response()->json(['message' => 'Error al ingresar las láminas', 'success' => false], 500);

        }


    }


    public function editar($id_ingreso){

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
            'anali.name as analita', 'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones',
            'anali.id as id_analita', 'recep.id as id_recepta', 'ingreso_laminas.director_us', 'ingreso_laminas.total_laminas_recib',
            'ins.id as id_unidad',
            'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
            'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
            'ingreso_laminas.laminas_documentacion'
        )
        ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
        ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        $tecnicas = Tecnica::all();
        $eventos  = Evento::all();
        $instituciones = Institucion::select('instituciones_salud.id as id', 'instituciones_salud.descripcion as nombre', 'can.descripcion as canton')
            ->join('inspi_crns.cantones as can', 'can.id', '=', 'instituciones_salud.canton_id')->get();
        $responsables = Responsable::where('crns_id', 1)->with('usuario')->get();

        //dd($responsables);

        $tipos_laminas = Lamina::all();
        $tipos_tincion = Tincion::all();
        $tipos_apariencia = Apariencia::all();

        return view('lamina.editar', compact('datos', 'tipos_laminas', 'tipos_tincion', 'tipos_apariencia', 'tecnicas', 'eventos', 'instituciones', 'responsables'));

    }



    public function guardar_edicion(Request $request)
    {

        $id_ingreso    = $request->input('id_ingreso'); 
        $fecha_recep   = $request->input('fecha_recep'); 
        $centro_salud  = $request->input('centro_salud'); 
        $responsable   = $request->input('responsable'); 
        $analista      = $request->input('analista'); 
        $mes_recepcion = $request->input('mes_recepcion'); 
        $observaciones = $request->input('observaciones'); 
        $total_laminas = $request->input('total_laminas'); 

        $director_us   = $request->input('director_us'); 
        $total_laminas_super = $request->input('total_laminas_super'); 

        $laminas_empacadas       = filter_var($request->input('laminas_empacadas'), FILTER_VALIDATE_BOOLEAN);
        $laminas_legibles        = filter_var($request->input('laminas_legibles'), FILTER_VALIDATE_BOOLEAN);
        $laminas_sin_id          = filter_var($request->input('laminas_sin_id'), FILTER_VALIDATE_BOOLEAN);
        $laminas_sin_aceite      = filter_var($request->input('laminas_sin_aceite'), FILTER_VALIDATE_BOOLEAN);
        $laminas_frotis_adecuado = filter_var($request->input('laminas_frotis_adecuado'), FILTER_VALIDATE_BOOLEAN);
        $laminas_integras        = filter_var($request->input('laminas_integras'), FILTER_VALIDATE_BOOLEAN);
        $laminas_documentacion   = filter_var($request->input('laminas_documentacion'), FILTER_VALIDATE_BOOLEAN);
        

        $anio = $fecha_recep ? date('Y', strtotime($fecha_recep)) : null;
        
        // Guardar en la base de datos
        $ingreso = Lamina::find($id_ingreso);
        $ingreso->fecha_recep     = $fecha_recep;
        $ingreso->id_unidad_salud = $centro_salud;
        $ingreso->id_responsable  = $responsable;
        $ingreso->id_analista     = $analista;
        $ingreso->mes_recepcion   = $mes_recepcion;
        $ingreso->observaciones   = $observaciones;
        $ingreso->anio            = $anio;
        $ingreso->total_laminas   = $total_laminas;
        $ingreso->director_us     = $director_us;
        $ingreso->total_laminas_recib = $total_laminas_super;

        $ingreso->id_evento       = 9;
        $ingreso->id_tecnica      = 9;

        // Asignación de valores booleanos
        $ingreso->laminas_empacadas      = $laminas_empacadas;
        $ingreso->laminas_legibles       = $laminas_legibles;
        $ingreso->laminas_sin_id         = $laminas_sin_id;
        $ingreso->laminas_sin_aceite     = $laminas_sin_aceite;
        $ingreso->laminas_frotis_adecuado= $laminas_frotis_adecuado;
        $ingreso->laminas_integras       = $laminas_integras;
        $ingreso->laminas_documentacion  = $laminas_documentacion;

        $ingreso->save();

        if ($ingreso) {

            return response()->json(['message' => 'Se edito el ingreso de las Láminas correctamente.', 'success' => true], 200);

        } else {

            return response()->json(['message' => 'Error al editar el ingreso de las láminas', 'success' => false], 500);

        }


    }


    public function eliminar(Request $request)
    {

        $id_ingreso    = $request->input('id'); 

        $ingreso = Lamina::find($id_ingreso);
        $ingreso->estado     = 'E';

        $ingreso->save();

        if ($ingreso) {

            return response()->json(['message' => 'Se elimino el ingreso de las Láminas correctamente.', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el ingreso de las láminas', 'data' => false], 500);

        }

    }
  

    public function agregar_laminas($id_ingreso){

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
            'anali.name as analita', 'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones',
            'ingreso_laminas.director_us', 'ingreso_laminas.total_laminas_recib',
            'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
            'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
            'ingreso_laminas.laminas_documentacion'
        )
        ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
        ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        $tipos_laminas = Lamina::all();
        $tipos_tincion = Tincion::all();
        $tipos_apariencia = Apariencia::all();

        return view('lamina.agregar_laminas', compact('datos', 'tipos_laminas', 'tipos_tincion', 'tipos_apariencia'));

    }



    public function editar_laminas($id_ingreso){

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
            'anali.name as analita', 'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones',
            'ingreso_laminas.director_us', 'ingreso_laminas.total_laminas_recib',
            'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
            'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
            'ingreso_laminas.laminas_documentacion'
        )
        ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
        ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        $datos_desglose = Desglose::select('*')->where('id_lamina', $id_ingreso)->where('estado', 'A')->get();

        $tipos_frotis = Frotis::all();
        $tipos_tincion = Tincion::all();
        $tipos_apariencia = Apariencia::all();

        return view('lamina.editar_laminas', compact('datos', 'tipos_frotis', 'tipos_tincion', 'tipos_apariencia', 'datos_desglose'));

    }


    public function guardar_laminas(Request $request){

        $datos = $request->input('datos');
        $id_ingreso = $request->input('id_ingreso');
        
        foreach ($datos as $dato) {
            Desglose::create([
                'nro_lamina' => $dato['num_lamina'],
                'lectura' => $dato['lectura'],
                'id_apariencia' => $dato['apariencia'],
                'id_frotis' => $dato['frotis'], 
                'id_tincion' => $dato['tincion'],
                'id_lamina' => $id_ingreso,  
            ]);
        }
        // Retornar una respuesta de éxito
        return response()->json(['success' => true, 'message' => 'Desglose guardados correctamente'], 200);
    }


    public function guardar_laminas_editadas(Request $request){

        $datos = $request->input('datos');
        $id_ingreso = $request->input('id_ingreso');
        
        foreach ($datos as $dato) {
            $desglose = Desglose::find($dato['idLamina']);
            if ($desglose) {
                $desglose->update([
                    'nro_lamina'   => $dato['num_lamina'],
                    'lectura'      => $dato['lectura'],
                    'id_apariencia'=> $dato['apariencia'],
                    'id_frotis'    => $dato['frotis'], 
                    'id_tincion'   => $dato['tincion'],
                    'id_lamina'    => $id_ingreso,  
                ]);
            }
        }
        
        // Retornar una respuesta de éxito
        return response()->json(['success' => true, 'message' => 'Desglose guardados correctamente'], 200);
    }


    public function eliminar_desglose(Request $request)
    {
        $id_ingreso = $request->input('id'); 
    
        $desgloses = Desglose::where('id_lamina', $id_ingreso)->get();
    
        if ($desgloses->count() > 0) {
            foreach ($desgloses as $des) {
                $des->estado = 'E';
                $des->save();
            }
    
            return response()->json([
                'message' => 'Se eliminó los desgloses de las Láminas correctamente.',
                'data' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se encontraron desgloses para eliminar.',
                'data' => false
            ], 404);
        }
    }


    public function control_calidad($id_ingreso){

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
            'anali.name as analita', 'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones',

            'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
            'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
            'ingreso_laminas.laminas_documentacion'
        )
        ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
        ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        $tipos_laminas = Lamina::all();
        $tipos_tincion = Tincion::all();
        $tipos_apariencia = Apariencia::all();



        // Obtener el total de registros
        $total_registros = Desglose::where('id_lamina', $id_ingreso)->count();

        // Obtener el conteo de cada tipo de frotis
        $conteos_frotis = Desglose::where('id_lamina', $id_ingreso)
            ->selectRaw('id_frotis, COUNT(*) as total')
            ->groupBy('id_frotis')
            ->pluck('total', 'id_frotis');

        // Obtener el conteo de cada tipo de tinción
        $conteos_tincion = Desglose::where('id_lamina', $id_ingreso)
            ->selectRaw('id_tincion, COUNT(*) as total')
            ->groupBy('id_tincion')
            ->pluck('total', 'id_tincion');

        // Obtener el conteo de cada tipo de apariencia
        $conteos_apariencia = Desglose::where('id_lamina', $id_ingreso)
            ->selectRaw('id_apariencia, COUNT(*) as total')
            ->groupBy('id_apariencia')
            ->pluck('total', 'id_apariencia');

        // Obtener los nombres de frotis, tinción y apariencia desde la base de datos
        $tipos_frotis = Frotis::pluck('nombre', 'id');
        $tipos_tincion = Tincion::pluck('nombre', 'id');
        $tipos_apariencia = Apariencia::pluck('nombre', 'id');

        // Función para calcular el porcentaje
        $porcentaje = fn($cantidad) => $total_registros > 0 ? ($cantidad / $total_registros) * 100 : 0;

        // Función para calcular la calificación
        $calificacion = function ($porcentaje) {
            return $porcentaje >= 75 ? 'Bueno' :
                ($porcentaje >= 64 ? 'Regular' : 'Deficiente');
        };

        // Construir el arreglo con los datos de frotis
        $datos_frotis = [];
        foreach ($tipos_frotis as $id_frotis => $nombre) {
            $cantidad = $conteos_frotis[$id_frotis] ?? 0;
            $porc = $porcentaje($cantidad);
            $datos_frotis[] = [
                'nombre'        => $nombre,
                'cantidad'      => $cantidad,
                'porcentaje'    => $porc,
                'calificacion'  => $calificacion($porc)
            ];
        }

        // Construir el arreglo con los datos de tinción
        $datos_tincion = [];
        foreach ($tipos_tincion as $id_tincion => $nombre) {
            $cantidad = $conteos_tincion[$id_tincion] ?? 0;
            $porc = $porcentaje($cantidad);
            $datos_tincion[] = [
                'nombre'        => $nombre,
                'cantidad'      => $cantidad,
                'porcentaje'    => $porc,
                'calificacion'  => $calificacion($porc)
            ];
        }

        // Construir el arreglo con los datos de apariencia (SIN calificación)
        $datos_apariencia = [];
        foreach ($tipos_apariencia as $id_apariencia => $nombre) {
            $cantidad = $conteos_apariencia[$id_apariencia] ?? 0;
            $porc = $porcentaje($cantidad);
            $datos_apariencia[] = [
                'nombre'        => $nombre,
                'cantidad'      => $cantidad,
                'porcentaje'    => $porc
            ];
        }

        return view('lamina.control_calidad', compact(
            'datos', 
            'tipos_laminas', 
            'tipos_tincion', 
            'tipos_apariencia',
            'datos_frotis', // Datos de Frotis
            'datos_tincion', // Datos de Tinción
            'datos_apariencia' // Datos de Apariencia (SIN calificación)
        ));

    }

    
    public function resultados_laminas(Request $request){

        $totalLaminas  = $request->input('totalLaminas');
        $totalPos      = $request->input('totalPos');
        $totalNeg      = $request->input('totalNeg');
        $porcentajePos = $request->input('porcentajePos');
        $porcentajeNeg = $request->input('porcentajeNeg');
        $calificacion  = $request->input('calificacion');
        $recomendacion = $request->input('recomendacion');
        $id_ingreso    = $request->input('id_ingreso');
    
        // Obtener el lamina para obtener el evento, tecnica, unidad de salud, etc.
        $lamina = Lamina::find($id_ingreso);
    
        // Función para calcular la calificación de un porcentaje
        $calificacionPos = function ($porcentajePos) {
            return ($porcentajePos >= 99) ? 'Bueno' :
                   (($porcentajePos >= 95) ? 'Regular' : 'Deficiente');
        };
    
        $calificacionNeg = function ($porcentajeNeg) {
            return ($porcentajeNeg >= 99) ? 'Bueno' :
                   (($porcentajeNeg >= 95) ? 'Regular' : 'Deficiente');
        };
        
        // Crear el resultado para las láminas positivas
        Resultado::create([
            'id_evento'            => $lamina->id_evento,
            'id_tecnica'           => $lamina->id_tecnica,
            'tecnica_lamina'       => 'Láminas Positivas Discordantes',
            'id_unidad_salud'      => $lamina->id_unidad_salud,
            'nro_laminas'          => $totalPos, 
            'porcentaje_laminas'   => $porcentajePos,
            'porcentaje_acumulado' => $porcentajePos,  
            'interpretacion'       => $calificacionPos($porcentajePos), // Llamar a la función
            'id_lamina'            => $id_ingreso
        ]);
    
        // Crear el resultado para las láminas negativas
        Resultado::create([
            'id_evento'            => $lamina->id_evento,
            'id_tecnica'           => $lamina->id_tecnica,
            'tecnica_lamina'       => 'Láminas Negativas Discordantes',
            'id_unidad_salud'      => $lamina->id_unidad_salud,
            'nro_laminas'          => $totalNeg, 
            'porcentaje_laminas'   => $porcentajeNeg,
            'porcentaje_acumulado' => $porcentajeNeg,  
            'interpretacion'       => $calificacionNeg($porcentajeNeg), // Llamar a la función
            'id_lamina'            => $id_ingreso
        ]);
    
        // Retornar una respuesta de éxito
        return response()->json(['success' => true, 'message' => 'Resultados guardados correctamente'], 200);
    
    }

    public function reporteResultadosCompleto(Request $request)
    {

        $resultados = Resultado::select('tec.descripcion as nom_tecnica', 'ins.descripcion as nom_instituto', 'resultado_laminas.tecnica_lamina',
            'resultado_laminas.nro_laminas', 'resultado_laminas.porcentaje_laminas', 'resultado_laminas.porcentaje_acumulado', 'resultado_laminas.interpretacion')
        ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'resultado_laminas.id_tecnica')
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'resultado_laminas.id_unidad_salud')
        ->where('resultado_laminas.estado', 'A')->get();

        return \PDF::loadView('pdf.reporte_laminas.resultados_completo', [
            'resultados' => $resultados,
        ])
        ->setPaper('A4', 'landscape')
        ->download('reporte_laminas.pdf');
    }


    public function reporte_control_calidad(Request $request)
    {

        $id_lamina  = $request->query('id_lamina');

        $datos = Lamina::select(
                'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
                'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
                'anali.name as analita', 'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones',

                'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
                'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
                'ingreso_laminas.laminas_documentacion', 'can.descripcion as procedencia', 'ingreso_laminas.total_laminas_recib',
                'ingreso_laminas.director_us'
            )
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
            ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
            ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
            ->join('inspi_crns.cantones as can', 'can.id', '=', 'ins.canton_id')
            ->where('ingreso_laminas.estado', ['A'])
            ->where('ingreso_laminas.id', $id_lamina)->first();

        $resultados = Resultado::select('tec.descripcion as nom_tecnica', 'ins.descripcion as nom_instituto', 'resultado_laminas.tecnica_lamina',
            'resultado_laminas.nro_laminas', 'resultado_laminas.porcentaje_laminas', 'resultado_laminas.porcentaje_acumulado', 'resultado_laminas.interpretacion')
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'resultado_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'resultado_laminas.id_unidad_salud')
            ->where('resultado_laminas.estado', 'A')
            ->where('resultado_laminas.id_lamina', $id_lamina)->take(2)->get();

        //dd($resultados);
        // Obtener el total de registros
        $total_registros = Desglose::where('id_lamina', $id_lamina)->count();

        // Obtener el conteo de cada tipo de frotis
        $conteos_frotis = Desglose::where('id_lamina', $id_lamina)
            ->selectRaw('id_frotis, COUNT(*) as total')
            ->groupBy('id_frotis')
            ->pluck('total', 'id_frotis');

        // Obtener el conteo de cada tipo de tinción
        $conteos_tincion = Desglose::where('id_lamina', $id_lamina)
            ->selectRaw('id_tincion, COUNT(*) as total')
            ->groupBy('id_tincion')
            ->pluck('total', 'id_tincion');

        // Obtener el conteo de cada tipo de apariencia
        $conteos_apariencia = Desglose::where('id_lamina', $id_lamina)
            ->selectRaw('id_apariencia, COUNT(*) as total')
            ->groupBy('id_apariencia')
            ->pluck('total', 'id_apariencia');

        // Obtener los nombres de frotis, tinción y apariencia desde la base de datos
        $tipos_frotis = Frotis::pluck('nombre', 'id');
        $tipos_tincion = Tincion::pluck('nombre', 'id');
        $tipos_apariencia = Apariencia::pluck('nombre', 'id');

        // Función para calcular el porcentaje
        $porcentaje = fn($cantidad) => $total_registros > 0 ? ($cantidad / $total_registros) * 100 : 0;

        // Función para calcular la calificación
        $calificacion = function ($porcentaje) {
            return $porcentaje >= 75 ? 'Bueno' :
                ($porcentaje >= 64 ? 'Regular' : 'Deficiente');
        };

        // Construir el arreglo con los datos de frotis
        $datos_frotis = [];
        foreach ($tipos_frotis as $id_frotis => $nombre) {
            $cantidad = $conteos_frotis[$id_frotis] ?? 0;
            $porc = $porcentaje($cantidad);
            $datos_frotis[] = [
                'nombre'        => $nombre,
                'cantidad'      => $cantidad,
                'porcentaje'    => $porc,
                'calificacion'  => $calificacion($porc)
            ];
        }

        // Construir el arreglo con los datos de tinción
        $datos_tincion = [];
        foreach ($tipos_tincion as $id_tincion => $nombre) {
            $cantidad = $conteos_tincion[$id_tincion] ?? 0;
            $porc = $porcentaje($cantidad);
            $datos_tincion[] = [
                'nombre'        => $nombre,
                'cantidad'      => $cantidad,
                'porcentaje'    => $porc,
                'calificacion'  => $calificacion($porc)
            ];
        }

        // Construir el arreglo con los datos de apariencia (SIN calificación)
        $datos_apariencia = [];
        foreach ($tipos_apariencia as $id_apariencia => $nombre) {
            $cantidad = $conteos_apariencia[$id_apariencia] ?? 0;
            $porc = $porcentaje($cantidad);
            $datos_apariencia[] = [
                'nombre'        => $nombre,
                'cantidad'      => $cantidad,
                'porcentaje'    => $porc
            ];
        }


        return \PDF::loadView('pdf.reporte_laminas.resultados_calidad', [
            'resultados'       => $resultados,
            'datos_frotis'     => $datos_frotis,
            'datos_tincion'    => $datos_tincion,
            'datos_apariencia' => $datos_apariencia,
            'datos'            => $datos,
        ])
        ->setPaper('A4', 'portrait')
        ->download('reporte_laminas.pdf');
    }
    

    public function reporte_ingreso (Request $request)
    {
        $id_lamina  = $request->query('id_lamina');

        $datos = Lamina::select(
                'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
                'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
                'anali.name as analita', 'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones',

                'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
                'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
                'ingreso_laminas.laminas_documentacion', 'ingreso_laminas.total_laminas_recib', 'can.descripcion as procedencia'
            )
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
            ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
            ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista') 
            ->join('inspi_crns.cantones as can', 'can.id', '=', 'ins.canton_id')
            ->where('ingreso_laminas.estado', ['A'])
            ->where('ingreso_laminas.id', $id_lamina)->first();

       // dd($datos);       

        try {
            // Intentar generar el PDF
            return \PDF::loadView('pdf.pdfLamina_ingreso', [
                'datos'  => $datos,
            ])
            ->setPaper('A4', 'landscape')
            ->download('ingreso_laminas_'.$id_lamina.'.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }

    public function reporte_desglose (Request $request)
    {
        $id_lamina  = $request->query('id_lamina');
            
            //dd($datos);       
            $datos = Lamina::select(
                'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
                'ingreso_laminas.total_laminas as total_laminas', 'ingreso_laminas.total_laminas_recib','ins.descripcion as instituto', 'recep.name as recepta',
                'ins.unicodigo as unicodigo', 

                'ingreso_laminas.laminas_empacadas', 'ingreso_laminas.laminas_legibles', 'ingreso_laminas.laminas_sin_id',
                'ingreso_laminas.laminas_sin_aceite', 'ingreso_laminas.laminas_frotis_adecuado', 'ingreso_laminas.laminas_integras',
                'ingreso_laminas.laminas_documentacion'
            )
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
            ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
            ->where('ingreso_laminas.estado', ['A'])
            ->where('ingreso_laminas.id', $id_lamina)->first();
           
            $laminas = DB::table('inspi_crns.desglose_lamina as desglose')
            ->select(
                'desglose.nro_lamina','desglose.lectura', 'apariencia.nombre as apariencia_nombre',
                'frotis.nombre as frotis_nombre','tincion.nombre as tincion_nombre'
            )
            ->join('inspi_crns.apariencia_microscopica as apariencia', 'apariencia.id', '=', 'desglose.id_apariencia')
            ->join('inspi_crns.calidad_frotis as frotis', 'frotis.id', '=', 'desglose.id_frotis')
            ->join('inspi_crns.calidad_tincion as tincion', 'tincion.id', '=', 'desglose.id_tincion')
            ->where('desglose.id_lamina', $id_lamina)
            ->get();
        

            // Obtener el total de registros
            $total_registros = Desglose::where('id_lamina', $id_lamina)->count();

            // Obtener el conteo de cada tipo de frotis
            $conteos_frotis = Desglose::where('id_lamina', $id_lamina)
                ->selectRaw('id_frotis, COUNT(*) as total')
                ->groupBy('id_frotis')
                ->pluck('total', 'id_frotis');

            // Obtener el conteo de cada tipo de tinción
            $conteos_tincion = Desglose::where('id_lamina', $id_lamina)
                ->selectRaw('id_tincion, COUNT(*) as total')
                ->groupBy('id_tincion')
                ->pluck('total', 'id_tincion');

            // Obtener el conteo de cada tipo de apariencia
            $conteos_apariencia = Desglose::where('id_lamina', $id_lamina)
                ->selectRaw('id_apariencia, COUNT(*) as total')
                ->groupBy('id_apariencia')
                ->pluck('total', 'id_apariencia');

            // Obtener los nombres de frotis, tinción y apariencia desde la base de datos
            $tipos_frotis = Frotis::pluck('nombre', 'id');
            $tipos_tincion = Tincion::pluck('nombre', 'id');
            $tipos_apariencia = Apariencia::pluck('nombre', 'id');

            // Construir el arreglo con los datos de frotis
            $datos_frotis = [];
            foreach ($tipos_frotis as $id_frotis => $nombre) {
                $cantidad = $conteos_frotis[$id_frotis] ?? 0;
                $datos_frotis[] = [
                    'nombre'        => $nombre,
                    'cantidad'      => $cantidad,
                ];
            }

            // Construir el arreglo con los datos de tinción
            $datos_tincion = [];
            foreach ($tipos_tincion as $id_tincion => $nombre) {
                $cantidad = $conteos_tincion[$id_tincion] ?? 0;
                $datos_tincion[] = [
                    'nombre'        => $nombre,
                    'cantidad'      => $cantidad,

                ];
            }

            // Construir el arreglo con los datos de apariencia (SIN calificación)
            $datos_apariencia = [];
            foreach ($tipos_apariencia as $id_apariencia => $nombre) {
                $cantidad = $conteos_apariencia[$id_apariencia] ?? 0;
                $datos_apariencia[] = [
                    'nombre'        => $nombre,
                    'cantidad'      => $cantidad,

                ];
            }

        try {
            // Intentar generar el PDF
            return \PDF::loadView('pdf.pdfLamina_desglose', [
                'datos'           => $datos,
                'datos_apariencia'=> $datos_apariencia,
                'datos_frotis'    => $datos_frotis,
                'datos_tincion'   => $datos_tincion,
                'laminas'         => $laminas,
            ])
            ->setPaper('A4', 'portrait')
            ->download('desglose_laminas_'.$id_lamina.'.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }

    public function registro_muestra (Request $request)
    {
        //dd($datos);   

        try {

            return \PDF::loadView('pdf.registros.pdfRegistro_Muestra', [
             
            ])
            ->setPaper('A4', 'portrait')
            ->download('registro_muestra.pdf');

        } catch (\Exception $e) {

            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }

    public function registro_solicitud (Request $request)
    {
        //dd($datos);   

        try {

            return \PDF::loadView('pdf.registros.pdfRegistro_Solicitud', [
             
            ])
            ->setPaper('A4', 'portrait')
            ->download('registro_solicitud.pdf');

        } catch (\Exception $e) {

            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }


}




