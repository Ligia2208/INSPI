<?php

use App\Http\Controllers\Soporte\Ticketsupport\TicketsupportController;
use App\Http\Controllers\Soporte\Ticketuser\TicketuserController;
use App\Http\Controllers\Soporte\Tecnico\TecnicoController;
use App\Http\Controllers\Soporte\Ticketasignado\TicketasignadoController;
use App\Http\Controllers\Soporte\Ticketurgente\TicketurgenteController;
use App\Http\Controllers\Soporte\Ticketeliminado\TicketeliminadoController;
use App\Http\Controllers\Soporte\Tickettecnico\TickettecnicoController;
use App\Http\Controllers\Soporte\Tickettecnicocerrado\TickettecnicocerradoController;
use App\Http\Controllers\Soporte\Ticketseguimiento\TicketseguimientoController;
use App\Http\Controllers\Soporte\Ticketusertramite\TicketusertramiteController;
use App\Http\Controllers\Soporte\Ticketusercerrado\TicketusercerradoController;



Route::middleware(['auth'])->group(function () {

    //Lista de Tickets Gestión
    Route::resource('ticketsupport', TicketsupportController::class)->parameters(['Tickets' => 'ticket'])->names('ticketsupport');

    //Lista de Tickets Usuario
    Route::resource('ticketuser', TicketuserController::class)->parameters(['Tickets' => 'ticket'])->names('ticketuser');

    //Lista de Tickets Usuario en tramite
    Route::resource('ticketusertramite', TicketusertramiteController::class)->parameters(['Tickets' => 'ticket'])->names('ticketusertramite');

    //Lista de Tickets Usuario cerrados
    Route::resource('ticketusercerrado', TicketusercerradoController::class)->parameters(['Tickets' => 'ticket'])->names('ticketusercerrado');

    //Lista de Técnicos
    Route::resource('tecnicos', TecnicoController::class)->parameters(['Tecnicos' => 'tecnico'])->names('tecnico');

    //Lista de Tickets Asignados
    Route::resource('ticketasignado', TicketasignadoController::class)->parameters(['Tickets' => 'ticket'])->names('ticketasignado');

    //Lista de Tickets Urgentes
    Route::resource('ticketurgente', TicketurgenteController::class)->parameters(['Tickets' => 'ticket'])->names('ticketurgente');

    //Lista de Tickets Eliminados
    Route::resource('ticketeliminado', TicketeliminadoController::class)->parameters(['Tickets' => 'ticket'])->names('ticketeliminado');

    //Lista de Tickets asignados al técnico
    Route::resource('tickettecnico', TickettecnicoController::class)->parameters(['Tickets' => 'ticket'])->names('tickettecnico');

    //Lista de Tickets cerrados asignados al técnico
    Route::resource('tickettecnicocerrado', TickettecnicocerradoController::class)->parameters(['Tickets' => 'ticket'])->names('tickettecnicocerrado');

    //Lista de Seguimiento Tickets asignados al técnico
    Route::resource('ticketseguimiento', TicketseguimientoController::class)->parameters(['Tickets' => 'ticket'])->names('ticketseguimiento');


});

