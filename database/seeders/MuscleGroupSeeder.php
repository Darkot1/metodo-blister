<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entrenamiento\MuscleGroup;

class MuscleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['nombre' => 'Pecho', 'slug' => 'pecho', 'descripcion' => 'Pectoral mayor y menor'],
            ['nombre' => 'Espalda', 'slug' => 'espalda', 'descripcion' => 'Dorsal ancho y músculos de la espalda'],
            ['nombre' => 'Trapecio', 'slug' => 'trapecio', 'descripcion' => 'Músculo trapecio superior, medio e inferior'],
            ['nombre' => 'Hombros Traseros', 'slug' => 'hombros-traseros', 'descripcion' => 'Deltoides posterior'],
            ['nombre' => 'Hombros Frontales', 'slug' => 'hombros-frontales', 'descripcion' => 'Deltoides anterior'],
            ['nombre' => 'Bíceps', 'slug' => 'biceps', 'descripcion' => 'Bíceps braquial'],
            ['nombre' => 'Tríceps', 'slug' => 'triceps', 'descripcion' => 'Tríceps braquial'],
            ['nombre' => 'Antebrazos', 'slug' => 'antebrazos', 'descripcion' => 'Músculos flexores y extensores del antebrazo'],
            ['nombre' => 'Abdomen', 'slug' => 'abdomen', 'descripcion' => 'Recto abdominal y transverso'],
            ['nombre' => 'Oblicuos', 'slug' => 'oblicuos', 'descripcion' => 'Oblicuo externo e interno'],
            ['nombre' => 'Baja Espalda', 'slug' => 'baja-espalda', 'descripcion' => 'Espalda baja y erector de la columna'],
            ['nombre' => 'Glúteos', 'slug' => 'gluteos', 'descripcion' => 'Glúteo mayor, medio y menor'],
            ['nombre' => 'Cuádriceps', 'slug' => 'cuadriceps', 'descripcion' => 'Recto femoral, vasto lateral y medial'],
            ['nombre' => 'Isquiotibiales', 'slug' => 'isquiotibiales', 'descripcion' => 'Bíceps femoral, semitendinoso y semimembranoso'],
            ['nombre' => 'Pantorrillas', 'slug' => 'pantorrillas', 'descripcion' => 'Gastrocnemio y sóleo'],
        ];

        foreach ($groups as $group) {
            MuscleGroup::firstOrCreate(['slug' => $group['slug']], $group);
        }
    }
}
