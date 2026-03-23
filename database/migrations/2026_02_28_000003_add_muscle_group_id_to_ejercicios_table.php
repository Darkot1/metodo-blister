<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar la nueva columna muscle_group_id
        Schema::table('ejercicios', function (Blueprint $table) {
            $table->foreignId('muscle_group_id')->nullable()->after('descripcion')->constrained('muscle_groups');
        });

        // Migrar datos del campo texto grupo_muscular al nuevo muscle_group_id
        // Mapeo de nombres comunes a slugs de muscle_groups
        $mapping = [
            'pecho' => 'pecho',
            'espalda' => 'espalda',
            'trapecio' => 'trapecio',
            'hombros' => 'hombros',
            'hombro' => 'hombros',
            'brazos' => 'brazos',
            'brazo' => 'brazos',
            'biceps' => 'brazos',
            'triceps' => 'brazos',
            'antebrazos' => 'antebrazos',
            'antebrazo' => 'antebrazos',
            'abdominales' => 'abdominales',
            'abdomen' => 'abdominales',
            'core' => 'abdominales',
            'oblicuos' => 'oblicuos',
            'lumbares' => 'lumbares',
            'lumbar' => 'lumbares',
            'gluteos' => 'gluteos',
            'glúteos' => 'gluteos',
            'gluteo' => 'gluteos',
            'cuadriceps' => 'cuadriceps',
            'cuádriceps' => 'cuadriceps',
            'femoral' => 'femoral',
            'femorales' => 'femoral',
            'isquiotibiales' => 'femoral',
            'aductores' => 'aductores',
            'aductor' => 'aductores',
            'pantorrillas' => 'pantorrillas',
            'pantorrilla' => 'pantorrillas',
            'gemelos' => 'pantorrillas',
            'piernas' => 'cuadriceps', // default para piernas genérico
        ];

        // Obtener todos los ejercicios con grupo_muscular
        $ejercicios = DB::table('ejercicios')->whereNotNull('grupo_muscular')->get();

        foreach ($ejercicios as $ejercicio) {
            $grupoMuscular = strtolower(trim($ejercicio->grupo_muscular));

            // Buscar el slug en el mapeo
            $slug = $mapping[$grupoMuscular] ?? null;

            if ($slug) {
                // Buscar el muscle_group_id correspondiente
                $muscleGroup = DB::table('muscle_groups')->where('slug', $slug)->first();

                if ($muscleGroup) {
                    DB::table('ejercicios')
                        ->where('id', $ejercicio->id)
                        ->update(['muscle_group_id' => $muscleGroup->id]);
                }
            }
        }

        // Eliminar la columna antigua grupo_muscular
        Schema::table('ejercicios', function (Blueprint $table) {
            $table->dropColumn('grupo_muscular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar la columna grupo_muscular
        Schema::table('ejercicios', function (Blueprint $table) {
            $table->string('grupo_muscular')->nullable()->after('descripcion');
        });

        // Migrar datos de vuelta (best effort)
        $ejercicios = DB::table('ejercicios')
            ->join('muscle_groups', 'ejercicios.muscle_group_id', '=', 'muscle_groups.id')
            ->select('ejercicios.id', 'muscle_groups.nombre')
            ->get();

        foreach ($ejercicios as $ejercicio) {
            DB::table('ejercicios')
                ->where('id', $ejercicio->id)
                ->update(['grupo_muscular' => $ejercicio->nombre]);
        }

        // Eliminar la columna muscle_group_id
        Schema::table('ejercicios', function (Blueprint $table) {
            $table->dropForeign(['muscle_group_id']);
            $table->dropColumn('muscle_group_id');
        });
    }
};
