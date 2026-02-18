<?php

use App\Http\Controllers\Alumnos\AlumnoController;
use App\Http\Controllers\Ejercicios\TipoEjercicioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    // Rutas de alumnos
    Route::controller(AlumnoController::class)->group(function () {
        Route::get('alumnos', 'index')->name('alumnos.index');
        Route::get('alumno/registrar', 'create')->name('alumnos.create');
        Route::post('alumno/registrar', 'store')->name('alumnos.store');
        Route::get('alumno/{alumno}', 'show')->name('alumnos.show');
        Route::get('alumno/{alumno}/editar', 'edit')->name('alumnos.edit');
        Route::put('alumno/{alumno}', 'update')->name('alumnos.update');
        Route::delete('alumno/{alumno}', 'destroy')->name('alumnos.destroy');
    });


    // Rutas de tipo de ejercicios
    Route::controller(TipoEjercicioController::class)->group(function () {
        Route::get('tipo-ejercicios', 'index')->name('tipo-ejercicios.index');
        Route::get('tipo-ejercicio/registrar', 'create')->name('tipo-ejercicios.create');
        Route::post('tipo-ejercicio/registrar', 'store')->name('tipo-ejercicios.store');
        Route::get('tipo-ejercicio/{tipoEjercicio}', 'show')->name('tipo-ejercicios.show');
        Route::get('tipo-ejercicio/{tipoEjercicio}/editar', 'edit')->name('tipo-ejercicios.edit');
        Route::put('tipo-ejercicio/{tipoEjercicio}', 'update')->name('tipo-ejercicios.update');
        Route::delete('tipo-ejercicio/{tipoEjercicio}', 'destroy')->name('tipo-ejercicios.destroy');
    });
    
});
