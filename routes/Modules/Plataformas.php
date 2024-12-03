<?php

use App\Http\Controllers\Plataformas\Bioterio\EspecimenController;
use App\Http\Controllers\Plataformas\Vacuna\VacunaController;
use App\Http\Controllers\Plataformas\Parasito\ParasitoController;
use App\Http\Controllers\Plataformas\Dieta\DietaController;
use App\Http\Controllers\Plataformas\Clinica\ClinicaController;
use App\Http\Controllers\Plataformas\Tratamiento\TratamientoController;
use App\Http\Controllers\Plataformas\Anamnesis\AnamnesisController;
use App\Http\Controllers\Plataformas\Constante\ConstanteController;
use App\Http\Controllers\CentrosReferencia\Preanalitica\PreanaliticaController;
use App\Http\Controllers\CentrosReferencia\Analitica\AnaliticaController;
use App\Http\Controllers\CentrosReferencia\Postanalitica\PostanaliticaController;
use App\Http\Controllers\CentrosReferencia\Resultado\ResultadoController;
use App\Http\Controllers\CentrosReferencia\Resultadomsp\ResultadomspController;
use App\Http\Controllers\CentrosReferencia\Resultadocrn\ResultadocrnController;
use App\Http\Controllers\CentrosReferencia\VisorResultados\VisorResultadosController;
use App\Http\Controllers\CentrosReferencia\Responsable\ResponsableController;
use App\Http\Controllers\CentrosReferencia\Paciente\PacienteController;

Route::middleware(['auth'])->group(function () {

        //Especimen Plataformas Bioterio
        Route::resource('especimenes', EspecimenController::class)->parameters(['especimenes' => 'especimen'])->names('especimen');
        Route::get('/especimenes/ficha/{id}', [EspecimenController::class, 'ficha'])->name('ficha');
        //Vacunas Plataformas Bioterio
        Route::resource('vacunas', VacunaController::class)->parameters(['vacunas' => 'vacuna'])->names('vacuna');
        Route::get('/vacunas/agregar/{id}', [VacunaController::class, 'agregar', 'id'])->name('agregar');

        //Parasitos Plataformas Bioterio
        Route::resource('parasitos', ParasitoController::class)->parameters(['parasitos' => 'parasito'])->names('parasito');
        Route::get('/parasitos/agregar/{id}', [ParasitoController::class, 'agregar', 'id'])->name('agregar');

        //Dietas Plataformas Bioterio
        Route::resource('dietas', DietaController::class)->parameters(['dietas' => 'dieta'])->names('dieta');
        Route::get('/dietas/agregar/{id}', [DietaController::class, 'agregar', 'id'])->name('agregar');

        //Manifestaciones Clinicas Plataformas Bioterio
        Route::resource('clinicas', ClinicaController::class)->parameters(['clinicas' => 'clinica'])->names('clinica');
        Route::get('/clinicas/agregar/{id}', [ClinicaController::class, 'agregar', 'id'])->name('agregar');

        //Tratamiento Plataformas Bioterio
        Route::resource('tratamientos', TratamientoController::class)->parameters(['tratamientos' => 'tratamiento'])->names('tratamiento');
        Route::get('/tratamientos/agregar/{id}', [TratamientoController::class, 'agregar', 'id'])->name('agregar');

        //Anamnesis Plataformas Bioterio
        Route::resource('anamnesiss', AnamnesisController::class)->parameters(['anamnesiss' => 'anamnesis'])->names('anamnesis');
        Route::get('/anamnesiss/agregar/{id}', [AnamnesisController::class, 'agregar', 'id'])->name('agregar');

        //Constantes Fisiológicas Plataformas Bioterio
        Route::resource('constantes', ConstanteController::class)->parameters(['constantes' => 'constante'])->names('constante');
        Route::get('/constantes/agregar/{id}', [ConstanteController::class, 'agregar', 'id'])->name('agregar');

        //Pacientes CRNs Plataformas
        Route::resource('pacientes', PacienteController::class)->parameters(['pacientes' => 'paciente'])->names('paciente');

        //CRNs Plataformas Preanalitica
        Route::resource('preanaliticas', PreanaliticaController::class)->parameters(['preanaliticas' => 'preanalitica'])->names('preanalitica');

        //CRNs Plataformas Resultados
        Route::resource('resultados', ResultadoController::class)->parameters(['resultados' => 'resultado'])->names('resultado');

        //CRNs Plataformas Resultados
        Route::resource('resultadosmsp', ResultadomspController::class)->parameters(['resultados' => 'resultado'])->names('resultadomsp');

        //CRNs Plataformas Resultados
        Route::resource('resultadoscrn', ResultadocrnController::class)->parameters(['resultados' => 'resultado'])->names('resultadocrn');

        //CRNs Plataformas Analitica de Resultados
        Route::resource('analiticas', AnaliticaController::class)->parameters(['analiticas' => 'analitica'])->names('analitica');

        //CRNs Plataformas Analitica de Resultados Resonsable
        Route::resource('postanaliticas', PostanaliticaController::class)->parameters(['analiticas' => 'analitica'])->names('postanalitica');

        //CRNs Plataformas Resultados
        Route::resource('visorresultados', VisorResultadosController::class)->parameters(['resultados' => 'resultado'])->names('visorresultado');

        //CRNs Responsables Resultados
        Route::resource('responsables', ResponsableController::class)->parameters(['responsables' => 'responsable'])->names('responsable');

        Route::get('/informefinal/informep/{id}', [PostanaliticaController::class, 'informep'])->name('informep');

        Route::get('/informefinal/informer/{id}', [AnaliticaController::class, 'informer'])->name('informer');

        Route::get('/informefinal/informemsp/{id}', [ResultadomspController::class, 'informemsp'])->name('informemsp');
});
