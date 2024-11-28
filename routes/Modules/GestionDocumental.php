<?php

use App\Http\Controllers\GestionDocumental\Solicitud\SolicitudController;
use App\Http\Controllers\GestionDocumental\Solicitudenv\SolicitudenvController;
use App\Http\Controllers\GestionDocumental\Solicituddir\SolicituddirController;
use App\Http\Controllers\GestionDocumental\Solicitudcor\SolicitudcorController;
use App\Http\Controllers\GestionDocumental\Solicituddirtec\SolicituddirtecController;
use App\Http\Controllers\GestionDocumental\Solicitudpro\SolicitudproController;
use App\Http\Controllers\GestionDocumental\Seguimiento\SeguimientoController;
use App\Http\Controllers\GestionDocumental\Historico\HistoricoController;
use App\Http\Controllers\GestionDocumental\Reporte\ReporteController;
use App\Http\Controllers\GestionDocumental\Grafico\ChartJSController;


Route::middleware(['auth'])->group(function () {
        
    //Solicitudes Ventanilla Unica
    Route::resource('solicitudes', SolicitudController::class)->parameters(['solicitudes' => 'solicitud'])->names('solicitud');

    //Solicitudes Asignadas Ventanilla Unica
    Route::resource('solicitudesenv', SolicitudenvController::class)->parameters(['solicitudesenv' => 'solicitudenv'])->names('solicitudenv');

    //Solicitudes Direcciones Ventanilla Unica
    Route::resource('solicitudesdir', SolicituddirController::class)->parameters(['solicitudesdir' => 'solicituddir'])->names('solicituddir');

    //Solicitudes Coordinaciones Ventanilla Unica
    Route::resource('solicitudescor', SolicitudcorController::class)->parameters(['solicitudescor' => 'solicitudcor'])->names('solicitudcor');

    //Solicitudes Direcciones Técnicas Ventanilla Unica
    Route::resource('solicitudesdirtec', SolicituddirtecController::class)->parameters(['solicitudesdirtec' => 'solicituddirtec'])->names('solicituddirtec');

    //Solicitudes Final Ventanilla Unica
    Route::resource('solicitudespro', SolicitudproController::class)->parameters(['solicitudespro' => 'solicitudpro'])->names('solicitudpro');

    //Seguimiento Ventanilla Unica
    Route::resource('seguimientos', SeguimientoController::class)->parameters(['seguimientos' => 'seguimiento'])->names('seguimiento');

    //Historicos Ventanilla Unica
    Route::resource('historicos', HistoricoController::class)->parameters(['historicos' => 'historico'])->names('historico');

    //Reportes Ventanilla Unica
    Route::resource('reportesdocumental', ReporteController::class)->parameters(['reportes' => 'reporte'])->names('reporte');

    

});
Route::get('chart-js', [ChartJSController::class, 'index']);

//Setting
Route::prefix('gestiondocumental')->group(function () {
    //Welcome
    Route::get('/', [ReporteController::class, 'index'])->name('gestiondocumental.reporte.index');
    //Permission
    Route::resource('seguimientos', SeguimientoController::class)->parameters(['seguimientos' => 'seguimiento'])->names('gestiondocumental.seguimiento');
    //Permission
    Route::resource('permisos', PermissionController::class)->parameters(['permisos' => 'permission'])->names('setting.permission');
    //Role
    Route::resource('roles', RoleController::class)->parameters(['roles' => 'role'])->names('setting.role');
    
    
});
