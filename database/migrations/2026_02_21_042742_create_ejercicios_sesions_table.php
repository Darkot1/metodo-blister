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
        Schema::create('ejercicios_sesions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesiones_entrenamientos_id');
            $table->foreign('sesiones_entrenamientos_id')->references('id')->on('sesiones_entrenamientos');

            $table->unsignedBigInteger('ejercicio_id');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios');

            $table->integer('series');
            $table->integer('repeticiones');
            $table->decimal('peso', 6, 2);

            $table->integer('descanso_segundos');
            $table->text('orden');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercios_sesions');
    }
};
