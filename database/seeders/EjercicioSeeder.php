<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ejercicios\Ejercicio;
use App\Models\Ejercicios\TipoEjercicio;
use App\Models\Entrenamiento\MuscleGroup;

class EjercicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de tipos de ejercicio
        $compuesto = TipoEjercicio::where('nombre', 'Compuesto')->first();
        $aislamiento = TipoEjercicio::where('nombre', 'Aislamiento')->first();
        $pesoLibre = TipoEjercicio::where('nombre', 'Peso Libre')->first();
        $maquina = TipoEjercicio::where('nombre', 'Máquina')->first();
        $cable = TipoEjercicio::where('nombre', 'Cable')->first();
        $calistenia = TipoEjercicio::where('nombre', 'Calistenia')->first();

        // Obtener IDs de grupos musculares
        $pecho = MuscleGroup::where('slug', 'pecho')->first();
        $espalda = MuscleGroup::where('slug', 'espalda')->first();
        $hombrosT = MuscleGroup::where('slug', 'hombros-traseros')->first();
        $hombrosF = MuscleGroup::where('slug', 'hombros-frontales')->first();
        $biceps = MuscleGroup::where('slug', 'biceps')->first();
        $triceps = MuscleGroup::where('slug', 'triceps')->first();
        $cuadriceps = MuscleGroup::where('slug', 'cuadriceps')->first();
        $isquiotibiales = MuscleGroup::where('slug', 'isquiotibiales')->first();
        $gluteos = MuscleGroup::where('slug', 'gluteos')->first();
        $abdomen = MuscleGroup::where('slug', 'abdomen')->first();
        $trapecio = MuscleGroup::where('slug', 'trapecio')->first();
        $pantorrillas = MuscleGroup::where('slug', 'pantorrillas')->first();

        $ejercicios = [
            // PECHO
            [
                'nombre' => 'Press Banca Plano',
                'descripcion' => 'Ejercicio compuesto para desarrollar el pecho. Acuéstate en un banco plano y presiona la barra desde el pecho hasta extender los brazos.',
                'muscle_group_id' => $pecho?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Press Banca Inclinado',
                'descripcion' => 'Variante del press banca enfocada en la parte superior del pecho. El banco se inclina entre 30-45 grados.',
                'muscle_group_id' => $pecho?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Flexiones',
                'descripcion' => 'Ejercicio de peso corporal para pecho, hombros y tríceps. Mantén el cuerpo recto y baja hasta que el pecho casi toque el suelo.',
                'muscle_group_id' => $pecho?->id,
                'tipo_ejercicio_id' => $calistenia?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Aperturas con Mancuernas',
                'descripcion' => 'Ejercicio de aislamiento para pecho. Acostado en banco, abre los brazos en arco hasta sentir estiramiento en el pecho.',
                'muscle_group_id' => $pecho?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],

            // ESPALDA
            [
                'nombre' => 'Dominadas',
                'descripcion' => 'Ejercicio de peso corporal para espalda. Cuelga de una barra y tira del cuerpo hasta que la barbilla pase la barra.',
                'muscle_group_id' => $espalda?->id,
                'tipo_ejercicio_id' => $calistenia?->id,
                'nivel' => 'avanzado',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Remo con Barra',
                'descripcion' => 'Ejercicio compuesto para el grosor de la espalda. Inclínate hacia adelante y tira de la barra hacia el abdomen.',
                'muscle_group_id' => $espalda?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Jalón al Pecho',
                'descripcion' => 'Ejercicio en máquina para amplitud de espalda. Tira de la barra hacia el pecho manteniendo el torso erguido.',
                'muscle_group_id' => $espalda?->id,
                'tipo_ejercicio_id' => $maquina?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Peso Muerto',
                'descripcion' => 'Ejercicio compuesto fundamental. Levanta la barra desde el suelo extendiendo caderas y rodillas simultáneamente.',
                'muscle_group_id' => $espalda?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'avanzado',
                'estado' => 'activo',
            ],

            // HOMBROS
            [
                'nombre' => 'Press Militar',
                'descripcion' => 'Ejercicio compuesto para hombros. Presiona la barra desde los hombros hasta extensión completa sobre la cabeza.',
                'muscle_group_id' => $hombrosF?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Elevaciones Laterales',
                'descripcion' => 'Ejercicio de aislamiento para deltoides lateral. Eleva las mancuernas a los lados hasta la altura de los hombros.',
                'muscle_group_id' => $hombrosF?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Face Pulls',
                'descripcion' => 'Ejercicio con cable para deltoides posterior. Tira de la cuerda hacia la cara separando las manos al final.',
                'muscle_group_id' => $hombrosT?->id,
                'tipo_ejercicio_id' => $cable?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],

            // TRAPECIO
            [
                'nombre' => 'Encogimientos con Barra',
                'descripcion' => 'Ejercicio de aislamiento para trapecios. Sostén la barra y eleva los hombros hacia las orejas.',
                'muscle_group_id' => $trapecio?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],

            // BÍCEPS
            [
                'nombre' => 'Curl con Barra',
                'descripcion' => 'Ejercicio de aislamiento para bíceps. Flexiona los codos llevando la barra hacia los hombros.',
                'muscle_group_id' => $biceps?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Curl Martillo',
                'descripcion' => 'Variante de curl con agarre neutro. Trabaja bíceps y braquial. Mantén las palmas enfrentadas.',
                'muscle_group_id' => $biceps?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],

            // TRÍCEPS
            [
                'nombre' => 'Press Francés',
                'descripcion' => 'Ejercicio de aislamiento para tríceps. Acostado, baja la barra hacia la frente flexionando solo los codos.',
                'muscle_group_id' => $triceps?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Fondos en Paralelas',
                'descripcion' => 'Ejercicio compuesto de peso corporal. Baja el cuerpo entre las barras flexionando los codos.',
                'muscle_group_id' => $triceps?->id,
                'tipo_ejercicio_id' => $calistenia?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Extensiones de Tríceps en Polea',
                'descripcion' => 'Ejercicio de aislamiento con cable. Empuja la barra hacia abajo extendiendo completamente los codos.',
                'muscle_group_id' => $triceps?->id,
                'tipo_ejercicio_id' => $cable?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],

            // PIERNAS - CUÁDRICEPS
            [
                'nombre' => 'Sentadilla con Barra',
                'descripcion' => 'Ejercicio compuesto fundamental para piernas. Baja hasta que los muslos estén paralelos al suelo.',
                'muscle_group_id' => $cuadriceps?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Prensa de Piernas',
                'descripcion' => 'Ejercicio en máquina para cuádriceps y glúteos. Empuja la plataforma hasta extensión completa.',
                'muscle_group_id' => $cuadriceps?->id,
                'tipo_ejercicio_id' => $maquina?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Extensiones de Cuádriceps',
                'descripcion' => 'Ejercicio de aislamiento en máquina. Extiende las piernas levantando el peso con los cuádriceps.',
                'muscle_group_id' => $cuadriceps?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Zancadas con Mancuernas',
                'descripcion' => 'Ejercicio compuesto unilateral. Da un paso adelante y baja hasta que la rodilla trasera casi toque el suelo.',
                'muscle_group_id' => $cuadriceps?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],

            // PIERNAS - ISQUIOTIBIALES
            [
                'nombre' => 'Curl Femoral Acostado',
                'descripcion' => 'Ejercicio de aislamiento para isquiotibiales. Acostado boca abajo, flexiona las piernas llevando los talones hacia los glúteos.',
                'muscle_group_id' => $isquiotibiales?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Peso Muerto Rumano',
                'descripcion' => 'Variante de peso muerto enfocada en isquiotibiales. Baja la barra manteniendo las piernas casi rectas.',
                'muscle_group_id' => $isquiotibiales?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'avanzado',
                'estado' => 'activo',
            ],

            // GLÚTEOS
            [
                'nombre' => 'Hip Thrust',
                'descripcion' => 'Ejercicio compuesto para glúteos. Con la espalda apoyada en banco, eleva las caderas empujando con los talones.',
                'muscle_group_id' => $gluteos?->id,
                'tipo_ejercicio_id' => $compuesto?->id,
                'nivel' => 'intermedio',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Patada de Glúteo en Polea',
                'descripcion' => 'Ejercicio de aislamiento con cable. Extiende la pierna hacia atrás contrayendo el glúteo.',
                'muscle_group_id' => $gluteos?->id,
                'tipo_ejercicio_id' => $cable?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],

            // PANTORRILLAS
            [
                'nombre' => 'Elevaciones de Talones de Pie',
                'descripcion' => 'Ejercicio para pantorrillas. De pie, elévate sobre las puntas de los pies contrayendo los gemelos.',
                'muscle_group_id' => $pantorrillas?->id,
                'tipo_ejercicio_id' => $aislamiento?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],

            // ABDOMEN
            [
                'nombre' => 'Crunch Abdominal',
                'descripcion' => 'Ejercicio básico para abdomen. Acostado, eleva el tronco enrollando la columna vertebral.',
                'muscle_group_id' => $abdomen?->id,
                'tipo_ejercicio_id' => $calistenia?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Plancha',
                'descripcion' => 'Ejercicio isométrico para core. Mantén el cuerpo recto apoyado en antebrazos y puntas de los pies.',
                'muscle_group_id' => $abdomen?->id,
                'tipo_ejercicio_id' => $calistenia?->id,
                'nivel' => 'principiante',
                'estado' => 'activo',
            ],
        ];

        foreach ($ejercicios as $ejercicio) {
            // Solo crear si tiene muscle_group_id y tipo_ejercicio_id válidos
            if ($ejercicio['muscle_group_id'] && $ejercicio['tipo_ejercicio_id']) {
                Ejercicio::firstOrCreate(
                    ['nombre' => $ejercicio['nombre']],
                    $ejercicio
                );
            }
        }
    }
}
