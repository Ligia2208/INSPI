<?php

use App\Http\Controllers\Intranet\Convenio\ConvenioController;
use App\Http\Controllers\Intranet\Ticket\TicketController;
use App\Http\Controllers\Intranet\AsignaTicket\AsignaTicketController;
use App\Http\Controllers\Intranet\Convenio\EstadisticaConvenioController;
use App\Http\Controllers\Intranet\Evento\EventoController;
use App\Http\Controllers\Intranet\Evidencia\EvidenciaController;
use App\Http\Controllers\Intranet\Revision\RevisionController;
use App\Http\Controllers\Intranet\ReporteEvento\ReporteEventoController;
use App\Http\Controllers\Intranet\Agenda\ActividadController;
use App\Http\Controllers\Intranet\Resolucion\ResolucionController;

Route::middleware(['auth'])->group(function () {

    //Lista de Convenios
    Route::resource('convenios', ConvenioController::class)->parameters(['Convenios' => 'convenio'])->names('convenio');

    //Lista de Resoluciones
    Route::resource('resoluciones', ResolucionController::class)->parameters(['Resoluciones' => 'resolucion'])->names('resolucion');

    //Estadisticas de Convenios
    Route::resource('estadisticas', EstadisticaConvenioController::class)->parameters(['EstadisticasConvenios' => 'estadisticaconvenio'])->names('estadisticaconvenio');

    //Lista de Tickets
    Route::resource('tickets', TicketController::class)->parameters(['Tickets' => 'ticket'])->names('ticket');

    //Lista de Asignaciones de Tickets
    Route::resource('asignatickets', AsignaTicketController::class)->parameters(['AsignaTickets' => 'asignaticket'])->names('asignaticket');

    //Lista de Eventos
    Route::resource('eventos', EventoController::class)->parameters(['Eventos' => 'evento'])->names('evento');

    //Lista de Evidencias
    Route::resource('evidencias', EvidenciaController::class)->parameters(['Evidencias' => 'evidencia'])->names('evidencia');
    Route::get('/evidencias/agregar/{id}', [EvidenciaController::class, 'agregar', 'id'])->name('agregar');

    //Cierre de Eventos
    Route::resource('revisiones', RevisionController::class)->parameters(['Revisiones' => 'revision'])->names('revision');

    //Reportes Evento
    Route::resource('reportesevento', ReporteEventoController::class)->parameters(['reportes' => 'reporte'])->names('reporte');

    Route::get('/actividad', [App\Http\Controllers\Intranet\Agenda\ActividadController::class, 'index']);
    Route::get('/actividad/mostrar', [App\Http\Controllers\Intranet\Agenda\ActividadController::class, 'show']);
    Route::post('/actividad/agregar', [App\Http\Controllers\Intranet\Agenda\ActividadController::class, 'store']);
    Route::post('/actividad/editar/{id}', [App\Http\Controllers\Intranet\Agenda\ActividadController::class, 'edit']);
    Route::post('/actividad/actualizar/{evento}', [App\Http\Controllers\Intranet\Agenda\ActividadController::class, 'update']);
    Route::post('/actividad/borrar/{id}', [App\Http\Controllers\Intranet\Agenda\ActividadController::class, 'destroy']);
});

