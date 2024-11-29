<?php

use App\Http\Controllers\CoreBase\Area\AreaController;
use App\Http\Controllers\CoreBase\Direccion\DireccionController;
use App\Http\Controllers\CoreBase\Dirtecnica\DirtecnicaController;
use App\Http\Controllers\CoreBase\Cargo\CargoController;
use App\Http\Controllers\CoreBase\Menu\MenuController;


Route::middleware(['auth'])->group(function () {

    //Areas/Direcciones
    Route::resource('areas', AreaController::class)->parameters(['areas' => 'area'])->names('area');

    //Direcciones
    Route::resource('direcciones', DireccionController::class)->parameters(['direcciones' => 'direccion'])->names('direccion');

    //Direcciones Técnicas
    Route::resource('dirtecnicas', DirtecnicaController::class)->parameters(['dirtecnicas' => 'dirtecnica'])->names('dirtecnica');

    //Cargos Talento Humano
    Route::resource('cargos', CargoController::class)->parameters(['cargos' => 'cargo'])->names('cargo');

    //Menu Principal
    Route::resource('menues', MenuController::class)->parameters(['menues' => 'menu'])->names('menu');

});
