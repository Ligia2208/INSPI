<?php

use App\Http\Controllers\RecursosHumanos\Persona\PersonaController;
use App\Http\Controllers\RecursosHumanos\Postulante\PostulanteController;
use App\Http\Controllers\RecursosHumanos\Filiacion\FiliacionController;


Route::middleware(['auth'])->group(function () {
        
       
        //Personas Talento Humano
        Route::resource('personas', PersonaController::class)->parameters(['personas' => 'persona'])->names('persona');

        //Contratación Talento Humano
        Route::resource('filiaciones', FiliacionController::class)->parameters(['filiaciones' => 'filiacion'])->names('filiacion');
    
});