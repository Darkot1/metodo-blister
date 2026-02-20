<?php

use App\Http\Controllers\Alumnos\AlumnoController;
use App\Http\Controllers\Ejercicios\TipoEjercicioController;
use App\Http\Controllers\Ejercicios\EjercicioController;
use App\Http\Controllers\Entrenamiento\PlanesEntrenamientoController;
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

    // Rutas de ejercicios
    Route::controller(EjercicioController::class)->group(function () {
        Route::get('ejercicios', 'index')->name('ejercicios.index');
        Route::get('ejercicio/registrar', 'create')->name('ejercicios.create');
        Route::post('ejercicio/registrar', 'store')->name('ejercicios.store');
        Route::get('ejercicio/{ejercicio}', 'show')->name('ejercicios.show');
        Route::get('ejercicio/{ejercicio}/editar', 'edit')->name('ejercicios.edit');
        Route::put('ejercicio/{ejercicio}', 'update')->name('ejercicios.update');
        Route::delete('ejercicio/{ejercicio}', 'destroy')->name('ejercicios.destroy');
    });

    // Rutas de planes de entrenamiento
    Route::controller(PlanesEntrenamientoController::class)->group(function () {
        Route::get('planes-entrenamiento', 'index')->name('planes-entrenamiento.index');
        Route::get('plan-entrenamiento/crear', 'create')->name('planes-entrenamiento.create');
        Route::post('plan-entrenamiento/crear', 'store')->name('planes-entrenamiento.store');
        Route::get('plan-entrenamiento/{planesEntrenamiento}', 'show')->name('planes-entrenamiento.show');
        Route::get('plan-entrenamiento/{planesEntrenamiento}/editar', 'edit')->name('planes-entrenamiento.edit');
        Route::put('plan-entrenamiento/{planesEntrenamiento}', 'update')->name('planes-entrenamiento.update');
        Route::delete('plan-entrenamiento/{planesEntrenamiento}', 'destroy')->name('planes-entrenamiento.destroy');
    });
});
