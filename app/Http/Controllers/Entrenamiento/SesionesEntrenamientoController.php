<?php

namespace App\Http\Controllers\Entrenamiento;

use App\Models\Entrenamiento\SesionesEntrenamiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entrenamiento\PlanesEntrenamiento;
use Inertia\Inertia;

class SesionesEntrenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PlanesEntrenamiento $plan)
    {
        $plan->load('alumno', 'sesiones');
        $planData = $plan->toArray();
        $planData['numero_semanas'] = $plan->numero_semanas;

        return Inertia::render('Entrenamiento/Sesiones/SesionesEntrenamientoIndex', [
            'plan' => $planData,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PlanesEntrenamiento $plan)
    {
        $plan->load('alumno', 'sesiones');
        $planData = $plan->toArray();
        $planData['numero_semanas'] = $plan->numero_semanas;
        return Inertia::render('Entrenamiento/Sesiones/SesionesEntrenamientoCreate', [
            'plan' => $planData,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PlanesEntrenamiento $plan)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'dia_semana' => 'required|string|max:20',
            'numero_semana' => "required|integer|min:1|max:{$plan->numero_semanas}",
        ]);

        $validated['plan_entrenamiento_id'] = $plan->id;

        SesionesEntrenamiento::create($validated);

        return redirect()->route('sesiones-entrenamiento.create', $plan->id)
            ->with('message', 'Sesión creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(SesionesEntrenamiento $sesionesEntrenamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $plan->load('alumno', 'sesiones');
        $planData = $plan->toArray();
        $planData['numero_semanas'] = $plan->numero_semanas;

        return Inertia::render('Entrenamiento/Sesiones/SesionesEntrenamientoEdit', [
            'plan' => $planData,
            'sesion' => $sesion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'dia_semana' => 'required|string|max:20',
            'numero_semana' => "required|integer|min:1|max:{$plan->numero_semanas}",
        ]);

        $sesion->update($validated);

        return redirect()->route('sesiones-entrenamiento.index', $plan->id)
            ->with('message', 'Sesión actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $sesion->delete();

        return redirect()->route('sesiones-entrenamiento.index', $plan->id)
            ->with('message', 'Sesión eliminada correctamente');
    }
}
