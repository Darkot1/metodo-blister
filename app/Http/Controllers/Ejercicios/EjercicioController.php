<?php

namespace App\Http\Controllers\Ejercicios;

use App\Models\Ejercicios\Ejercicio;
use App\Models\Ejercicios\TipoEjercicio;
use App\Http\Requests\Ejercicios\EjercicioRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class EjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ejercicios = Ejercicio::with('tipoEjercicio')->get();
        return Inertia::render('Ejercicios/EjerciciosIndex', compact('ejercicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposEjercicio = TipoEjercicio::where('estado', 'activo')->get();
        return Inertia::render('Ejercicios/EjerciciosCreate', compact('tiposEjercicio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EjercicioRequest $request)
    {
        Ejercicio::create($request->validated());

        return redirect()->route('ejercicios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ejercicio $ejercicio)
    {
        $ejercicio->load('tipoEjercicio');
        return Inertia::render('Ejercicios/EjerciciosShow', compact('ejercicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ejercicio $ejercicio)
    {
        $ejercicio->load('tipoEjercicio');
        $tiposEjercicio = TipoEjercicio::where('estado', 'activo')->get();
        return Inertia::render('Ejercicios/EjerciciosEdit', compact('ejercicio', 'tiposEjercicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EjercicioRequest $request, Ejercicio $ejercicio)
    {
        $ejercicio->update($request->validated());

        return redirect()->route('ejercicios.show', $ejercicio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ejercicio $ejercicio)
    {
        $ejercicio->delete();

        return redirect()->route('ejercicios.index');
    }
}
