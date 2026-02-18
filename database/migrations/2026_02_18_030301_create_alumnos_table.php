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
        Schema::create('alumnos', function (Blueprint $table) {

            $table->id();
            $table->foreignId('usuario_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('nombres');
            $table->string('apellidos');

            $table->enum('genero', ['masculino', 'femenino']);
            $table->date('fecha_nacimiento');
            $table->integer('altura_cm');
            $table->decimal('peso_inicial_kg', 5, 2)->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('objetivo')->nullable();

            $table->enum('estado', ['activo', 'en_pausa', 'inactivo'])
                ->default('activo');
            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
