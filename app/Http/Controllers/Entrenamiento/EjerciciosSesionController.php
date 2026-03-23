<?php

namespace App\Http\Controllers\Entrenamiento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entrenamiento\EjerciciosSesion;
use App\Models\Entrenamiento\SesionesEntrenamiento;
use App\Models\Entrenamiento\PlanesEntrenamiento;
use App\Models\Ejercicios\Ejercicio;
use Inertia\Inertia;

class EjerciciosSesionController extends Controller
{
    private function getSessionMuscleGroupIds(SesionesEntrenamiento $sesion)
    {
        $sesion->loadMissing('muscleGroups');

        $muscleGroupIds = $sesion->muscleGroups
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        if ($muscleGroupIds->isEmpty() && $sesion->muscle_group_id) {
            $muscleGroupIds = collect([(int) $sesion->muscle_group_id]);
        }

        return $muscleGroupIds;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        // Validar que la sesión pertenece al plan
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $sesion->load('ejercicios.ejercicio.muscleGroup', 'muscleGroups');

        return Inertia::render('Entrenamiento/EjerciciosSesion/EjerciciosSesionIndex', [
            'plan' => $plan,
            'sesion' => $sesion,
            'ejercicios' => $sesion->ejercicios,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        // Validar que la sesión pertenece al plan
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $muscleGroupIds = $this->getSessionMuscleGroupIds($sesion);
        $usedExerciseIds = $sesion->ejercicios()->pluck('ejercicio_id');

        $ejercicios = Ejercicio::with(['muscleGroup', 'tipoEjercicio'])
            ->whereIn('muscle_group_id', $muscleGroupIds->all())
            ->whereNotIn('id', $usedExerciseIds)
            ->get();
        $sesion->load('muscleGroups');
        $nextOrder = ((int) $sesion->ejercicios()->max('orden')) + 1;

        return Inertia::render('Entrenamiento/EjerciciosSesion/EjerciciosSesionCreate', [
            'plan' => $plan,
            'sesion' => $sesion,
            'ejercicios' => $ejercicios,
            'nextOrder' => max($nextOrder, 1),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion)
    {
        // Validar que la sesión pertenece al plan
        if ($sesion->plan_entrenamiento_id !== $plan->id) {
            abort(404);
        }

        $validated = $request->validate([
            'ejercicio_id' => 'required|exists:ejercicios,id',
            'series' => 'required|integer|min:1|max:10',
            'repeticiones' => 'required|integer|min:1|max:100',
            'peso' => 'required|numeric|min:0|max:999.99',
            'descanso_segundos' => 'required|integer|min:0|max:300',
            'orden' => 'required|integer|min:1',
        ]);

        $muscleGroupIds = $this->getSessionMuscleGroupIds($sesion);

        $isValidExerciseForSession = Ejercicio::query()
            ->where('id', $validated['ejercicio_id'])
            ->whereIn('muscle_group_id', $muscleGroupIds->all())
            ->exists();

        if (!$isValidExerciseForSession) {
            return redirect()->route('ejercicios-sesion.create', [$plan->id, $sesion->id])
                ->withErrors(['ejercicio_id' => 'El ejercicio seleccionado no pertenece a los grupos musculares de esta sesión.'])
                ->withInput();
        }

        $alreadyExistsInSession = EjerciciosSesion::query()
            ->where('sesiones_entrenamientos_id', $sesion->id)
            ->where('ejercicio_id', $validated['ejercicio_id'])
            ->exists();

        if ($alreadyExistsInSession) {
            return redirect()->route('ejercicios-sesion.create', [$plan->id, $sesion->id])
                ->withErrors(['ejercicio_id' => 'Este ejercicio ya fue agregado a la sesión.'])
                ->withInput();
        }

        $validated['sesiones_entrenamientos_id'] = $sesion->id;

        EjerciciosSesion::create($validated);

        return redirect()->route('ejercicios-sesion.index', [$plan->id, $sesion->id])
            ->with('message', 'Ejercicio agregado a la sesión correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(EjerciciosSesion $ejerciciosSesion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion, EjerciciosSesion $ejerciciosSesion)
    {
        // Validar que la sesión pertenece al plan y el ejercicio a la sesión
        if ($sesion->plan_entrenamiento_id !== $plan->id || $ejerciciosSesion->sesiones_entrenamientos_id !== $sesion->id) {
            abort(404);
        }

        $muscleGroupIds = $this->getSessionMuscleGroupIds($sesion);
        $usedExerciseIds = $sesion->ejercicios()
            ->where('id', '!=', $ejerciciosSesion->id)
            ->pluck('ejercicio_id');

        $ejercicios = Ejercicio::with(['muscleGroup', 'tipoEjercicio'])
            ->whereIn('muscle_group_id', $muscleGroupIds->all())
            ->whereNotIn('id', $usedExerciseIds)
            ->get();
        $sesion->load('muscleGroups');

        return Inertia::render('Entrenamiento/EjerciciosSesion/EjerciciosSesionEdit', [
            'plan' => $plan,
            'sesion' => $sesion,
            'ejerciciosSesion' => $ejerciciosSesion,
            'ejercicios' => $ejercicios,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion, EjerciciosSesion $ejerciciosSesion)
    {
        // Validar que la sesión pertenece al plan y el ejercicio a la sesión
        if ($sesion->plan_entrenamiento_id !== $plan->id || $ejerciciosSesion->sesiones_entrenamientos_id !== $sesion->id) {
            abort(404);
        }

        $validated = $request->validate([
            'ejercicio_id' => 'required|exists:ejercicios,id',
            'series' => 'required|integer|min:1|max:10',
            'repeticiones' => 'required|integer|min:1|max:100',
            'peso' => 'required|numeric|min:0|max:999.99',
            'descanso_segundos' => 'required|integer|min:0|max:300',
            'orden' => 'required|integer|min:1',
        ]);

        $muscleGroupIds = $this->getSessionMuscleGroupIds($sesion);

        $isValidExerciseForSession = Ejercicio::query()
            ->where('id', $validated['ejercicio_id'])
            ->whereIn('muscle_group_id', $muscleGroupIds->all())
            ->exists();

        if (!$isValidExerciseForSession) {
            return redirect()->route('ejercicios-sesion.edit', [$plan->id, $sesion->id, $ejerciciosSesion->id])
                ->withErrors(['ejercicio_id' => 'El ejercicio seleccionado no pertenece a los grupos musculares de esta sesión.'])
                ->withInput();
        }

        $alreadyExistsInSession = EjerciciosSesion::query()
            ->where('sesiones_entrenamientos_id', $sesion->id)
            ->where('ejercicio_id', $validated['ejercicio_id'])
            ->where('id', '!=', $ejerciciosSesion->id)
            ->exists();

        if ($alreadyExistsInSession) {
            return redirect()->route('ejercicios-sesion.edit', [$plan->id, $sesion->id, $ejerciciosSesion->id])
                ->withErrors(['ejercicio_id' => 'Este ejercicio ya fue agregado a la sesión.'])
                ->withInput();
        }

        $ejerciciosSesion->update($validated);

        return redirect()->route('ejercicios-sesion.index', [$plan->id, $sesion->id])
            ->with('message', 'Ejercicio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanesEntrenamiento $plan, SesionesEntrenamiento $sesion, EjerciciosSesion $ejerciciosSesion)
    {
        // Validar que la sesión pertenece al plan y el ejercicio a la sesión
        if ($sesion->plan_entrenamiento_id !== $plan->id || $ejerciciosSesion->sesiones_entrenamientos_id !== $sesion->id) {
            abort(404);
        }

        $ejerciciosSesion->delete();

        return redirect()->route('ejercicios-sesion.index', [$plan->id, $sesion->id])
            ->with('message', 'Ejercicio eliminado correctamente');
    }
}
