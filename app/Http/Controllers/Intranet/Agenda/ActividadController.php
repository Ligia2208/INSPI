<?php

namespace App\Http\Controllers\Intranet\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Actividad;
use Carbon\Carbon;
use Auth;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ActividadController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('intranet.actividad.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Evento::$rules);

        DB::table('eventos')->insert([
            'id_user' => Auth::user()->id,
            'title' => request()->input('title'),
            'descripcion' => request()->input('descripcion'),
            'start' => request()->input('start').' '.request()->input('startH'),
            'end' => request()->input('end').' '.request()->input('endH')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //$evento = Evento::all();
        $evento = DB::table('eventos')->where('id_user','=', Auth::user()->id)->get();
        return response()->json($evento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evento = Evento::find($id);
        $evento->startF=Carbon::createFromFormat('Y-m-d H:i:s', $evento->start)->format('Y-m-d');
        $evento->endF=Carbon::createFromFormat('Y-m-d H:i:s', $evento->end)->format('Y-m-d');
        
        $evento->startH=Carbon::createFromFormat('Y-m-d H:i:s', $evento->start)->format('H:i:s');
        $evento->endH=Carbon::createFromFormat('Y-m-d H:i:s', $evento->end)->format('H:i:s');
        return response()->json($evento);
        //return $evento;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        request()->validate(Evento::$rules);

        DB::table('eventos')
            ->where('id', request()->id)
            ->update([
            'id_user' => Auth::user()->id,
            'title' => request()->input('title'),
            'descripcion' => request()->input('descripcion'),
            'start' => request()->input('start').' '.request()->input('startH'),
            'end' => request()->input('end').' '.request()->input('endH')
        ]);

        return response()->json($evento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::find($id)->delete();
        return response()->json($evento);
    }
}
