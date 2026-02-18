<?php

use App\Http\Controllers\Students\StudentController;
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
    Route::controller(StudentController::class)->group(function () {
        Route::get('alumnos', 'index')->name('alumnos.index');
        Route::get('alumno/registrar', 'create')->name('alumnos.create');
        Route::post('alumno/registrar', 'store')->name('alumnos.store');
        Route::get('alumno/{student}/editar', 'edit')->name('alumnos.edit');
        Route::put('alumno/{student}', 'update')->name('alumnos.update');
        Route::delete('alumno/{student}', 'destroy')->name('alumnos.destroy');
    });
});
