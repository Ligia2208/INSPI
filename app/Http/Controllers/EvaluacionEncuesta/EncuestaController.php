<?php

namespace App\Http\Controllers\EvaluacionEncuesta;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Models\EventoEncuesta\Encuesta\Encuesta;
use App\Models\EventoEncuesta\Preguntas\Preguntas;
use App\Models\EventoEncuesta\Opciones\Opciones;

use App\Models\EventoEncuesta\Periodo\Periodo;
use App\Models\EventoEncuesta\EventoLaboratorio\EventoLaboratorio;
use App\Models\RolUsers\RolUser;

use App\Mail\UsuarioHospital;
use App\Mail\UsuarioIE;
use App\Mail\UsuarioEvento;


//usuarios
use App\Models\EventoEncuesta\EncuestaUser\EncuestaUser;
use App\Models\EventoEncuesta\PreguntasUser\PreguntasUser;
use App\Models\EventoEncuesta\OpcionesUser\OpcionesUser;

use App\Models\EventoEncuesta\TipoEncuesta\TipoEncuesta;
use App\Models\EventoEncuesta\LaboratorioEncuesta\LaboratorioEncuesta;
use App\Models\EventoEncuesta\Laboratorio\Laboratorio;
use App\Models\EventoEncuesta\Evento\Evento;
use App\Models\EventoEncuesta\LaboratorioResp\LaboratorioResp;
use App\Models\EventoEncuesta\Servicios\Servicios;
use App\Models\EventoEncuesta\ServiciosEnc\ServiciosEnc;


use App\Models\EventoEncuesta\UsuarioLaboratorio\UsuarioLaboratorio;
use App\Models\EventoEncuesta\Usuario\Usuario;

use Illuminate\Support\Facades\Session;

use App\Http\Requests\DocumentoRequest;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Models\PermisoRolOpcion\PermisoRolOpcion;
use App\Models\Modulos\ModuloLateral;
use App\Models\Modulos\Modulo;
use App\Models\Opciones\OpcionLateral;
use App\Models\Catalogo\Catalogo;
use App\Models\Tablas\Tabla;
use App\Models\User;
use Datatables;

use App\Models\GestionDocumental\Documento\GDocumento;
use App\Models\GestionDocumental\Chat\Chat;
use App\Models\GestionDocumental\Asignacion\Asignacion;

use App\Models\GestionDocumental\HistAsignacion\HistAsignacion;

use App\Models\Area\Area;
use App\Models\Czonal\Czonal;
use App\Models\Provincia\Provincia;
use App\Models\Canton\Canton;
use Illuminate\Support\Facades\DB;
use App\Models\GestionDocumental\TipoDocumento\TipoDocumento;
use App\Models\GestionDocumental\Estado\Estado;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;

use App\Models\Role;

use Illuminate\Http\Request;
use Cache;
use League\CommonMark\Extension\Table\Table;

