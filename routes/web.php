<?php

use App\Http\Controllers\Alumnos\AlumnoController;
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
});
