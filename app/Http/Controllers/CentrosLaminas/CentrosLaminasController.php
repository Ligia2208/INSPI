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



    public function guardar_laminas_bact(Request $request){

        $datos = $request->input('datos');
        $id_ingreso = $request->input('id_ingreso');

        //datos del ingreso de laminas
        $fecha_recep         = $request->input('fecha_recep');
        $centro_salud        = $request->input('centro_salud');
        $evento              = $request->input('evento');
        $responsable         = $request->input('responsable');
        $fecha_recebcion     = $request->input('fecha_recebcion');
        $mes_recepcion       = $request->input('mes_recepcion');
        $total_laminas       = $request->input('total_laminas');
        $total_laminas_super = $request->input('total_laminas_super');
        $codigo              = $request->input('codigo');
        //$fecha_inicio        = $request->input('fecha_inicio');
        //$fecha_fin           = $request->input('fecha_fin');
        $observacion         = $request->input('observacion');
        $total_laminas_pos   = $request->input('total_laminas_pos');
        $total_laminas_neg   = $request->input('total_laminas_neg');
        $codigo_lec          = $request->input('codigo_lec');

        $resultados          = $request->input('resultados');

        $lamina = Lamina::create([
            'id_tecnica'          => 1,
            'id_analista'         => $responsable, //195,
            'fecha_recep'         => $fecha_recep,
            'id_unidad_salud'     => $centro_salud,
            //'id_unidad_salud'     => 1,
            'id_evento'           => $evento,
            //'id_evento'           => 1,
            'id_responsable'      => $responsable,
            //'id_responsable'      => 195,
            'fecha_recebcion'     => $fecha_recebcion,
            'mes_recepcion'       => $mes_recepcion,
            'total_laminas'       => $total_laminas_super,
            'total_laminas_recib' => $total_laminas,
            'cod_microscopia'     => $codigo,
            //'fecha_ini'           => $fecha_inicio,
            //'fecha_fin'           => $fecha_fin,
            'observaciones'       => $observacion,
            'codigo_lec'          => $codigo_lec,

            //'laminas_positivas_rec' => $resultados['resultado']['positivas'],
            //'laminas_negativas_rec' => $resultados['resultado']['negativas'],

            'laminas_positivas_rec' => $total_laminas_pos,
            'laminas_negativas_rec' => $total_laminas_neg,
            'id_crn'              => 5,
        ]);
        
        foreach ($datos as $dato) {
            Desglose::create([
                'id_lamina'           => $lamina->id,  
                'fecha'               => $dato['fecha'],
                'semana'              => $dato['semana'],
                'diagnostico_control' => $dato['diagnostico_calidad'],
                'vivax_control'       => $dato['recuento_control_vivax'] ?? '',
                'falciparum_control'  => $dato['recuento_control_falciparum'] ?? '',
                'fg_control'          => $dato['presencia_control'] ?? '',
                'diagnostico_micro'   => $dato['diagnostico_microscopista'],
                'vivax_micro'         => $dato['recuento_microscopista_vivax'] ?? '',
                'falciparum_micro'    => $dato['recuento_microscopista_falciparum'] ?? '',
                'mg_micro'            => $dato['presencia_microscopista'] ?? '',
                'cod_lectura'         => $dato['codigo_micro'],
                'nro_lamina'          => $dato['num_lamina'],

                'lectura'             => '',    
                'id_apariencia'       => 1,
                'id_frotis'           => 1,
                'id_tincion'          => 1,

            ]);
        }

        
        Resultado::create([
            'id_evento'            => 1,
            'id_tecnica'           => 1,
            'tecnica_lamina'       => $evento,
            'id_unidad_salud'      => 1,
            'nro_laminas'          => $total_laminas_super, 

            'interpretacion'       => $resultados['interpretacion'], // Llamar a la función
            'id_lamina'            => $lamina->id,
            'porcentaje_laminas'   => $resultados['puntuacion'],

            'resultado'            => $resultados['porcentajeResult'],
            'especie'              => $resultados['porcentajeEspe'],
            'recuentos'            => $resultados['porcentajeRecuen'],

            'laminas_positivas_con' => $resultados['resultado']['positivasConcordantes'],
            'laminas_positivas_dis' => $resultados['resultado']['positivasDiscordantes'],
            'laminas_negativas_con' => $resultados['resultado']['negativasConcordantes'],
            'laminas_negativas_dis' => $resultados['resultado']['negativasDiscordantes'],

            
        ]);



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




    // ======================================= BACTERIOLOGIA =======================================
    public function laminas_bacteriologia(Request $request){

        //$estado = $request->input('estado');

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
            ->where('ingreso_laminas.estado', 'A')
            ->where('ingreso_laminas.id_crn', 5);
        
            return datatables()->of($query)->addIndexColumn()->make(true);
        }

        //respuesta para la vista
        return view('lamina.index_bact');

    }


    public function agregar_laminas_bact(){

        $eventos       = Evento::select('id', 'descripcion', 'simplificado')->where('estado', 'A')->where('laminas', true)->where('crns_id', 5)->get();
        $instituciones = Institucion::select('id', 'descripcion', 'unicodigo')->where('estado', 'A')->where('unicodigo', 'like', 'LR%')->get();
        $responsables  = Responsable::where('crns_id', 5)->with('usuario')->get();

        return view('lamina.agregar_laminas_bact', compact('eventos', 'instituciones', 'responsables'));

    }



    public function editar_bact($id_ingreso){

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas_recib as total_laminas_recib', DB::raw("DATE_FORMAT(ingreso_laminas.created_at, '%Y-%m-%d') as fecha_recebcion"),
            'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones', 'ingreso_laminas.codigo_lec as codigo_lec',
            'ins.id as centro_salud', 'ingreso_laminas.id_evento as id_evento', 'ingreso_laminas.id_responsable as id_responsable',
            'ingreso_laminas.director_us', 'ingreso_laminas.total_laminas', 'ingreso_laminas.fecha_ini as fecha_ini',
            'ingreso_laminas.fecha_fin as fecha_fin', 'ingreso_laminas.laminas_positivas_rec as laminas_positivas_rec', 'ingreso_laminas.laminas_negativas_rec as laminas_negativas_rec'
        )
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        //falta el desglose
        $desglose = Desglose::select('fecha', 'semana', 'diagnostico_control', 'vivax_control',
            'falciparum_control', 'fg_control', 'diagnostico_micro', 'vivax_micro', 'falciparum_micro',
            'mg_micro', 'cod_lectura', 'nro_lamina')
            ->where('id_lamina', $id_ingreso)->where('estado', 'A')->get();

        $eventos = Evento::select('id', 'descripcion', 'simplificado')->where('estado', 'A')->where('laminas', true)->where('crns_id', 5)->get();
        $instituciones = Institucion::select('id', 'descripcion', 'unicodigo')->where('estado', 'A')->where('unicodigo', 'like', 'LR%')->get();
        $responsables = Responsable::where('crns_id', 5)->with('usuario')->get();

        return view('lamina.editar_bact', compact('datos', 'eventos', 'instituciones', 'responsables', 'desglose'));

    }


    public function obtenerDesglose($id)
    {
        $desglose = Desglose::select('fecha', 'semana', 'diagnostico_control', 'vivax_control',
            'falciparum_control', 'fg_control', 'diagnostico_micro', 'vivax_micro', 'falciparum_micro',
            'mg_micro', 'cod_lectura', 'nro_lamina')
            ->where('id_lamina', $id)
            ->where('estado', 'A')
            ->get();

        return response()->json($desglose);
    }


    public function editar_laminas_bact(Request $request){

        $datos = $request->input('datos');
        $id_ingreso = $request->input('id_ingreso');

        //datos del ingreso de laminas
        $fecha_recep         = $request->input('fecha_recep');
        $centro_salud        = $request->input('centro_salud');
        $evento              = $request->input('evento');
        $responsable         = $request->input('responsable');
        $fecha_recebcion     = $request->input('fecha_recebcion');
        $mes_recepcion       = $request->input('mes_recepcion');
        $total_laminas       = $request->input('total_laminas');
        $total_laminas_super = $request->input('total_laminas_super');
        $codigo              = $request->input('codigo');
        //$fecha_inicio        = $request->input('fecha_inicio');
        //$fecha_fin           = $request->input('fecha_fin');
        $observacion         = $request->input('observacion');
        $total_laminas_pos   = $request->input('total_laminas_pos');
        $total_laminas_neg   = $request->input('total_laminas_neg');
        $codigo_lec          = $request->input('codigo_lec');

        $resultados          = $request->input('resultados');


        $lamina = Lamina::findOrFail($id_ingreso); // Busca la lámina, lanza 404 si no existe

        // Actualizamos los campos
        $lamina->update([
            'id_tecnica'          => 1,
            'id_analista'         => $request->input('responsable'),
            'fecha_recep'         => $request->input('fecha_recep'),
            'id_unidad_salud'     => $request->input('centro_salud'),
            'id_evento'           => $request->input('evento'),
            'id_responsable'      => $request->input('responsable'),
            'fecha_recebcion'     => $request->input('fecha_recebcion'),
            'mes_recepcion'       => $request->input('mes_recepcion'),
            'total_laminas'       => $request->input('total_laminas_super'),
            'total_laminas_recib' => $request->input('total_laminas'),
            'cod_microscopia'     => $request->input('codigo'),
            //'fecha_ini'           => $request->input('fecha_inicio'),
            //'fecha_fin'           => $request->input('fecha_fin'),
            'observaciones'       => $request->input('observacion'),
    
            'laminas_positivas_rec' => $total_laminas_pos,
            'laminas_negativas_rec' => $total_laminas_neg,
            'id_crn'              => 5,
        ]);
        


        // Obtiene todos los desgloses existentes de la lámina
        $desglosesExistentes = Desglose::where('id_lamina', $lamina->id)->get();

        // Contador para recorrer los datos
        for ($i = 0; $i < count($datos); $i++) {
            $dato = $datos[$i];

            if (isset($desglosesExistentes[$i])) {
                // Ya existe un desglose en esta posición → actualizar
                $desglose = $desglosesExistentes[$i];
                $desglose->update([
                    'fecha'               => $dato['fecha'],
                    'semana'              => $dato['semana'],
                    'diagnostico_control' => $dato['diagnostico_calidad'],
                    'vivax_control'       => $dato['recuento_control_vivax'] ?? '',
                    'falciparum_control'  => $dato['recuento_control_falciparum'] ?? '',
                    'fg_control'          => $dato['presencia_control'] ?? '',
                    'diagnostico_micro'   => $dato['diagnostico_microscopista'],
                    'vivax_micro'         => $dato['recuento_microscopista_vivax'] ?? '',
                    'falciparum_micro'    => $dato['recuento_microscopista_falciparum'] ?? '',
                    'mg_micro'            => $dato['presencia_microscopista'] ?? '',
                    'cod_lectura'         => $dato['codigo_micro'],
                    'nro_lamina'          => $dato['num_lamina'],
                    'lectura'             => '',
                    'id_apariencia'       => 1,
                    'id_frotis'           => 1,
                    'id_tincion'          => 1,
                ]);
            } else {
                // No existe → crear nuevo
                Desglose::create([
                    'id_lamina'           => $lamina->id,
                    'fecha'               => $dato['fecha'],
                    'semana'              => $dato['semana'],
                    'diagnostico_control' => $dato['diagnostico_calidad'],
                    'vivax_control'       => $dato['recuento_control_vivax'] ?? '',
                    'falciparum_control'  => $dato['recuento_control_falciparum'] ?? '',
                    'fg_control'          => $dato['presencia_control'] ?? '',
                    'diagnostico_micro'   => $dato['diagnostico_microscopista'],
                    'vivax_micro'         => $dato['recuento_microscopista_vivax'] ?? '',
                    'falciparum_micro'    => $dato['recuento_microscopista_falciparum'] ?? '',
                    'mg_micro'            => $dato['presencia_microscopista'] ?? '',
                    'cod_lectura'         => $dato['codigo_micro'],
                    'nro_lamina'          => $dato['num_lamina'],
                    'lectura'             => '',
                    'id_apariencia'       => 1,
                    'id_frotis'           => 1,
                    'id_tincion'          => 1,
                ]);
            }
        }

        // Si hay más desgloses existentes que datos → eliminar los que sobran
        if (count($desglosesExistentes) > count($datos)) {
            for ($j = count($datos); $j < count($desglosesExistentes); $j++) {
                $desglosesExistentes[$j]->delete();
            }
        }


        $resultado = Resultado::where('id_lamina', $lamina->id)->first();

        $dataResultado = [
            'id_evento'             => 1,
            'id_tecnica'            => 1,
            'tecnica_lamina'        => $evento,
            'id_unidad_salud'       => 1,
            'nro_laminas'           => $total_laminas_super,
        
            'interpretacion'        => $resultados['interpretacion'],
            'porcentaje_laminas'    => $resultados['puntuacion'],
            'resultado'             => $resultados['porcentajeResult'],
            'especie'               => $resultados['porcentajeEspe'],
            'recuentos'             => $resultados['porcentajeRecuen'],
        
            'laminas_positivas_con' => $resultados['resultado']['positivasConcordantes'],
            'laminas_positivas_dis' => $resultados['resultado']['positivasDiscordantes'],
            'laminas_negativas_con' => $resultados['resultado']['negativasConcordantes'],
            'laminas_negativas_dis' => $resultados['resultado']['negativasDiscordantes'],
        ];
        
        if ($resultado) {
            // Ya existe → actualizar
            $resultado->update($dataResultado);
        } else {
            // No existe → crear nuevo
            Resultado::create(array_merge($dataResultado, ['id_lamina' => $lamina->id]));
        }
        

        // Retornar una respuesta de éxito
        return response()->json(['success' => true, 'message' => 'Desglose actualizado correctamente'], 200);
    }


    public function visualizar_bact($id_ingreso)
    {

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas_recib as total_laminas_recib', DB::raw("DATE_FORMAT(ingreso_laminas.created_at, '%Y-%m-%d') as fecha_recebcion"),
            'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones', 'ingreso_laminas.codigo_lec as codigo_lec',
            'ins.id as centro_salud', 'ingreso_laminas.id_evento as id_evento', 'ingreso_laminas.id_responsable as id_responsable',
            'ingreso_laminas.director_us', 'ingreso_laminas.total_laminas', 'ingreso_laminas.fecha_ini as fecha_ini',
            'ingreso_laminas.fecha_fin as fecha_fin', 'ingreso_laminas.laminas_positivas_rec as laminas_positivas_rec', 'ingreso_laminas.laminas_negativas_rec as laminas_negativas_rec'
        )
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        //falta el desglose
        $desglose = Desglose::select('fecha', 'semana', 'diagnostico_control', 'vivax_control',
            'falciparum_control', 'fg_control', 'diagnostico_micro', 'vivax_micro', 'falciparum_micro',
            'mg_micro', 'cod_lectura', 'nro_lamina')
            ->where('id_lamina', $id_ingreso)->where('estado', 'A')->get();

        $eventos = Evento::select('id', 'descripcion', 'simplificado')->where('estado', 'A')->where('laminas', true)->where('crns_id', 5)->get();
        $instituciones = Institucion::select('id', 'descripcion', 'unicodigo')->where('estado', 'A')->where('unicodigo', 'like', 'LR%')->get();
        $responsables = Responsable::where('crns_id', 5)->with('usuario')->get();

        return view('lamina.visualizar_bact', compact('datos', 'eventos', 'instituciones', 'responsables', 'desglose'));

    }


    public function eliminar_bact(Request $request)
    {

        $id_ingreso = $request->input('id'); 

        $ingreso = Lamina::find($id_ingreso);
        $ingreso->estado = 'E';

        $ingreso->save();

        if ($ingreso) {

            return response()->json(['message' => 'Se elimino el ingreso de las Láminas correctamente.', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar el ingreso de las láminas', 'data' => false], 500);

        }

    }


 
    public function reporte_control_calidad_par($id)
    {
        $lamina = Lamina::select('mes_recepcion','fecha_recep','total_laminas_recib','laminas_positivas_rec',
                'laminas_negativas_rec','total_laminas','observaciones', 'id_evento', 'id_responsable','id_unidad_salud',)
            ->where('id', $id)
            ->latest('fecha_recep')
            ->first();

        $evento = Evento::select('descripcion')
            ->where('id', $lamina->id_evento)
            ->first();

        $responsable = User::select('name')
            ->where('id', $lamina->id_responsable)
            ->first();

        $unidadSalud = DB::table('inspi_crns.instituciones_salud as ins')
            ->select('ins.descripcion as unidad_salud' , 'ins.unicodigo as unicodigo', 'can.descripcion as canton', 'pro.descripcion as provincia', 'ins.responsable')
            ->join('inspi_crns.cantones as can', 'can.id', '=', 'ins.canton_id')
            ->join('inspi_crns.provincias as pro', 'pro.id', '=', 'ins.provincia_id')
            ->where('ins.id', $lamina->id_unidad_salud)
            ->first();

        $eventoDescripcion = $evento ? $evento->descripcion : 'Evento no encontrado';
        $responsableNombre = $responsable ? $responsable->name : 'Responsable no encontrado';

        $resultados = Resultado::select('laminas_positivas_con','laminas_positivas_dis','laminas_negativas_con',
                'laminas_negativas_dis','porcentaje_laminas','interpretacion','resultado','especie','recuentos',)
            ->where('id_lamina', $id)
            ->first();

        return \PDF::loadView('pdf.indirecto.pdfControl_Calidad_Par', [
            'lamina' => $lamina,
            'eventoDescripcion' => $eventoDescripcion,
            'responsableNombre' => $responsableNombre,
            'unidadSalud' => $unidadSalud,
            'resultados' => $resultados,
        ])
        ->setPaper('A4', 'portrait')
        ->download('reporte_control_calidad_par.pdf');
    }


    

    public function reporte_control_calidad_indirecto($id_lamina)
    {
        
        $diagnosticos = [
            '1' => 'F - Falciparum',
            '2' => 'N - Negativo',
            '3' => 'V - Vivax',
            '4' => 'V/F - Vivax/Falciparum',
        ];

        $lamina = Lamina::select(
            'codigo_lec',            
        )
        ->where('id', $id_lamina)
        ->first();

        $datos = Desglose::select(
            'fecha',
            DB::raw('YEAR(fecha) as anio'),
            DB::raw('MONTH(fecha) as mes'),
            'semana',
            'diagnostico_control',
            'vivax_control',
            'falciparum_control',
            'fg_control',
            'diagnostico_micro',
            'vivax_micro',
            'falciparum_micro',
            'mg_micro',
            'cod_lectura',
            'nro_lamina'
        )
        ->where('id_lamina', $id_lamina)
        ->where('estado', 'A')
        ->get();
    
        $codLectura = $datos->first()->cod_lectura ?? null;

        //return response()->json($id_lamina);
        return \PDF::loadView('pdf.indirecto.pdfControl_Calidad_Indirecto', 
            [
                'datos' => $datos, 
                'diagnosticos' => $diagnosticos,
                'lamina' => $lamina,
                'codLectura' => $codLectura,]) 
            ->setPaper('A4', 'landscape')
            ->download('reporte_CONTROL DE CALIDAD INDIRECTO.pdf');
        
    }



    public function laminas_parasitologia_validar(Request $request){

        //$estado = $request->input('estado');

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
                ) as tiene_desglose'),
                'resul.porcentaje_laminas as porcentaje_laminas',
                'resul.interpretacion as interpretacion'
            )
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
            ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
            ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
            ->join('inspi_crns.resultado_laminas as resul', 'resul.id_lamina', '=', 'ingreso_laminas.id')
            ->where('ingreso_laminas.estado', 'A')
            ->where('ingreso_laminas.id_crn', 5);
        
            return datatables()->of($query)->addIndexColumn()->make(true);
        }

        //respuesta para la vista
        return view('lamina.index_parasito_val');

    }

    public function laminas_parasitologia_procesadas(Request $request){


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
                    ) as tiene_desglose'),
                    'resul.porcentaje_laminas as porcentaje_laminas',
                    'resul.interpretacion as interpretacion'
                )
                ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
                ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
                ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
                ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
                ->join('inspi_crns.resultado_laminas as resul', 'resul.id_lamina', '=', 'ingreso_laminas.id')
                ->whereIn('ingreso_laminas.estado', ['V' ,'R'])
                ->where('ingreso_laminas.id_crn', 5);
            
                return datatables()->of($query)->addIndexColumn()->make(true);
            }

            //respuesta para la vista
            return view('lamina.index_parasito_pro');

    }

    public function validar_parasito($id_ingreso){

        $datos = Lamina::select(
            'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
            'ingreso_laminas.total_laminas_recib as total_laminas_recib', DB::raw("DATE_FORMAT(ingreso_laminas.created_at, '%Y-%m-%d') as fecha_recebcion"),
            'ins.unicodigo as unicodigo', 'ingreso_laminas.observaciones as observaciones', 'ingreso_laminas.codigo_lec as codigo_lec',
            'ins.id as centro_salud', 'ingreso_laminas.id_evento as id_evento', 'ingreso_laminas.id_responsable as id_responsable',
            'ingreso_laminas.director_us', 'ingreso_laminas.total_laminas', 'ingreso_laminas.fecha_ini as fecha_ini',
            'ingreso_laminas.fecha_fin as fecha_fin', 'ingreso_laminas.laminas_positivas_rec as laminas_positivas_rec', 'ingreso_laminas.laminas_negativas_rec as laminas_negativas_rec'
        )
        ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
        ->where('ingreso_laminas.estado', ['A'])
        ->where('ingreso_laminas.id', $id_ingreso)->first();

        //falta el desglose
        $desglose = Desglose::select('fecha', 'semana', 'diagnostico_control', 'vivax_control',
            'falciparum_control', 'fg_control', 'diagnostico_micro', 'vivax_micro', 'falciparum_micro',
            'mg_micro', 'cod_lectura', 'nro_lamina')
            ->where('id_lamina', $id_ingreso)->where('estado', 'A')->get();

        $eventos = Evento::select('id', 'descripcion', 'simplificado')->where('estado', 'A')->where('laminas', true)->where('crns_id', 5)->get();
        $instituciones = Institucion::select('id', 'descripcion', 'unicodigo')->where('estado', 'A')->where('unicodigo', 'like', 'LR%')->get();
        $responsables = Responsable::where('crns_id', 5)->with('usuario')->get();

        return view('lamina.validar_parasito', compact('datos', 'eventos', 'instituciones', 'responsables', 'desglose'));

    }
    
    
    

}




