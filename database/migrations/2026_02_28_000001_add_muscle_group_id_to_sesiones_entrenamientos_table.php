<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sesiones_entrenamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('muscle_group_id')->nullable()->after('plan_entrenamiento_id');
            $table->foreign('muscle_group_id')->references('id')->on('muscle_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesiones_entrenamientos', function (Blueprint $table) {
            $table->dropForeign(['muscle_group_id']);
            $table->dropColumn('muscle_group_id');
        });
    }
};
