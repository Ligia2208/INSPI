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

//use App\Models\Area\Area;
use App\Models\CoreBase\Area;

use App\Traits\GetDireccionTrait;

class CentrosLaminasController extends Controller
{

    use GetDireccionTrait;

    public function index(Request $request){

        $estado = $request->input('estado');

        if(request()->ajax()) {


            

            $query = Lamina::select(
                'ingreso_laminas.id as id', 'ingreso_laminas.mes_recepcion as mes_recepcion', 'ingreso_laminas.fecha_recep as fecha_recep',
                'ingreso_laminas.total_laminas as total_laminas', 'ins.descripcion as instituto', 'recep.name as recepta',
                'anali.name as analita'
            )
            ->join('inspi_crns.tecnicas as tec', 'tec.id', '=', 'ingreso_laminas.id_tecnica')
            ->join('inspi_crns.instituciones_salud as ins', 'ins.id', '=', 'ingreso_laminas.id_unidad_salud')
            ->join('bdcoreinspi.users as recep', 'recep.id', '=', 'ingreso_laminas.id_responsable')
            ->join('bdcoreinspi.users as anali', 'anali.id', '=', 'ingreso_laminas.id_analista')
            ->whereNotIn('ingreso_laminas.estado', ['A']);
        
            // **Devolver datos en formato JSON**
            return datatables()->of($query)->addIndexColumn()->make(true);
        }

        //respuesta para la vista
        return view('lamina.index', compact(1));

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
    


}




