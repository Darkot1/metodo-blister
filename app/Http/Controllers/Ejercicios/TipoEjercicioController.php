<?php

namespace App\Http\Controllers\Ejercicios;

use App\Models\Ejercicios\TipoEjercicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TipoEjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoEjercicios = TipoEjercicio::all();
        return Inertia::render('Ejercicios/TipoEjercicios/TipoEjerciciosIndex', compact('tipoEjercicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Ejercicios/TipoEjercicios/TipoEjerciciosCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:tipo_ejercicios,nombre',
            'estado' => 'required|in:activo,inactivo',
        ]);

        TipoEjercicio::create($request->all());

        return redirect()->route('tipo-ejercicios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoEjercicio $tipoEjercicio)
    {
        return Inertia::render('Ejercicios/TipoEjercicios/TipoEjerciciosShow', compact('tipoEjercicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoEjercicio $tipoEjercicio)
    {
        return Inertia::render('Ejercicios/TipoEjercicios/TipoEjerciciosEdit', compact('tipoEjercicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoEjercicio $tipoEjercicio)
    {
        $request->validate([
            'nombre' => ['required', Rule::unique('tipo_ejercicios', 'nombre')->ignore($tipoEjercicio->id)],
            'estado' => 'required|in:activo,inactivo',
        ]);

        $tipoEjercicio->update($request->all());

        return redirect()->route('tipo-ejercicios.show', $tipoEjercicio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoEjercicio $tipoEjercicio)
    {
        $tipoEjercicio->delete();

        return redirect()->route('tipo-ejercicios.index');
    }
}
