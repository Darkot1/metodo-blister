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
            Schema::create('sesiones_entrenamientos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('plan_entrenamiento_id')->constrained('planes_entrenamientos')->onDelete('cascade');
                $table->integer('numero_semana');
                $table->string('nombre');
                $table->string('dia_semana');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('sesiones_entrenamientos');
        }
    };
