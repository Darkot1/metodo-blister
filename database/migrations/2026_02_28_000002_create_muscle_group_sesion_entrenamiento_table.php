<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('muscle_group_sesion_entrenamiento');

        Schema::create('muscle_group_sesion_entrenamiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesion_entrenamiento_id');
            $table->unsignedBigInteger('muscle_group_id');

            $table->foreign('sesion_entrenamiento_id', 'smge_sesion_fk')
                ->references('id')
                ->on('sesiones_entrenamientos')
                ->cascadeOnDelete();

            $table->foreign('muscle_group_id', 'smge_muscle_fk')
                ->references('id')
                ->on('muscle_groups')
                ->cascadeOnDelete();

            $table->unique(['sesion_entrenamiento_id', 'muscle_group_id'], 'sesion_muscle_unique');
            $table->timestamps();
        });

        $rows = DB::table('sesiones_entrenamientos')
            ->whereNotNull('muscle_group_id')
            ->select('id', 'muscle_group_id')
            ->get();

        foreach ($rows as $row) {
            DB::table('muscle_group_sesion_entrenamiento')->insert([
                'sesion_entrenamiento_id' => $row->id,
                'muscle_group_id' => $row->muscle_group_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muscle_group_sesion_entrenamiento');
    }
};
