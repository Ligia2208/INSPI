<?php

use App\Http\Controllers\Inventario\Articulo\ArticuloController;
use App\Http\Controllers\Inventario\Actausuario\ActausuarioController;
use App\Http\Controllers\Inventario\Participante\ParticipanteController;



Route::middleware(['auth'])->group(function () {
     
    //Contratación Lista de Funcionarios
    Route::resource('actausuarios', ActausuarioController::class)->parameters(['filiaciones' => 'filiacion'])->names('actausuario');
    //Articulos
    Route::resource('articulos', ArticuloController::class)->parameters(['articulos' => 'articulo'])->names('articulo');
    //Participantes
    Route::resource('participantes', ParticipanteController::class)->parameters(['participantes' => 'participante'])->names('participante');
    
    Route::get('/articulos/listado/{id}', [ArticuloController::class, 'listado'])->name('listado');
    Route::get('/actausuarios/listado/{id}', [ActausuarioController::class, 'listado'])->name('listado');
    Route::get('/actausuarios/generar/{id}', [ActausuarioController::class, 'generar'])->name('generar');

});