class EncuestaController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth')->except(['doEncuestaSatisfaccion', 'guardarEncuesta', 'completed']);        
        //$this->middleware('auth')->except('guardarEncuesta');
    }
    


    public function index(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        if(request()->ajax()) {

            return datatables()->of($evento = Evento::select('lab.descripcion as laboratorio_id', 'enc_evento.id', 'enc_evento.nombre',
                            'enc_evento.anio', 'per.nombre as periodo', 'enc_evento.estado', 'enc_evento.created_at', 'enc_evento.updated_at')
                            ->join('db_inspi_encuesta.enc_laboratorio as lab', 'lab.id', '=', 'db_inspi_encuesta.enc_evento.laboratorio_id')
                            ->join('db_inspi_encuesta.enc_periodo as per', 'per.id', '=', 'db_inspi_encuesta.enc_evento.periodo')
                            ->where('enc_evento.estado', 'A'))
            ->addIndexColumn()
            ->make(true);

        }

        //respuesta para la vista
        return view('evaluacion_encuesta.index');
    }


    public function asignar(Request $request){

        // Realiza el proceso de asignaciÃ³n aquÃ­, utilizando los datos proporcionados en $request
        $documentoId = $request->input('id_documento');

        $tipoestado = Catalogo::where('id_tabla', 1)->orderBy('id', 'asc')->get();
        $tabla = Tabla::all();
        return view('gestion_documental.asignar',compact('tipoestado', 'tabla'));
    }



    /* TRAE LA VISTA PARA CREAR LA ENCUESTA */
    public function createView(){

        return view('evaluacion_encuesta.create_encuesta');
    }
    /* TRAE LA VISTA PARA CREAR LA ENCUESTA */



    /* GUARDAR ENCUESTA */
    public function saveEncuesta(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombre'      => 'required|string',
            'descripcion' => 'required|string',
            'encuesta'    => 'required|array',
        ]);

        // Crear una nueva encuesta
        $encuesta = Encuesta::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // Verificar si se creÃ³ la encuesta correctamente
        if ($encuesta) {

            $preguntas = $request->encuesta;

            foreach ($preguntas as $pregunta) {

                // Crear preguntas para la encuesta reciÃ©n creada
                $preguntaReq = Preguntas::create([
                    'encuesta_id'    => $encuesta->id,
                    'pregunta'       => $pregunta['name'],
                    'tipo_respuesta' => $pregunta['opcionesN'],
                    'abrindada'      => $pregunta['abrindada'],
                ]);

                //se agregan las opciones
                foreach ($pregunta['opciones'] as $opciones) {

                    $opciones = Opciones::create([
                        'pregunta_id'    => $preguntaReq->id,
                        'nombre'         => $opciones['name'],
                        'tipo_respuesta' => $opciones['id'],
                    ]);

                }

            }

            return response()->json(['message' => 'Encuesta guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al crear la encuesta', 'data' => false], 200);

        }

    }
    /* GUARDAR ENCUESTA */


    /* TRAE LA VISTA PARA LISTAR ENCUESTA */
    public function listEncuesta(){

        if(request()->ajax()) {

            return datatables()->of(DB::table('db_inspi_encuesta.enc_encuesta AS e')
                                    ->select('e.id AS id', 'e.nombre AS nombre', 'e.descripcion AS descripcion', 'e.estado AS estado', DB::raw('DATE(e.created_at) as fecha'), DB::raw('COUNT(p.id) AS numero_preguntas'))
                                    ->leftJoin('db_inspi_encuesta.enc_preguntas AS p', 'e.id', '=', 'p.encuesta_id')
                                    ->where('e.estado', '=', 'A')
                                    ->groupBy('e.id', 'e.nombre', 'e.descripcion', 'e.created_at', 'e.estado') // Ajustado aquÃ­
                                    ->orderBy('e.id')
                                )
            ->addIndexColumn()
            ->make(true);

        }

        return view('evaluacion_encuesta.list_encuesta');

    }
    /* TRAE LA VISTA PARA LISTAR ENCUESTA */



    /* TRAE LA VISTA PARA LISTAR LABORATORIO */
    public function listLaboratorio(){

        if(request()->ajax()) {

            return datatables()->of(DB::table('db_inspi_encuesta.enc_laboratorio AS e')
                                    ->select('e.id AS id', 'p.nombre AS nombre', 'e.descripcion AS descripcion', 'e.estado AS estado', DB::raw('DATE(e.created_at) as fecha'), 'd.nombre AS c_nombre')
                                    ->leftJoin('db_inspi.inspi_area AS p', 'e.area_id', '=', 'p.id')
                                    ->leftJoin('db_inspi.inspi_czonal AS d', 'p.czonal_id', '=', 'd.id')
                                    ->where('e.estado', '=', 'A')
                                    )
            ->addIndexColumn()
            ->make(true);

        }

        return view('evaluacion_encuesta.list_laboratorio ');

    }
    /* TRAE LA VISTA PARA LISTAR LABORATORIO */


    /* TRAE LA VISTA PARA CREAR LABORATORIO */
    public function createLaboratorio(){

        $coordina = Czonal::all();

        $tipoEncuesta = TipoEncuesta::select('*')->where('estado', 'A')->get();

        return view('evaluacion_encuesta.create_laboratorio',compact('coordina', 'tipoEncuesta'));
    }
    /* TRAE LA VISTA PARA CREAR LABORATORIO */


    /* TRAE LA VISTA PARA EDITAR LABORATORIO */
    public function editLaboratorio($id){

        $coordina = Czonal::all();

        $tipoEncuesta = TipoEncuesta::select('*')->where('estado', 'A')->get();

        $datosLabora = Laboratorio::select('enc_laboratorio.id', 'enc_laboratorio.descripcion', 'area.nombre', 'area.id as id_area', 'area.czonal_id')
            ->join('db_inspi.inspi_area as area', 'area.id', '=', 'enc_laboratorio.area_id')
            ->where('enc_laboratorio.estado', 'A')
            ->where('enc_laboratorio.id', $id)->first();
            

        $datosLaboraEncue = LaboratorioEncuesta::where('estado', 'A')->where('laboratorio_id', $id)->get();

        return view('evaluacion_encuesta.edit_laboratorio',compact('coordina', 'tipoEncuesta', 'datosLabora', 'datosLaboraEncue'));
    }
    /* TRAE LA VISTA PARA EDITAR LABORATORIO */


    /* DEVUELVE LOS APARTAMENTOS DEPENDIENDO DEL ID_ZONAL */
    public function departamentos($id){

        $departamentos = Area::where('czonal_id', $id)->orderBy('nombre', 'asc')->get();
        return response()->json($departamentos);

    }
    /* DEVUELVE LOS APARTAMENTOS DEPENDIENDO DEL ID_ZONAL */


    /* ELIMINA EL LABORATORIO POR ID */
    public function eliminarLaboratorio($id){

        $laboratorio = Laboratorio::find($id);

        if($laboratorio){
            $laboratorio->estado = 'E';
            $laboratorio->save();

            return response()->json(['message' => 'Laboratorio eliminado exitosamente', 'data' => true], 200);
        }else{
            return response()->json(['message' => 'Error al eliminar el laboratorio', 'data' => false], 500);
        }

    }
    /* ELIMINA EL LABORATORIO POR ID */


    /* GUARDAR LABORATORIO */
    public function saveLaboratorio(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'coordina'     => 'required|string',
            'descripcion'  => 'required|string',
            'departamento' => 'required|string',
            'tipos'        => 'required|array',
        ]);

        // Buscar o crear un laboratorio
        $laboratorio = Laboratorio::firstOrCreate(
            ['area_id' => $request->departamento, 'estado' => 'A'], // Condición para buscar
            ['descripcion' => $request->descripcion] // Datos a crear si no existe
        );

        // Verifica si el laboratorio fue creado o si ya existía
        $laboratorioCreado = $laboratorio->wasRecentlyCreated; // True si se creó un nuevo registro
        $laboratorioId = $laboratorio->id;

        if($laboratorio){

            foreach ($request->tipos as $tipo) {

                //si el registro existe, solo lo actualiza, si no exixte lo crea
                $laboratorioEncuesta = LaboratorioEncuesta::updateOrCreate(
                    [
                        'laboratorio_id'  => $laboratorio->id,
                        'tipoencuesta_id' => $tipo['id'],
                    ],
                    [
                        'valor' => $tipo['valor'],
                    ]
                );
                
            }

            if ($laboratorioCreado) {
                return response()->json(['message' => 'Laboratorio guardado exitosamente', 'data' => true], 200);
            } else {
                return response()->json(['message' => 'El laboratorio ya existe. Se actualizaron sus tipos de encuesta.', 'data' => true], 200);
            }

        }else {

            return response()->json(['message' => 'Error al crear el laboratorio', 'data' => false], 200);

        }

    }
    /* GUARDAR LABORATORIO */


    /* TRAE LA VISTA PARA CREAR LABORATORIO */
    public function link_encuesta(){

        $tipoEncuesta = TipoEncuesta::select('*')->where('estado', 'A')->get();
        $encuestas    = Encuesta::select('*')->where('estado', 'A')->get();

        return view('evaluacion_encuesta.link_encuesta',compact('encuestas', 'tipoEncuesta'));
    }
    /* TRAE LA VISTA PARA CREAR LABORATORIO */


    /* ENLAZAR TIPO Y ENCUESTA */
    public function saveTipoEncuesta(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_encuesta' => 'required|string',
            'id_tipo'     => 'required|string',
        ]);

        $tipoEncuesta = TipoEncuesta::where('id', $request->id_tipo)->first();

        if ($tipoEncuesta) {
            $tipoEncuesta->update([
                'encuesta_id' => $request->id_encuesta,
            ]);

            return response()->json(['message' => 'Encuesta enlazada con Éxito', 'data' => true], 200);

        }else {

            return response()->json(['message' => 'Error al crear el laboratorio', 'data' => false], 200);

        }

    }
    /* ENLAZAR TIPO Y ENCUESTA */


    /* TRAE LA VISTA PARA CREAR USUARIO LABORATORIO */
    public function createUsuario_lab(){

        $tipoEncuesta = TipoEncuesta::select('*')->where('estado', 'A')->get();
        $encuestas    = Encuesta::select('*')->where('estado', 'A')->get();
        $laboratorios = Laboratorio::select('*')->where('estado', 'A')->get();


        // Obtener las preguntas
        $preguntas = Laboratorio::all();

        // Array para almacenar las preguntas con sus respectivas opciones
        $laboratoriosEncuesta = [];

        foreach ($preguntas as $pregunta) {
            // Obtener las opciones para cada pregunta  LaboratorioEncuesta
            $opciones = LaboratorioEncuesta::select('enc_laboratorioencuesta.tipoencuesta_id','enc_laboratorioencuesta.valor','enc_laboratorioencuesta.id','enc_tipoencuesta.nombre','enc_tipoencuesta.tipo')
                ->join('enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'enc_laboratorioencuesta.tipoencuesta_id')
                ->where('enc_laboratorioencuesta.estado', 'A')
                ->where('enc_laboratorioencuesta.laboratorio_id', $pregunta->id)
                ->where('enc_laboratorioencuesta.valor', 'true')->get();

            $opcionesEncuesta = [];

            foreach ($opciones as $opcion) {
                $opcionesEncuesta[] = [
                    'tipoencuesta_id' => $opcion->tipoencuesta_id,
                    'nombre'          => $opcion->nombre,
                    'valor'           => $opcion->valor,
                    'id'              => $opcion->id,
                    'tipo'            => $opcion->tipo,
                ];
            }

            $laboratoriosEncuesta[] = [
                'id'               => $pregunta->id,
                'area_id'          => $pregunta->area_id,
                'descripcion'      => $pregunta->descripcion,
                'opcionesEncuesta' => $opcionesEncuesta, // Ajusta segÃºn tu estructura de datos
            ];
        }


        return view('evaluacion_encuesta.createUsuario_lab',compact('encuestas', 'tipoEncuesta', 'laboratorios', 'laboratoriosEncuesta'));

    }
    /* TRAE LA VISTA PARA CREAR USUARIO LABORATORIO */



    /* TRAE LA VISTA PARA CREAR USUARIO INTERNOS */
    public function createUsuario_int(Request $request){

        $tipoencu_id    = $request->query('tipoencu_id');

        $data = DB::table('db_inspi_encuesta.enc_laboratorioencuesta AS el')
                ->select('el.laboratorio_id', 'l.area_id', 't.nombre', 't.id')
                ->leftJoin('db_inspi_encuesta.enc_laboratorio AS l', 'el.laboratorio_id', '=', 'l.id')
                ->leftJoin('db_inspi_encuesta.enc_tipoencuesta AS t', 'el.tipoencuesta_id', '=', 't.id')
                ->where('el.id', $tipoencu_id)
                ->get();

        $tipoencuesta_id = $data[0]->id;
        $laboratorio_id = $data[0]->laboratorio_id;

        $usuarios = User::select('users.name', 'users.id')
        ->leftJoin('db_inspi.inspi_area', 'inspi_area.id', '=', 'db_inspi.users.id_area')
        //->where('inspi_area.id', '=', $data[0]->area_id)
        ->where('users.estado', '=', 'A')->get();

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 'enc_usuariolaboratorio.id as id_labusu')
        ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
        ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
        ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
        ->where('enc_laboratorio.id', '=', $data[0]->laboratorio_id)
        ->where('enc_tipoencuesta.tipo', '=', 'I')
        ->where('enc_usuariolaboratorio.estado', '=', 'A')
        ->where('users.estado', '=', 'A')->get();

        return view('evaluacion_encuesta.createUsuario_int',compact('usuarios', 'usuariosLab', 'laboratorio_id', 'tipoencuesta_id'));

    }
    /* TRAE LA VISTA PARA CREAR USUARIO INTERNOS */


    /* CREAR USUARIO INTERNO */
    public function saveUsuarioInt(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'usuarios'        => 'required|string',
            'laboratorio_id'  => 'required|string',
            'tipoencuesta_id' => 'required|string'
        ]);

        // Obtener datos de la tabla 'usuarios'
        $usuarios = User::select('id', 'name', 'email')
            ->where('estado', 'A')
            ->where('id', $request->usuarios)
            ->get();


        if ($usuarios) {

            // Guardar datos en la otra tabla
            foreach ($usuarios as $usuario) {
                $usuarioEnc = new Usuario();
                $usuarioEnc->usuario_id  = $usuario->id;
                $usuarioEnc->nombre      = $usuario->name;
                $usuarioEnc->descripcion = 'Usuario interno';
                $usuarioEnc->apellido    = '';
                $usuarioEnc->correo      = $usuario->email;
                $usuarioEnc->hospital    = '';
                $usuarioEnc->password    = '';
                $usuarioEnc->estado      = 'A';
                $usuarioEnc->save();


                $usuarioLaboratorio = new UsuarioLaboratorio();
                $usuarioLaboratorio->laboratorio_id  = $request->laboratorio_id;
                $usuarioLaboratorio->tipoencuesta_id = $request->tipoencuesta_id;
                $usuarioLaboratorio->usuario_id      = $usuario->id;  //se lo actualizo con el id de la tabla users
                $usuarioLaboratorio->estado          = 'A';
                $usuarioLaboratorio->save();

            }

            $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 'enc_usuariolaboratorio.id as id_labusu')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'I')
            ->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')->get();

            try {
                
                $correo = new UsuarioIE($usuario->name, '', 'Usuario Interno', $usuario->email);
                Mail::to('rserrano@inspi.gob.ec')->send($correo);
            
                return response()->json(['message' => 'Usuario agregado con Éxito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

            } catch (\Exception $e) {

                return response()->json(['message' => 'Usuario agregado con Éxito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

            }

        }else {

            return response()->json(['message' => 'Error al agregar el usuario', 'data' => false], 200);

        }

    }
    /* CREAR USUARIO INTERNO */


    /* ELIMINAR USUARIO INTERNO */
    function deleteUsuarioInt(Request $request){

        $data = $request->validate([
            'usuario_id'     => 'required|string',
            'laboratorio_id' => 'required|string',
            'id_labusu'      => 'required|string',
        ]);

        //UsuarioLaboratorio
        $usuarioEnc = UsuarioLaboratorio::where('id', $request->id_labusu)->first();
        $usuarioEnc->estado = 'E';
        $usuarioEnc->save();

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 'enc_usuariolaboratorio.id as id_labusu')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'I')
            ->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')->get();

        if ($usuarioEnc) {

            return response()->json(['message' => 'Se elimino el usuario con éxito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

        }else {

            return response()->json(['message' => 'Error al eliminar el usuario', 'data' => false], 200);

        }

    }
    /* ELIMINAR USUARIO INTERNO */



    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO NO PRESENCIAL */
    public function createUsuario_nopre(Request $request){

        $tipoencu_id    = $request->query('tipoencu_id');

        $data = DB::table('db_inspi_encuesta.enc_laboratorioencuesta AS el')
                ->select('el.laboratorio_id', 'l.area_id', 't.nombre', 't.id')
                ->leftJoin('db_inspi_encuesta.enc_laboratorio AS l', 'el.laboratorio_id', '=', 'l.id')
                ->leftJoin('db_inspi_encuesta.enc_tipoencuesta AS t', 'el.tipoencuesta_id', '=', 't.id')
                ->where('el.id', $tipoencu_id)
                ->get();

        $tipoencuesta_id = $data[0]->id;
        $laboratorio_id  = $data[0]->laboratorio_id;


        //actualizarlo por user
        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 
            'enc_usuariolaboratorio.id as id_labusu', 'enc_usuariolaboratorio.estado', 'users.email as correo', 'users.hospital as hospital')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $data[0]->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'NP')
            //->where('enc_usuariolaboratorio.estado', '=', 'A')
            /*->where('users.estado', '=', 'A')*/->get();

        return view('evaluacion_encuesta.createUsuario_nopre',compact('usuariosLab', 'laboratorio_id', 'tipoencuesta_id'));

    }
    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO NO PRESENCIAL */


    /* CREAR USUARIO EXTERNO NO PRESENCIAL */
    public function saveUsuarioNopre(Request $request)
    {

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombreUser'      => 'required|string',
            'apellidoUser'    => 'required|string',
            'correoUser'      => 'required|string',
            'hospitalUser'    => 'required|string',
            'laboratorio_id'  => 'required|string',
            'tipoencuesta_id' => 'required|string'
        ]);

        $result = DB::table('db_inspi_encuesta.enc_laboratorio as lab')
            ->select('are.id as area_id', 'are.czonal_id', 'are.institucion_id')
            ->join('db_inspi.inspi_area as are', 'lab.area_id', '=', 'are.id')
            ->join('db_inspi.inspi_czonal as zon', 'are.czonal_id', '=', 'zon.id')
            ->join('db_inspi.inspi_institucion as ins', 'are.institucion_id', '=', 'ins.id')
            ->where('lab.id', $request->laboratorio_id)
            ->first(); // Para obtener la primera fila, puedes usar ->get() para obtener todas las filas

        
        $usuarioValida = User::where('users.email', '=', $request->correoUser)
            ->first();

        //si ya existe un usuario con ese correo solo se lo habilita, si no existe se lo crea
        if($usuarioValida){

            $usuarioValida->estado = 'A';
            $usuarioValida->save();
            $id_user = $usuarioValida->id;

        }else{

            if ($result) {
                $areaId        = $result->area_id;
                $czonalId      = $result->czonal_id;
                $institucionId = $result->institucion_id;
                $contrasenia   = Str::random(12);
    
                $user                   =     new User();
                $user->id_institucion   =     $institucionId;
                $user->id_czonal        =     $czonalId;
                $user->id_area          =     $areaId;
                $user->name             =     $request->nombreUser.' '.$request->apellidoUser;
                $user->nom_user         =     'Usuario externo no presencial';
                $user->email            =     $request->correoUser;
                $user->password         =     bcrypt($contrasenia);
                $user->avatar           =     'img/config/User.png';
                $user->active           =     1;
                $user->hospital         =     $request->hospitalUser;
                $user->estado           =     'A';
                $user->operador_ing     =     auth()->user()->nom_user;
                $user->operador_act     =     auth()->user()->nom_user;
                $user->terminal_ing     =     gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $user->terminal_act     =     gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $user->ip_ing           =     $_SERVER['REMOTE_ADDR'];
                $user->ip_act           =     $_SERVER['REMOTE_ADDR'];
                $user->created_at       =     Date('Y-m-d H:i:s');
                $user->updated_at       =     Date('Y-m-d H:i:s');
                $user->save();

                $id_user = $user->id;
    
    
                //se le asigna un rol
                $roluserST                   =     new RolUser;
                $roluserST->role_id          =     10;
                $roluserST->user_id          =     $user->id;
                $roluserST->estado           =     'A';
                $roluserST->operador_ing     =     auth()->user()->nom_user;
                $roluserST->operador_act     =     auth()->user()->nom_user;
                $roluserST->terminal_ing     =     gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $roluserST->terminal_act     =     gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $roluserST->ip_ing           =     $_SERVER['REMOTE_ADDR'];
                $roluserST->ip_act           =     $_SERVER['REMOTE_ADDR'];
                $roluserST->created_at       =     Date('Y-m-d H:i:s');
                $roluserST->updated_at       =     Date('Y-m-d H:i:s');
                $roluserST->save();
    
                $message = 'Usuario agregado con Éxito';

            }

        }


        // validamos que el usuario no este activado para este laboratorio
        $usuarioExistente = UsuarioLaboratorio::where('laboratorio_id', $request->laboratorio_id)
            ->where('tipoencuesta_id', $request->tipoencuesta_id)
            ->where('usuario_id', $id_user)
            ->exists();

        if ($usuarioExistente) {
            $message = 'El usuario ya existe o ya hay un usuario usando este correo';
        }else{

            $usuarioLaboratorio = new UsuarioLaboratorio();
            $usuarioLaboratorio->laboratorio_id  = $request->laboratorio_id;
            $usuarioLaboratorio->tipoencuesta_id = $request->tipoencuesta_id;
            $usuarioLaboratorio->usuario_id      = $id_user;
            $usuarioLaboratorio->estado          = 'A';
            $usuarioLaboratorio->save();

            $message = 'Usuario agregado con Éxito';

        }


        if($result){

            $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 
            'enc_usuariolaboratorio.id as id_labusu', 'enc_usuariolaboratorio.estado', 'users.email as correo', 'users.hospital as hospital')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'NP')
            /*->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')*/->get();

            try {

                if(!$usuarioValida){

                    $correo = new UsuarioHospital($request->nombreUser, $request->apellidoUser, 'Usuario Externo no Presencial', $contrasenia, $request->correoUser);
                    Mail::to($request->correoUser)->send($correo);

                }
            
                return response()->json(['message' => $message, 'data' => true, 'usuariosLab' => $usuariosLab], 200);

            } catch (\Exception $e) {

                return response()->json(['message' => 'Error al enviar el correo', 'data' => true, 'usuariosLab' => $usuariosLab], 500);

            }


        }else {

            return response()->json(['message' => 'Error al agregar el usuario', 'data' => false], 500);

        }

    }
    /* CREAR USUARIO EXTERNO NO PRESENCIAL */


    /* ELIMINAR USUARIO EXTERNO NO PRESENCIAL */
    function deleteUsuarioNopre(Request $request){

        $data = $request->validate([
            'usuario_id'     => 'required|string',
            'laboratorio_id' => 'required|string',
            'id_labusu'      => 'required|string', 
        ]);

        $usuarioEnc = User::findOrFail($request->usuario_id); // Encuentra el usuario por su ID
        $usuarioEnc->estado = 'E';
        $usuarioEnc->save();

        $usuarioEnc = UsuarioLaboratorio::where('id', $request->id_labusu)->first();
        $usuarioEnc->estado = 'E';
        $usuarioEnc->save();

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 
            'enc_usuariolaboratorio.id as id_labusu', 'enc_usuariolaboratorio.estado', 'users.email as correo', 'users.hospital as hospital')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'NP')
            /*->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')*/
            ->get();

        if ($usuarioEnc) {

            return response()->json(['message' => 'Se elimino el usuario con éxito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

        }else {

            return response()->json(['message' => 'Error al eliminar el usuario', 'data' => false], 200);

        }

    }
    /* ELIMINAR USUARIO EXTERNO NO PRESENCIAL */


    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO PRESENCIAL */
    public function createUsuario_pre(Request $request){

        $tipoencu_id    = $request->query('tipoencu_id');

        $data = DB::table('db_inspi_encuesta.enc_laboratorioencuesta AS el')
                ->select('el.laboratorio_id', 'l.area_id', 't.nombre', 't.id')
                ->leftJoin('db_inspi_encuesta.enc_laboratorio AS l', 'el.laboratorio_id', '=', 'l.id')
                ->leftJoin('db_inspi_encuesta.enc_tipoencuesta AS t', 'el.tipoencuesta_id', '=', 't.id')
                ->where('el.id', $tipoencu_id)
                ->get();

        $tipoencuesta_id = $data[0]->id;
        $laboratorio_id = $data[0]->laboratorio_id;

        $usuarios = User::select('users.name', 'users.id')
        ->leftJoin('db_inspi.inspi_area', 'inspi_area.id', '=', 'db_inspi.users.id_area')
        ->where('inspi_area.id', '=', $data[0]->area_id)
        ->where('users.estado', '=', 'A')->get();

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 'enc_usuariolaboratorio.id as id_labusu')
        ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
        ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
        ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
        ->where('enc_laboratorio.id', '=', $data[0]->laboratorio_id)
        ->where('enc_tipoencuesta.tipo', '=', 'P')
        ->where('enc_usuariolaboratorio.estado', '=', 'A')
        ->where('users.estado', '=', 'A')->get();

        return view('evaluacion_encuesta.createUsuario_pre',compact('usuarios', 'usuariosLab', 'laboratorio_id', 'tipoencuesta_id'));

    }
    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO PRESENCIAL */


    /* CREAR USUARIO EXTERNO PRESENCIAL */
    public function saveUsuarioPre(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'usuarios'        => 'required|string',
            'laboratorio_id'  => 'required|string',
            'tipoencuesta_id' => 'required|string'
        ]);

        // Obtener datos de la tabla 'usuarios'
        $usuarios = User::select('id', 'name', 'email')
            ->where('estado', 'A')
            ->where('id', $request->usuarios)
            ->get();


        if ($usuarios) {

            // Guardar datos en la otra tabla
            foreach ($usuarios as $usuario) {
                $usuarioEnc = new Usuario();
                $usuarioEnc->usuario_id  = $usuario->id;
                $usuarioEnc->nombre      = $usuario->name;
                $usuarioEnc->descripcion = 'Usuario externo presencial';
                $usuarioEnc->apellido    = '';
                $usuarioEnc->correo      = $usuario->email;
                $usuarioEnc->hospital    = '';
                $usuarioEnc->password    = '';
                $usuarioEnc->estado      = 'A';
                $usuarioEnc->save();


                $usuarioLaboratorio = new UsuarioLaboratorio();
                $usuarioLaboratorio->laboratorio_id  = $request->laboratorio_id;
                $usuarioLaboratorio->tipoencuesta_id = $request->tipoencuesta_id;
                $usuarioLaboratorio->usuario_id      = $usuario->id;
                $usuarioLaboratorio->estado          = 'A';
                $usuarioLaboratorio->save();

            }

            $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 'enc_usuariolaboratorio.id as id_labusu')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'P')
            ->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')->get();

            try {
                
                $correo = new UsuarioIE($usuario->name, '', 'Usuario Externo Presencial', $usuario->email);
                Mail::to('rserrano@inspi.gob.ec')->send($correo);
            
                return response()->json(['message' => 'Usuario agregado con Ã©xito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

            } catch (\Exception $e) {

                return response()->json(['message' => 'Usuario agregado con Ã©xito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

            }

        }else {

            return response()->json(['message' => 'Error al agregar el usuario', 'data' => false], 200);

        }

    }
    /* CREAR USUARIO EXTERNO PRESENCIAL */


    /* ELIMINAR USUARIO EXTERNO PRESENCIAL */
    function deleteUsuarioPre(Request $request){

        $data = $request->validate([
            'usuario_id'     => 'required|string',
            'laboratorio_id' => 'required|string',
            'id_labusu'      => 'required|string', 
        ]);

        $usuarioEnc = UsuarioLaboratorio::where('id', $request->id_labusu)->first();
        $usuarioEnc->estado = 'E';
        $usuarioEnc->save();

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 'enc_usuariolaboratorio.id as id_labusu')
        ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
        ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
        ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
        ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
        ->where('enc_tipoencuesta.tipo', '=', 'P')
        ->where('enc_usuariolaboratorio.estado', '=', 'A')
        ->where('users.estado', '=', 'A')->get();

        if ($usuarioEnc) {

            return response()->json(['message' => 'Se elimino el usuario con exito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

        }else {

            return response()->json(['message' => 'Error al eliminar el usuario', 'data' => false], 200);

        }

    }
    /* ELIMINAR USUARIO EXTERNO PRESENCIAL */



    /* TRAE LA VISTA PARA CREAR EVENTO */
    public function createEvento(){

        $coordina = Czonal::all();

        $tipoEncuesta = TipoEncuesta::select('*')->where('estado', 'A')->get();
        $periodos = Periodo::select('*')->where('estado', 'A')->get();
        
        return view('evaluacion_encuesta.create_evento',compact('coordina', 'tipoEncuesta', 'periodos'));
    }
    /* TRAE LA VISTA PARA CREAR EVENTO */


    /* DEVUELVE LOS LABORATORIOS DEPENDIENDO DEL ID_ZONAL */
    public function laboratorios($id){

        //Laboratorio
        $laboratorios = DB::table('db_inspi_encuesta.enc_laboratorio as lab')
        ->select('lab.*')
        ->join('db_inspi.inspi_area as are', 'lab.area_id', '=', 'are.id')
        ->join('db_inspi.inspi_czonal as zon', 'are.czonal_id', '=', 'zon.id')
        ->where('zon.id', $id)
        ->get(); // Para obtener la primera fila, puedes usar ->get() para obtener todas las filas
        return response()->json($laboratorios);


    }
    /* DEVUELVE LOS LABORATORIOS DEPENDIENDO DEL ID_ZONAL */


    /* GUARDAR EVENTO */
    public function saveEvento(Request $request)
    {

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'eventoName'  => 'required|string',
            'coordina'    => 'required|string',
            'laboratorio' => 'required|string',
            'periodo'     => 'required|string',
            'anio'        => 'required|string',
        ]);

        $eventos = Evento::where('estado', 'A')->where('laboratorio_id', $request->laboratorio)
                            ->where('periodo', $request->periodo)->where('anio', $request->anio)->count();

        //verificar cuantos tipos de laboratorios hay
        //EventoLaboratorio
        $laboratorios = LaboratorioEncuesta::where('laboratorio_id', $request->laboratorio)->where('estado', 'A')->get();

        if($eventos == 0){

            // Crear una nueva encuesta
            $evento = Evento::create([
                'nombre'         => $request->eventoName,
                'laboratorio_id' => $request->laboratorio,
                'periodo'        => $request->periodo,
                'anio'           => $request->anio,
                'link'           => $this->generateUniqueLink(),
            ]);

            foreach ($laboratorios as $laboratorio) {
                $eventoLabora = EventoLaboratorio::create([
                    'id_evento'      => $evento->id,
                    'id_labencuesta' => $laboratorio->id,
                ]);
            }

            if($evento){

                return response()->json(['message' => 'Evento guardado exitosamente', 'data' => true], 200);

            }else {

                return response()->json(['message' => 'Error al crear el Evento', 'data' => false], 200);

            }

        }else{
            return response()->json(['message' => 'Error al crear el Evento, no se puede crear un evento ya existente', 'data' => false], 200);
        }

    }
    /* GUARDAR EVENTO */


    /* TRAE LOS TIPOS DE LABORATORIO QUE ESTAN ASOCIADOS A ESE EVENTO */
    public function laboratoriosTipo($id_evento){

        $laboratrios = LaboratorioEncuesta::select('enc_laboratorioencuesta.tipoencuesta_id','enc_laboratorioencuesta.valor','enc_laboratorioencuesta.id',
            'enc_tipoencuesta.nombre','enc_tipoencuesta.tipo', 'enc_evento.id as id_evento')
        ->join('enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'enc_laboratorioencuesta.tipoencuesta_id')
        ->join('enc_evento', 'enc_evento.laboratorio_id', '=', 'enc_laboratorioencuesta.laboratorio_id')
        ->where('enc_laboratorioencuesta.estado', 'A')
        ->where('enc_evento.id', $id_evento)
        ->where('enc_laboratorioencuesta.valor', 'true')->get();

        $opcionesEncuesta = [];

        foreach ($laboratrios as $laboratorio) {
            $opcionesEncuesta[] = [
                'tipoencuesta_id' => $laboratorio->tipoencuesta_id,
                'nombre'          => $laboratorio->nombre,
                'valor'           => $laboratorio->valor,
                'id'              => $laboratorio->id,
                'tipo'            => $laboratorio->tipo,
                'id_evento'       => $laboratorio->id_evento,
            ];
        }

        return response()->json(['laboratorios' => $opcionesEncuesta]);
        //return view('gestion_documental.finish_gestion', compact('data'));

    }
    /* TRAE LOS TIPOS DE LABORATORIO QUE ESTAN ASOCIADOS A ESE EVENTO */


    /* TRAE LA VISTA PARA VISUALIZAR LAS ENCUESTAS ENLAZADAS A ESE LABORATORIO CON SU TIPO */
    public function usuEncuesta(Request $request){

        $tipoencu_id = $request->query('tipoencu_id');
        $id_evento   = $request->query('id_evento');

        $data = DB::table('db_inspi_encuesta.enc_laboratorioencuesta AS el')
                ->select('el.laboratorio_id', 'l.area_id', 't.nombre', 't.id', 'l.descripcion')
                ->leftJoin('db_inspi_encuesta.enc_laboratorio AS l', 'el.laboratorio_id', '=', 'l.id')
                ->leftJoin('db_inspi_encuesta.enc_tipoencuesta AS t', 'el.tipoencuesta_id', '=', 't.id')
                ->where('el.id', $tipoencu_id)
                ->get();

        $laboratorio_name = $data[0]->descripcion;
        $tipo_name        = $data[0]->nombre;

        return view('evaluacion_encuesta.usuEncuesta',compact('tipoencu_id', 'tipo_name', 'laboratorio_name', 'id_evento'));

    }
    /* TRAE LA VISTA PARA VISUALIZAR LAS ENCUESTAS ENLAZADAS A ESE LABORATORIO CON SU TIPO */

    
    public function getEncuestas(Request $request) {
        if($request->ajax()) {
            $tipoencu_id = $request->query('tipoencu_id');
            $id_evento   = $request->query('id_evento');
    
            $dataEncuesta = DB::table('db_inspi_encuesta.enc_laboratorioencuesta AS el')
                ->select('t.id', 't.servidor_publico', 't.nombre', DB::raw('IF(u.name IS NULL OR u.name = "", t.name_unidad, u.name) as usuario'), 't.created_at as fecha')
                ->leftJoin('db_inspi_encuesta.enc_laboratorioresp AS l1', 'el.laboratorio_id', '=', 'l1.id_laboratorio')
                ->leftJoin('db_inspi_encuesta.enc_encuesta_user AS t', 'l1.id_encuestausuario', '=', 't.id')
                ->leftJoin('db_inspi.users AS u', 'u.id', '=', 't.id_usuario')
                ->where('el.id', $tipoencu_id)
                ->where('t.id_evento', $id_evento)
                ->where('t.estado', 'A')
                //->where('el.tipoencuesta_id', '=', 'l1.id_tipoEncuesta')
                ->where('el.tipoencuesta_id', '=', DB::raw('l1.id_tipoEncuesta'))
                ->get();
    
            return datatables()->of($dataEncuesta)->addIndexColumn()->make(true);
        }
    }




    /* TRAE LOS DATOS PARA LOS GRAFICOS DE EVALUACION DE ENCUESTAS */
    public function getEncuestasTotales(Request $request) {

        $tipoencu_id = $request->query('tipoencu_id');
        $id_evento   = $request->query('id_evento');

        $dataEncuesta = DB::table('db_inspi_encuesta.enc_laboratorioencuesta AS el')
            ->select('t.id as id', 't.id_encuesta', 't.nombre', 't.id_usuario', 'el.laboratorio_id', 't.comentario', 'usu.name', 'usu.hospital')
            ->leftJoin('db_inspi_encuesta.enc_laboratorioresp AS l1', 'el.laboratorio_id', '=', 'l1.id_laboratorio')
            ->leftJoin('db_inspi_encuesta.enc_encuesta_user AS t', 'l1.id_encuestausuario', '=', 't.id')
            ->leftJoin('db_inspi.users AS usu', 'usu.id', '=', 't.id_usuario')
            ->where('el.id', $tipoencu_id)
            ->where('t.id_evento', $id_evento)
            ->where('t.estado', 'A')
            //->where('el.tipoencuesta_id', '=', 'l1.id_tipoEncuesta')
            ->where('el.tipoencuesta_id', '=', DB::raw('l1.id_tipoEncuesta'))
            ->get();

        $totalEncuestas = $dataEncuesta->count(); //total de usuarios encuestados

        $resultadosAgrupados = [];

        foreach ($dataEncuesta as $encuesta) {

            $dataEncuestaUsuario = DB::table('db_inspi_encuesta.enc_encuesta_user as encU')
                ->select('opcU.id', 'opcU.pregunta_id', 'opcU.nombre', 'opcU.respuesta', 'opcU.id_opcion_enc', 'opcU.id_pregun_enc', 'preU.pregunta')
                ->leftJoin('db_inspi_encuesta.enc_encuesta AS enc', 'enc.id', '=', 'encU.id_encuesta')
                ->leftJoin('db_inspi_encuesta.enc_preguntas_user AS preU', 'preU.encuesta_id', '=', 'encU.id')
                ->leftJoin('db_inspi_encuesta.enc_opciones_user AS opcU', 'opcU.pregunta_id', '=', 'preU.id')
                ->where('encU.id', $encuesta->id)
                ->get();


                foreach ($dataEncuestaUsuario as $opciones) {


                    // Obtenemos las claves necesarias
                    $idPregunta = $opciones->id_pregun_enc;
                    $idOpcion   = $opciones->id_opcion_enc;
                    $preName    = $opciones->pregunta;
                    $respuesta  = $opciones->respuesta;
                    $nombre     = $opciones->nombre;

        
                    // Si la clave de la pregunta no existe en el arreglo agrupado, la inicializamos
                    if (!isset($resultadosAgrupados[$idPregunta])) {
                        $resultadosAgrupados[$idPregunta] = [];
                        $resultadosAgrupados[$idPregunta]['nombre']     = $preName;
                        $resultadosAgrupados[$idPregunta]['idPregunta'] = $idPregunta;
                    }
        
                    // Si la clave de la opciÃ³n no existe en el arreglo agrupado para la pregunta actual, la inicializamos
                    if (!isset($resultadosAgrupados[$idPregunta]['opciones'][$idOpcion])) {
                        $resultadosAgrupados[$idPregunta]['opciones'][$idOpcion] = 0;
                        $resultadosAgrupados[$idPregunta]['nombres'][$idOpcion] = $nombre;
                    }
        
                    // Incrementamos el contador si la respuesta es true
                    if ($respuesta === 'true') {
                        $resultadosAgrupados[$idPregunta]['opciones'][$idOpcion]++;
                    }

                }


        }
    
        return response()->json(
            ['message'            => 'Encuesta guardada exitosamente', 
             'data'               => $dataEncuesta, 
             'totalEncuestas'     => $totalEncuestas, 
             'dataEncuestaUsuario'=> $dataEncuestaUsuario,
             'resultadosAgrupados'=> $resultadosAgrupados,
            ], 200);

    }
    /* TRAE LOS DATOS PARA LOS GRAFICOS DE EVALUACION DE ENCUESTAS */

    

    /* ENVIA NOTIFICACION A LOS USUARIOS PERTENECIENTES AL EVENTO */
    public function eventoCorreo($id_evento){

        $usuarios = DB::table('db_inspi_encuesta.enc_evento as eve')
            ->join('db_inspi_encuesta.enc_usuariolaboratorio as evl', 'eve.laboratorio_id', '=', 'evl.laboratorio_id')
            ->join('db_inspi.users as usu', 'usu.id', '=', 'evl.usuario_id')
            ->select('usu.name', 'usu.email')
            ->where('eve.id', $id_evento)
            ->get();

        $evento = DB::table('db_inspi_encuesta.enc_evento as eve')
            ->join('db_inspi_encuesta.enc_laboratorio as evl', 'eve.laboratorio_id', '=', 'evl.id')
            ->join('db_inspi_encuesta.enc_periodo as per', 'eve.periodo', '=', 'per.id')
            ->select('eve.nombre as nombre', 'eve.anio', 'evl.descripcion as laboratorio', 'per.nombre as periodo')
            ->where('eve.id', $id_evento)
            ->first();

        $nombreEvento  = $evento->nombre;
        $anioEvento    = $evento->anio;
        $descripLabor  = $evento->laboratorio;
        $nombrePeriodo = $evento->periodo;

            //laboratorio_id   periodo  anio

        $primerRegistro = true;

        foreach ($usuarios as $usuarios) {

            $correo = new UsuarioEvento($nombreEvento, $anioEvento, $descripLabor, $nombrePeriodo);
            if($primerRegistro){
                $correo->to($usuarios->email);
                $primerRegistro = false;
            }else{
                $correo->cc($usuarios->email);
            }
            
            try {

                Mail::send($correo);
                return response()->json(['message' => 'Notificación enviada', 'data' => true], 200);

            } catch (\Exception $e) {

                return response()->json(['message' => 'Error al enviar la notificación', 'data' => false], 200);

            }

        }

    }
    /* ENVIA NOTIFICACION A LOS USUARIOS PERTENECIENTES AL EVENTO */




/* ======================================== FUNCIONES DEL USUARIO ======================================== */

    public function homeUsuario(Request $request){

        $id_usuario = Auth::user()->id; //TRAE EL ID_USUARIO

        $eventos = DB::table('db_inspi_encuesta.enc_evento_laboratorio as evelab')
            ->select('evelab.id_evento')
            ->whereIn('evelab.id_labencuesta', function ($query) use ($id_usuario) {
                $query->select('elab.id')
                    ->from('db_inspi_encuesta.enc_laboratorioencuesta as elab')
                    ->whereIn('elab.laboratorio_id', function ($subquery) use ($id_usuario) {
                        $subquery->select('ulab.laboratorio_id')
                            ->from('db_inspi_encuesta.enc_usuariolaboratorio as ulab')
                            ->where('ulab.usuario_id', $id_usuario)
                            ->where('ulab.estado', 'A');
                    })
                    ->where('elab.valor', 'TRUE');
            })
            ->distinct()
            ->get();


        $eventosArray = [];

        foreach ($eventos as $evento) {

            $datosEnventos = Evento::select('enc_evento.nombre', 'enc_evento.id', 'enc_evento.laboratorio_id', 'per.nombre as periodo', 'enc_evento.anio')
            ->join('db_inspi_encuesta.enc_periodo as per', 'per.id', '=', 'db_inspi_encuesta.enc_evento.periodo')
            ->where('enc_evento.estado', 'A')
            ->where('enc_evento.id', $evento->id_evento)->get();

            $encuestasArray = [];

            foreach ($datosEnventos as $datosEnvento) {

                $datosEncuestas = UsuarioLaboratorio::select('lab.descripcion as name', 'enc_usuariolaboratorio.laboratorio_id', 'enc_usuariolaboratorio.tipoencuesta_id',
                'enc_usuariolaboratorio.id', 'enc_usuariolaboratorio.usuario_id')
                ->join('db_inspi_encuesta.enc_laboratorio as lab', 'lab.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
                ->join('db_inspi_encuesta.enc_evento as eve', 'eve.laboratorio_id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
                ->where('lab.estado', 'A')
                ->where('eve.id', $datosEnvento->id)
                ->where('enc_usuariolaboratorio.estado', 'A')
                ->where('enc_usuariolaboratorio.usuario_id', $id_usuario)->get();

                $encueRealizada = EncuestaUser::where('id_usuario', $id_usuario)->where('id_evento', $datosEnvento->id)->get();
                if($encueRealizada->count() >= 1){
                    $realizado = 'true';
                }else{
                    $realizado = 'false';
                }

                foreach ($datosEncuestas as $datosEncuesta) {

                    $encuestasArray[] = [
                        'name'            => $datosEncuesta->name,
                        'tipoencuesta_id' => $datosEncuesta->tipoencuesta_id,
                        'laboratorio_id'  => $datosEncuesta->laboratorio_id,
                        'id'              => $datosEncuesta->id,
                        'usuario_id'      => $datosEncuesta->usuario_id,
                        'realizado'       => $realizado,
                    ];

                }

            }

            $eventosArray[] = [
                'id'             => $datosEnvento->id,
                'nombre'         => $datosEnvento->nombre,
                'laboratorio_id' => $datosEnvento->laboratorio_id,
                'periodo'        => $datosEnvento->periodo,
                'anio'           => $datosEnvento->anio,
                'encuetas'       => $encuestasArray,
            ];

        }


        $encuestas = UsuarioLaboratorio::select('lab.descripcion as name', 'enc_usuariolaboratorio.laboratorio_id', 'enc_usuariolaboratorio.tipoencuesta_id',
            'enc_usuariolaboratorio.id', 'enc_usuariolaboratorio.usuario_id')
            ->join('db_inspi_encuesta.enc_laboratorio as lab', 'lab.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->where('lab.estado', 'A')
            ->where('enc_usuariolaboratorio.usuario_id', $id_usuario)->get();


        if(request()->ajax()) {

            return datatables()->of($evento = Evento::select('lab.descripcion as laboratorio_id', 'enc_evento.id', 'enc_evento.nombre',
                            'enc_evento.fechaDesde', 'enc_evento.fechaHasta', 'enc_evento.estado', 'enc_evento.created_at', 'enc_evento.updated_at')
                            ->join('db_inspi_encuesta.enc_laboratorio as lab', 'lab.id', '=', 'db_inspi_encuesta.enc_evento.laboratorio_id')
                            ->where('enc_evento.estado', 'A'))
            ->addIndexColumn()
            ->make(true);

        }

        //respuesta para la vista
        return view('evaluacion_encuesta.homeUsuario', compact('encuestas', 'eventosArray'));
    }



    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO PRESENCIAL */
    public function doEncuesta(Request $request){

        $tipoencu_id = $request->query('tipousu_id');
        $id_evento   = $request->query('id_evento');

        $servicios = Servicios::where('estado', 'A')->get();

        //traer la encuesta, preguntas y opciones
        $usuLab = UsuarioLaboratorio::select('enc_usuariolaboratorio.laboratorio_id', 'enc_usuariolaboratorio.tipoencuesta_id', 'enc_usuariolaboratorio.usuario_id',
            'enc_usuariolaboratorio.id', 'tip.encuesta_id')
            ->join('enc_tipoencuesta as tip', 'tip.id', '=', 'enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_usuariolaboratorio.id', $tipoencu_id)->get();
        $encuestaArray = [];

        foreach ($usuLab as $usuLabo) {

            //se obtiene la encuesta
            $encuestas = Encuesta::select('enc_encuesta.nombre','enc_encuesta.descripcion', 'enc_encuesta.id', 'tip.tipo')
            ->join('enc_tipoencuesta as tip', 'tip.encuesta_id', '=', 'enc_encuesta.id')
            ->where('enc_encuesta.estado', 'A')
            ->where('enc_encuesta.id', $usuLabo->encuesta_id)->get();

            foreach ($encuestas as $encuesta) {

                $preguntasArray = [];

                //traemos las preguntas de esa encuesta
                $preguntas = Preguntas::select('id','pregunta as nombre', 'tipo_respuesta as numeroPre', 'abrindada')
                ->where('estado', 'A')
                ->where('encuesta_id', $usuLabo->encuesta_id)->get();

                foreach ($preguntas as $pregunta) {

                    $opcionesArray  = [];

                    //traemos las opciones de la pregunta
                    $opciones = Opciones::select('id','nombre')
                    ->where('estado', 'A')
                    ->where('pregunta_id', $pregunta->id)->get();

                    foreach ($opciones as $opcion) {

                        $opcionesArray[] = [
                            'id'     => $opcion->id,
                            'nombre' => $opcion->nombre,
                        ];

                    }

                    $preguntasArray[] = [
                        'id'        => $pregunta->id,
                        'nombre'    => $pregunta->nombre,
                        'numeroPre' => $pregunta->numeroPre,
                        'opciones'  => $opcionesArray,
                        'abrindada' => $pregunta->abrindada,
                    ];

                }

                $encuestaArray[] = [
                    'id'          => $encuesta->id,
                    'nombre'      => $encuesta->nombre,
                    'descripcion' => $encuesta->descripcion,
                    'preguntas'   => $preguntasArray,
                ];

                $tipo = $encuesta->tipo;

            }
            $tipoencuesta_id = $usuLabo->tipoencuesta_id;
            $laboratorio_id = $usuLabo->laboratorio_id;
        }

        return view('evaluacion_encuesta.doEncuesta',compact('encuestaArray', 'tipo', 'tipoencuesta_id', 'laboratorio_id', 'id_evento', 'servicios'));

    }
    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO PRESENCIAL */


    /* TRAE LA VISTA DE ENCUESTA TERMINADA */
    public function finishEncuesta(Request $request){

        $tipoencu_id = $request->query('tipousu_id');
        $id_evento   = $request->query('id_evento');

        $servicios = Servicios::where('estado', 'A')->get();

        //traer la encuesta, preguntas y opciones
        $usuLab = UsuarioLaboratorio::select('enc_usuariolaboratorio.laboratorio_id', 'enc_usuariolaboratorio.tipoencuesta_id', 'enc_usuariolaboratorio.usuario_id',
            'enc_usuariolaboratorio.id', 'tip.encuesta_id')
            ->join('enc_tipoencuesta as tip', 'tip.id', '=', 'enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_usuariolaboratorio.id', $tipoencu_id)->get();
        $encuestaArray = [];

        foreach ($usuLab as $usuLabo) {

            //se obtiene la encuesta
            $encuestas = Encuesta::select('enc_encuesta.nombre','enc_encuesta.descripcion', 'enc_encuesta.id', 'tip.tipo')
            ->join('enc_tipoencuesta as tip', 'tip.encuesta_id', '=', 'enc_encuesta.id')
            ->where('enc_encuesta.estado', 'A')
            ->where('enc_encuesta.id', $usuLabo->encuesta_id)->get();

            foreach ($encuestas as $encuesta) {

                $preguntasArray = [];

                //traemos las preguntas de esa encuesta
                $preguntas = Preguntas::select('id','pregunta as nombre', 'tipo_respuesta as numeroPre', 'abrindada')
                ->where('estado', 'A')
                ->where('encuesta_id', $usuLabo->encuesta_id)->get();

                foreach ($preguntas as $pregunta) {

                    $opcionesArray  = [];

                    //traemos las opciones de la pregunta
                    $opciones = Opciones::select('id','nombre')
                    ->where('estado', 'A')
                    ->where('pregunta_id', $pregunta->id)->get();

                    foreach ($opciones as $opcion) {

                        $opcionesArray[] = [
                            'id'     => $opcion->id,
                            'nombre' => $opcion->nombre,
                        ];

                    }

                    $preguntasArray[] = [
                        'id'        => $pregunta->id,
                        'nombre'    => $pregunta->nombre,
                        'numeroPre' => $pregunta->numeroPre,
                        'opciones'  => $opcionesArray,
                        'abrindada' => $pregunta->abrindada,
                    ];

                }

                $encuestaArray[] = [
                    'id'          => $encuesta->id,
                    'nombre'      => $encuesta->nombre,
                    'descripcion' => $encuesta->descripcion,
                    'preguntas'   => $preguntasArray,
                ];

                $tipo = $encuesta->tipo;

            }
            $tipoencuesta_id = $usuLabo->tipoencuesta_id;
            $laboratorio_id = $usuLabo->laboratorio_id;
        }

        return view('evaluacion_encuesta.finishEncuesta',compact('encuestaArray', 'tipo', 'tipoencuesta_id', 'laboratorio_id', 'id_evento', 'servicios'));

    }
    /* TRAE LA VISTA DE ENCUESTA TERMINADA */



    /* GUARDAR ENCUESTA DEL USUARIO */
    public function saveUser(Request $request){

        $id_usuario = Auth::user()->id;

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombreEncuesta'  => 'required|string',
            'idEncuesta'      => 'required|string',
            'descripcion'     => 'required|string',
            'fechaUser'       => 'required|string',
            'servicioName'    => 'required|string',

            'areaName'        => 'required|string',
            'ciudad'          => 'required|string',
            'comentarios'     => 'required|string',
            'servidor_publico'=> 'nullable|string',
            'motivo_califica' => 'nullable|string',
            'arrayEncuesta'   => 'required|array',

            'tipoencuesta_id' => 'required|string',
            'laboratorio_id'  => 'required|string',

            'id_evento'       =>  'required|string',
        ]);

        //recorrer el arreglor 
        //crear encuesta 
        $encuesta = EncuestaUser::create([
            'id_encuesta' => $request->idEncuesta,
            'id_usuario'  => $id_usuario,
            'nombre'      => $request->nombreEncuesta,
            'descripcion' => $request->descripcion,
            'comentario'  => $request->comentarios,
            'ciudad'      => $request->ciudad,
            'id_area'     => $request->areaName,
            'servicio'    => $request->servicioName,
            'servidor_publico' => $request->servidor_publico,
            'motivo_califica'  => $request->motivo_califica,
            'id_evento'   => $request->id_evento,
            'estado'      => 'A',
        ]);


        if ($encuesta) {

            $laboraResp = LaboratorioResp::create([
                'id_encuestausuario' => $encuesta->id,
                'id_tipoEncuesta'    => $request->tipoencuesta_id,
                'id_laboratorio'     => $request->laboratorio_id,
                'estado'             => 'A',
            ]);

            $preguntas = $request->arrayEncuesta;

            foreach ($preguntas as $pregunta) {

                // Crear preguntas para la encuesta reciÃ©n creada
                $preguntaReq = PreguntasUser::create([
                    'encuesta_id'    => $encuesta->id,
                    'pregunta'       => $pregunta['nombre'],
                    'tipo_respuesta' => '',
                ]);

                //se agregan las opciones
                foreach ($pregunta['opciones'] as $opciones) {

                    $opciones = OpcionesUser::create([
                        'pregunta_id'   => $preguntaReq->id,
                        'nombre'        => $opciones['nombre'],
                        'respuesta'     => $opciones['resp'],
                        'id_opcion_enc' => $opciones['id'],
                        'id_pregun_enc' => $opciones['pregunta_id'],
                    ]);

                }

            }

            return response()->json(['message' => 'Encuesta guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al guardar la encuesta', 'data' => false], 200);

        }

    }
    /* GUARDAR ENCUESTA DEL USUARIO */


/* ======================================== FUNCIONES DEL USUARIO ======================================== */






/* ======================================== REPORTE DE ENCUESTA NO PRESENCIAL ======================================== */

    public function reportNoPresencial(Request $request)
    {
        $id_encuesta  = $request->query('id_encuesta');

        //se obtiene la encuesta
        $encuestas = EncuestaUser::select(
            'db_inspi_encuesta.enc_encuesta_user.nombre',
            'db_inspi_encuesta.enc_encuesta_user.descripcion', 
            'db_inspi_encuesta.enc_encuesta_user.id as id', 
            'db_inspi_encuesta.tip.tipo', 
            'users.name', 
            'db_inspi_encuesta.enc_encuesta_user.created_at as fecha',
            //'ser.nombre as servicio', 
            'db_inspi_encuesta.enc_encuesta_user.id_area as nombreArea', 
            'db_inspi_encuesta.enc_encuesta_user.ciudad',
            'db_inspi_encuesta.enc_encuesta_user.servidor_publico', 
            'db_inspi_encuesta.enc_encuesta_user.comentario', 
            'db_inspi_encuesta.enc_encuesta_user.motivo_califica',
            'db_inspi_encuesta.enc_encuesta_user.name_unidad'
        )
        ->join('db_inspi_encuesta.enc_tipoencuesta as tip', 'tip.encuesta_id', '=', 'db_inspi_encuesta.enc_encuesta_user.id_encuesta')
        ->leftJoin('db_inspi.users', function($join) {
            $join->on('db_inspi.users.id', '=', 'db_inspi_encuesta.enc_encuesta_user.id_usuario')
                 ->where('db_inspi.users.id', '<>', 0);
        })
        //->join('db_inspi_encuesta.enc_servicios as ser', 'ser.id', '=', 'db_inspi_encuesta.enc_encuesta_user.servicio')
        //->join('db_inspi.inspi_area as are', 'are.id', '=', 'db_inspi_encuesta.enc_encuesta_user.id_area')
        ->where('db_inspi_encuesta.enc_encuesta_user.estado', 'A')
        ->where('db_inspi_encuesta.enc_encuesta_user.id', $id_encuesta)
        ->first();
    
        $preguntasArray = [];
 
        //traemos las preguntas de esa encuesta
        $preguntas = PreguntasUser::select('id','pregunta as nombre', 'tipo_respuesta as numeroPre')
        ->where('estado', 'A')
        ->where('encuesta_id', $encuestas->id)->get();

        foreach ($preguntas as $pregunta) {

            $opcionesArray  = [];

            //traemos las opciones de la pregunta
            $opciones = OpcionesUser::select('id','nombre', 'respuesta')
            ->where('estado', 'A')
            ->where('pregunta_id', $pregunta->id)->get();

            foreach ($opciones as $opcion) {

                $opcionesArray[] = [
                    'id'        => $opcion->id,
                    'nombre'    => $opcion->nombre,
                    'respuesta' => $opcion->respuesta,
                ];

            }

            $preguntasArray[] = [
                'id'        => $pregunta->id,
                'nombre'    => $pregunta->nombre,
                'numeroPre' => $pregunta->numeroPre,
                'opciones'  => $opcionesArray,
                //'abrindada' => $pregunta->abrindada,
            ];

        }

        $pdf = \PDF::loadView('pdf.pdfnopresencial', ['encuestas' => $encuestas, 'preguntas' => $preguntasArray]);
        return $pdf->download('reporte_encuesta.pdf');

    }

/* ======================================== REPORTE DE ENCUESTA NO PRESENCIAL ======================================== */







    /* MOVER USUARIO EXTERNO NO PRESENCIAL */
    function moveUsuarioNopre(Request $request){

        $data = $request->validate([
            'usuario_id'     => 'required|string',
            'laboratorio_id' => 'required|string',
            'id_labusu'      => 'required|string', 
        ]);

        $usuarioEnc = User::findOrFail($request->usuario_id); // Encuentra el usuario por su ID
        $usuarioEnc->estado = 'A';
        $usuarioEnc->save();

        $usuarioEnc = UsuarioLaboratorio::where('id', $request->id_labusu)->first();
        $usuarioEnc->estado = 'A';
        $usuarioEnc->save();

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 
            'enc_usuariolaboratorio.id as id_labusu', 'enc_usuariolaboratorio.estado', 'users.email as correo', 'users.hospital as hospital')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'NP')
            /*->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')*/
            ->get();

        if ($usuarioEnc) {

            return response()->json(['message' => 'Se movio el usuario con exito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

        }else {

            return response()->json(['message' => 'Error al mover el usuario', 'data' => false], 500);

        }

    }
    /* MOVER USUARIO EXTERNO NO PRESENCIAL */





    /* EDITAR USUARIO EXTERNO NO PRESENCIAL */
    function editUsuario_nopre(Request $request){

        $id_usuario     = $request->query('id_usuario');
        $id_laboratorio = $request->query('id_laboratorio');
        $id_lab_usu     = $request->query('id_lab_usu');

        $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 
            'enc_usuariolaboratorio.id as id_labusu', 'enc_usuariolaboratorio.estado', 'users.email as correo', 'users.hospital as hospital')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $id_laboratorio)
            ->where('enc_tipoencuesta.tipo', '=', 'NP')
            /*->where('enc_usuariolaboratorio.estado', '=', 'A')*/
            ->where('users.id', '=', $id_usuario)
            ->first();

        if ($usuariosLab) {

            return response()->json(['message' => 'Se cargaron los datos del usuario con exito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

        }else {

            return response()->json(['message' => 'Error al cargar los datos del usuario', 'data' => false], 500);

        }

    }
    /* EDITAR USUARIO EXTERNO NO PRESENCIAL */



    /* ACTUALIZAR USUARIO EXTERNO NO PRESENCIAL */
    public function saveEditUsuarioNopre(Request $request)
    {

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombreUser'      => 'required|string',
            'apellidoUser'    => 'required|string',
            'correoUser'      => 'required|string',
            'hospitalUser'    => 'required|string',
            'laboratorio_id'  => 'required|string',
            'tipoencuesta_id' => 'required|string',
            'id_usuario'      => 'required|string'
        ]);

        $usuarioEnc = User::findOrFail($request->id_usuario); 
        $usuarioEnc->name = $request->nombreUser.' '.$request->apellidoUser;
        $usuarioEnc->email = $request->correoUser;
        $usuarioEnc->hospital = $request->hospitalUser;

        $usuarioEnc->save();

        if($usuarioEnc){

            $usuariosLab = User::select('users.name as nombre', 'users.nom_user as apellido', 'users.id as id', 'enc_laboratorio.id as laboratorio_id', 
            'enc_usuariolaboratorio.id as id_labusu', 'enc_usuariolaboratorio.estado', 'users.email as correo', 'users.hospital as hospital')
            ->leftJoin('db_inspi_encuesta.enc_usuariolaboratorio', 'enc_usuariolaboratorio.usuario_id', '=', 'db_inspi.users.id')
            ->leftJoin('db_inspi_encuesta.enc_laboratorio', 'enc_laboratorio.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta', 'enc_tipoencuesta.id', '=', 'db_inspi_encuesta.enc_usuariolaboratorio.tipoencuesta_id')
            ->where('enc_laboratorio.id', '=', $request->laboratorio_id)
            ->where('enc_tipoencuesta.tipo', '=', 'NP')
            /*->where('enc_usuariolaboratorio.estado', '=', 'A')
            ->where('users.estado', '=', 'A')*/->get();

            return response()->json(['message' => 'Usuario actualizado con Éxito', 'data' => true, 'usuariosLab' => $usuariosLab], 200);

        }else {

            return response()->json(['message' => 'Error al actualizar el usuario', 'data' => false], 500);

        }

    }
    /* ACTUALIZAR USUARIO EXTERNO NO PRESENCIAL */




    /* DEVUELVE LOS LINKS DEL EVENTO SELECCIONADO */
    public function obtenerLink($id){

        $urls = [];

        $links = Evento::select('enc_evento.id as id_evento', 'te.tipoencuesta_id as tipousu_id', 't_enc.nombre')
            ->leftJoin('db_inspi_encuesta.enc_laboratorioencuesta AS te', 'te.laboratorio_id', '=', 'enc_evento.laboratorio_id')
            ->leftJoin('db_inspi_encuesta.enc_tipoencuesta AS t_enc', 't_enc.id', '=', 'te.tipoencuesta_id')
            ->where('enc_evento.id', $id)->orderBy('te.tipoencuesta_id', 'asc')->get();

        foreach ($links as $link) {
            $data = [
                'id_evento' => $link->id_evento,
                'tipousu_id' => $link->tipousu_id,
            ];
        
            // Encriptar el array
            $encryptedData = Crypt::encrypt(json_encode($data));
        
            // Aquí podrías generar la URL con el dato encriptado
            $url = route('encuesta.doEncuestaSatisfaccion', ['id_url' => $encryptedData]);
        
            // Ahora $url contiene la URL con los valores encriptados
            $urls[] = [
                'url' => $url,
                'nombre' => $link->nombre,
                'id_evento' => $link->id_evento,
                'tipousu_id' => $link->tipousu_id,
            ];
        }

        return response()->json(['message' => 'El Ajax se ejecuto correctamente.', 'data' => true, 'links' => $urls], 200);

    }
    /* DEVUELVE LOS LINKS DEL EVENTO SELECCIONADO */
    



    /* GENERAR VALORES UNICOS */
    public function generateUniqueLink()
    {
        do {
            // Genera una cadena aleatoria de 20 caracteres
            $randomLink = Str::random(20);
        } while (Evento::where('link', $randomLink)->exists());

        return $randomLink;
    }
    /* GENERAR VALORES UNICOS */




    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO PRESENCIAL */
    public function doEncuestaSatisfaccion($id_url){


        try {
            // Desencriptar el ID
            $decryptedData = Crypt::decrypt($id_url);
            
            // Convertir el JSON a un array
            $data = json_decode($decryptedData, true);
    
            // Ahora puedes acceder a tus valores desencriptados
            $id_evento = $data['id_evento'];
            $tipo_encuesta = $data['tipousu_id'];
    
            $datosEvento = Evento::select('enc_evento.laboratorio_id', 'enc_evento.id', 'enc_evento.nombre as periodo', 'enc_evento.anio',)
                ->join('enc_periodo as per', 'per.id', '=', 'enc_evento.periodo')
                ->where('enc_evento.estado', 'A')
                ->where('enc_evento.id', $id_evento)->first();

            $servicios = Servicios::where('estado', 'A')->get();

            //traer la encuesta, preguntas y opciones
            $datos = TipoEncuesta::select('enc_tipoencuesta.encuesta_id', 'enc_tipoencuesta.id')
                ->where('enc_tipoencuesta.id', $tipo_encuesta)->first();

            $encuestaArray = [];
    
            //foreach ($usuLab as $usuLabo) {
    
                //se obtiene la encuesta
                $encuestas = Encuesta::select('enc_encuesta.nombre','enc_encuesta.descripcion', 'enc_encuesta.id', 'tip.tipo')
                ->join('enc_tipoencuesta as tip', 'tip.encuesta_id', '=', 'enc_encuesta.id')
                ->where('enc_encuesta.estado', 'A')
                ->where('tip.tipo', '!=', 'I')
                ->where('enc_encuesta.id', $datos->encuesta_id)->first();
    
                //foreach ($encuestas as $encuesta) {
    
                    $preguntasArray = [];
    
                    //traemos las preguntas de esa encuesta
                    $preguntas = Preguntas::select('id','pregunta as nombre', 'tipo_respuesta as numeroPre', 'abrindada')
                    ->where('estado', 'A')
                    ->where('encuesta_id', $datos->encuesta_id)->get();
    
                    foreach ($preguntas as $pregunta) {
    
                        $opcionesArray  = [];
    
                        //traemos las opciones de la pregunta
                        $opciones = Opciones::select('id','nombre')
                        ->where('estado', 'A')
                        ->where('pregunta_id', $pregunta->id)->get();
    
                        foreach ($opciones as $opcion) {
    
                            $opcionesArray[] = [
                                'id'     => $opcion->id,
                                'nombre' => $opcion->nombre,
                            ];
    
                        }
    
                        $preguntasArray[] = [
                            'id'        => $pregunta->id,
                            'nombre'    => $pregunta->nombre,
                            'numeroPre' => $pregunta->numeroPre,
                            'opciones'  => $opcionesArray,
                            'abrindada' => $pregunta->abrindada,
                        ];
    
                    }
    
                    $encuestaArray[] = [
                        'id'          => $encuestas->id,
                        'nombre'      => $encuestas->nombre,
                        'descripcion' => $encuestas->descripcion,
                        'preguntas'   => $preguntasArray,
                    ];
    
                    $tipo = $encuestas->tipo;
    
                //}
                $tipoencuesta_id = $datos->id;
                $laboratorio_id = $datosEvento->laboratorio_id;
            //}

            $valor = true;

            $datos_lab = Area::select('inspi_area.nombre as nom_area', 'cz.nombre as nom_zonal', 'lab.descripcion as nom_lab', 'lab.area_id as id_area')
                ->join('db_inspi_encuesta.enc_laboratorio as lab', 'lab.area_id', '=', 'inspi_area.id')
                ->join('inspi_czonal as cz', 'cz.id', '=', 'inspi_area.czonal_id')
                ->where('lab.estado', '=', 'A')->where('lab.id', '=', $laboratorio_id)->first();
                    
            $zonales = Czonal::where('estado', '=', 'A')->get();
    
            return view('evaluacion_encuesta.doEncuestaSatisfaccion',compact('encuestaArray', 'tipo', 'tipoencuesta_id', 'laboratorio_id', 
                'id_evento', 'servicios', 'valor', 'zonales', 'datos_lab', 'datosEvento'));
    
        } catch (\Exception $e) {

            $valor   = false;
            $message = 'Error al desencriptar el valor';
            $error   = $e->getMessage();

            return view('evaluacion_encuesta.doEncuestaSatisfaccion',compact('valor', 'message', 'error'));
            //return response()->json(['message' => 'Error al desencriptar el valor', 'error' => $e->getMessage()], 500);
        }


    }
    /* TRAE LA VISTA PARA CREAR USUARIO EXTERNO PRESENCIAL */



    /* GUARDAR ENCUESTA DEL USUARIO EXTERNO MEDIANTE LINK */
    public function guardarEncuesta(Request $request){

        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'nombreEncuesta'  => 'required|string',
            'idEncuesta'      => 'required|string',
            'descripcion'     => 'required|string',
            'fechaUser'       => 'required|string',

            'areaName'        => 'required|string',
            'ciudad'          => 'required|string',
            'comentarios'     => 'required|string',
            'servidor_publico'=> 'nullable|string',
            'motivo_califica' => 'nullable|string',
            'arrayEncuesta'   => 'required|array',

            'tipoencuesta_id' => 'required|string',
            'laboratorio_id'  => 'required|string',

            'id_evento'       =>  'required|string',
            'name_unidad'     =>  'required|string',
        ]);

        //recorrer el arreglor 
        //crear encuesta 
        $encuesta = EncuestaUser::create([
            'id_encuesta' => $request->idEncuesta,
            'id_usuario'  => 0,
            'nombre'      => $request->nombreEncuesta,
            'descripcion' => $request->descripcion,
            'comentario'  => $request->comentarios,
            'ciudad'      => $request->ciudad,
            'name_unidad' => $request->name_unidad,
            'id_area'     => $request->areaName,
            //'servicio'    => $request->servicioName,
            'servidor_publico' => $request->servidor_publico,
            'motivo_califica'  => $request->motivo_califica,
            'id_evento'   => $request->id_evento,
            'estado'      => 'A',
        ]);


        if ($encuesta) {

            //primero se buscan todos los servicios que le pertenezcan a ese laboratorio 
            $servicios = Servicios::where('id_laboratorio', $request->laboratorio_id)->get();
            foreach ($servicios as $servicio) {

                //se insertan todos los servicios a ese laboratorio
                $serviciosEnc = ServiciosEnc::create([
                    'id_servicio' => $servicio->id,
                    'id_encuesta' => $encuesta->id,
                ]);
            
            }


            $laboraResp = LaboratorioResp::create([
                'id_encuestausuario' => $encuesta->id,
                'id_tipoEncuesta'    => $request->tipoencuesta_id,
                'id_laboratorio'     => $request->laboratorio_id,
                'estado'             => 'A',
            ]);

            $preguntas = $request->arrayEncuesta;

            foreach ($preguntas as $pregunta) {

                // Crear preguntas para la encuesta reciÃ©n creada
                $preguntaReq = PreguntasUser::create([
                    'encuesta_id'    => $encuesta->id,
                    'pregunta'       => $pregunta['nombre'],
                    'tipo_respuesta' => '',
                ]);

                //se agregan las opciones
                foreach ($pregunta['opciones'] as $opciones) {

                    $opciones = OpcionesUser::create([
                        'pregunta_id'   => $preguntaReq->id,
                        'nombre'        => $opciones['nombre'],
                        'respuesta'     => $opciones['resp'],
                        'id_opcion_enc' => $opciones['id'],
                        'id_pregun_enc' => $opciones['pregunta_id'],
                    ]);

                }

            }

            return response()->json(['message' => 'Encuesta guardada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al guardar la encuesta', 'data' => false], 200);

        }

    }
    /* GUARDAR ENCUESTA DEL USUARIO EXTERNO MEDIANTE LINK */



    /* VISTA DE ENCUESTA COMPLETADA */
    public function completed()
    {
        return view('evaluacion_encuesta.completed');
    }
    /* VISTA DE ENCUESTA COMPLETADA */



    /* ELIMINAR ENCUESTA HECHA POR LOS USUARIOS */
    public function deleteEncuestaUser(Request $request)
    {
        // Validar y obtener los datos del formulario
        $data = $request->validate([
            'id_encuesta' => 'required|string',
        ]);

        $encuesta = EncuestaUser::find($request->id_encuesta);

        if ($encuesta) {

            $encuesta->update([
                'estado' => 'E',
            ]);

            return response()->json(['message' => 'Encuesta eliminada exitosamente', 'data' => true], 200);

        } else {

            return response()->json(['message' => 'Error al eliminar la Encuesta', 'data' => false], 500);

        }

    }
    /* ELIMINAR ENCUESTA HECHA POR LOS USUARIOS */



    /* ELIMINA LA ENCUESTA POR ID */
    public function eliminarEncuesta($id){

        $encuesta = Encuesta::find($id);

        if($encuesta){
            $encuesta->estado = 'E';
            $encuesta->save();

            return response()->json(['message' => 'Encuesta eliminada exitosamente', 'data' => true], 200);
        }else{
            return response()->json(['message' => 'Error al eliminar la Encuesta', 'data' => false], 500);
        }

    }
    /* ELIMINA LA ENCUESTA POR ID */




    /* TRAER LA VISTA PARA VISUALIZAR LA ENCUESTA */
    public function visualizarEncuesta(Request $request){

        $id_encuesta = $request->query('id_encuesta');
        $id_evento   = 0;

        $servicios = Servicios::where('estado', 'A')->get();

        //se obtiene la encuesta
        $encuesta = Encuesta::select('enc_encuesta.nombre','enc_encuesta.descripcion', 'enc_encuesta.id', 'tip.tipo')
        ->join('enc_tipoencuesta as tip', 'tip.encuesta_id', '=', 'enc_encuesta.id')
        ->where('enc_encuesta.estado', 'A')
        ->where('enc_encuesta.id', $id_encuesta)->first();

        //foreach ($encuestas as $encuesta) {

            $preguntasArray = [];

            //traemos las preguntas de esa encuesta
            $preguntas = Preguntas::select('id','pregunta as nombre', 'tipo_respuesta as numeroPre', 'abrindada')
            ->where('estado', 'A')
            ->where('encuesta_id', $id_encuesta)->get();

            foreach ($preguntas as $pregunta) {

                $opcionesArray  = [];

                //traemos las opciones de la pregunta
                $opciones = Opciones::select('id','nombre')
                ->where('estado', 'A')
                ->where('pregunta_id', $pregunta->id)->get();

                foreach ($opciones as $opcion) {

                    $opcionesArray[] = [
                        'id'     => $opcion->id,
                        'nombre' => $opcion->nombre,
                    ];

                }

                $preguntasArray[] = [
                    'id'        => $pregunta->id,
                    'nombre'    => $pregunta->nombre,
                    'numeroPre' => $pregunta->numeroPre,
                    'opciones'  => $opcionesArray,
                    'abrindada' => $pregunta->abrindada,
                ];

            }

            $encuestaArray[] = [
                'id'          => $encuesta->id,
                'nombre'      => $encuesta->nombre,
                'descripcion' => $encuesta->descripcion,
                'preguntas'   => $preguntasArray,
            ];

            $tipo = $encuesta->tipo;

        //}
        
        $tipoencuesta_id = 0;
        $laboratorio_id = 0;

        return view('evaluacion_encuesta.visualizarEncuesta',compact('encuestaArray', 'tipo', 'tipoencuesta_id', 'laboratorio_id', 'id_evento', 'servicios'));

    }
    /* TRAER LA VISTA PARA VISUALIZAR LA ENCUESTA */


}
