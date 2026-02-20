<?php

namespace App\Http\Controllers\Entrenamiento;

use App\Models\Entrenamiento\PlanesEntrenamiento;
use App\Models\Alumnos\Alumno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entrenamiento\PlanesEntrenamientoRequest;
use Inertia\Inertia;

class PlanesEntrenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = PlanesEntrenamiento::with('alumno')->get();

        return Inertia::render('Entrenamiento/PlanesEntrenamiento/PlanesEntrenamientoIndex', [
            'planes' => $planes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumnos = Alumno::orderBy('nombres')->get();

        return Inertia::render('Entrenamiento/PlanesEntrenamiento/PlanesEntrenamientoCreate', [
            'alumnos' => $alumnos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanesEntrenamientoRequest $request)
    {
        PlanesEntrenamiento::create($request->validated());
        
        return redirect()->route('planes-entrenamiento.index')
            ->with('message', 'Plan de entrenamiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanesEntrenamiento $planesEntrenamiento)
    {
        $planesEntrenamiento->load('alumno');
        return Inertia::render('Entrenamiento/PlanesEntrenamiento/PlanesEntrenamientoShow', [
            'plan' => $planesEntrenamiento,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanesEntrenamiento $planesEntrenamiento)
    {
        $alumnos = Alumno::orderBy('nombres')->get();
        return Inertia::render('Entrenamiento/PlanesEntrenamiento/PlanesEntrenamientoEdit', [
            'plan' => $planesEntrenamiento,
            'alumnos' => $alumnos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanesEntrenamientoRequest $request, PlanesEntrenamiento $planesEntrenamiento)
    {
        $planesEntrenamiento->update($request->validated());
        return redirect()->route('planes-entrenamiento.show', $planesEntrenamiento->id)
            ->with('message', 'Plan de entrenamiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanesEntrenamiento $planesEntrenamiento)
    {
        $planesEntrenamiento->delete();
        return redirect()->route('planes-entrenamiento.index')
            ->with('message', 'Plan de entrenamiento eliminado exitosamente.');
    }
}
