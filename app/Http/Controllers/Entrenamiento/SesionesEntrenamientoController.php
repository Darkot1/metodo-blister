<?php

namespace App\Http\Controllers\Entrenamiento;

use App\Models\Entrenamiento\SesionesEntrenamiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entrenamiento\PlanesEntrenamiento;
use App\Models\Entrenamiento\MuscleGroup;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SesionesEntrenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PlanesEntrenamiento $plan)
    {
        $plan->load('alumno', 'sesiones.muscleGroups');
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
        $plan->load('alumno', 'sesiones.muscleGroups');
        $planData = $plan->toArray();
        $planData['numero_semanas'] = $plan->numero_semanas;

        $muscleGroups = MuscleGroup::all();

        return Inertia::render('Entrenamiento/Sesiones/SesionesEntrenamientoCreate', [
            'plan' => $planData,
            'muscleGroups' => $muscleGroups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PlanesEntrenamiento $plan)
    {
        $validated = $request->validate([
            'dia_semana' => 'required|string|max:20',
            'numero_semana' => "required|integer|min:1|max:{$plan->numero_semanas}",
            'muscle_group_id' => 'required|array|min:1',
            'muscle_group_id.*' => 'required|integer|distinct|exists:muscle_groups,id',
        ]);

        $alreadyExistsDay = SesionesEntrenamiento::query()
            ->where('plan_entrenamiento_id', $plan->id)
            ->where('numero_semana', $validated['numero_semana'])
            ->where('dia_semana', $validated['dia_semana'])
            ->exists();

        if ($alreadyExistsDay) {
            return redirect()->route('sesiones-entrenamiento.create', $plan->id)
                ->withErrors(['dia_semana' => 'Ya existe una sesión para ese día en la semana seleccionada.']);
        }

        $selectedMuscleGroupIds = collect($validated['muscle_group_id'])
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $primaryMuscleGroupId = $selectedMuscleGroupIds->first();
        $primaryMuscleGroup = MuscleGroup::find($primaryMuscleGroupId);

        if (!$primaryMuscleGroup) {
            return redirect()->route('sesiones-entrenamiento.create', $plan->id)
                ->withErrors(['muscle_group_id' => 'No se pudo crear la sesión con los grupos seleccionados.']);
        }

        $sesion = SesionesEntrenamiento::create([
            'dia_semana' => $validated['dia_semana'],
            'numero_semana' => $validated['numero_semana'],
            'muscle_group_id' => $primaryMuscleGroupId,
            'plan_entrenamiento_id' => $plan->id,
        ]);

        $sesion->muscleGroups()->sync($selectedMuscleGroupIds->all());

        return redirect()->route('sesiones-entrenamiento.index', $plan->id)
            ->with('message', 'Sesión creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $sesion->load('ejercicios.ejercicio', 'muscleGroups');
        $plan->load('alumno');

        return Inertia::render('Entrenamiento/Sesiones/SesionesEntrenamientoShow', [
            'plan' => $plan,
            'sesion' => $sesion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $plan->load('alumno', 'sesiones.muscleGroups');
        $planData = $plan->toArray();
        $planData['numero_semanas'] = $plan->numero_semanas;

        $muscleGroups = MuscleGroup::all();

        $sesion->load('muscleGroups');
        $sesionData = $sesion->toArray();
        $sesionData['muscle_group_ids'] = $sesion->muscleGroups->pluck('id')->values();

        return Inertia::render('Entrenamiento/Sesiones/SesionesEntrenamientoEdit', [
            'plan' => $planData,
            'sesion' => $sesionData,
            'muscleGroups' => $muscleGroups,
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
            'dia_semana' => 'required|string|max:20',
            'numero_semana' => "required|integer|min:1|max:{$plan->numero_semanas}",
            'muscle_group_id' => 'required|array|min:1',
            'muscle_group_id.*' => 'required|integer|distinct|exists:muscle_groups,id',
        ]);

        $alreadyExistsDay = SesionesEntrenamiento::query()
            ->where('plan_entrenamiento_id', $plan->id)
            ->where('numero_semana', $validated['numero_semana'])
            ->where('dia_semana', $validated['dia_semana'])
            ->where('id', '!=', $sesion->id)
            ->exists();

        if ($alreadyExistsDay) {
            return redirect()->route('sesiones-entrenamiento.edit', ['plan' => $plan->id, 'sesion' => $sesion->id])
                ->withErrors(['dia_semana' => 'Ya existe una sesión para ese día en la semana seleccionada.']);
        }

        $selectedMuscleGroupIds = collect($validated['muscle_group_id'])
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $muscleGroups = MuscleGroup::whereIn('id', $selectedMuscleGroupIds)
            ->get()
            ->keyBy('id');

        $primaryMuscleGroupId = $selectedMuscleGroupIds->first();
        $primaryMuscleGroup = $muscleGroups->get($primaryMuscleGroupId);

        if (!$primaryMuscleGroup) {
            return redirect()->route('sesiones-entrenamiento.edit', ['plan' => $plan->id, 'sesion' => $sesion->id])
                ->withErrors(['muscle_group_id' => 'Grupo muscular inválido.']);
        }

        DB::transaction(function () use (
            $sesion,
            $validated,
            $selectedMuscleGroupIds,
            $primaryMuscleGroupId
        ) {
            $sesion->update([
                'dia_semana' => $validated['dia_semana'],
                'numero_semana' => $validated['numero_semana'],
                'muscle_group_id' => $primaryMuscleGroupId,
            ]);

            $sesion->muscleGroups()->sync($selectedMuscleGroupIds->all());
        });

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
