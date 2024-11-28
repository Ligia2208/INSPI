<?php

use App\Http\Controllers\CambioCultura\Comunicacion\CumpleanoController;



Route::middleware(['auth'])->group(function () {

    //Cumpleaños
    Route::resource('cumpleanos', CumpleanoController::class)->parameters(['cumples' => 'cumple'])->names('cumple');


});
