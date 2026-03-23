<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ejercicios\TipoEjercicio;

class TipoEjercicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Compuesto', 'estado' => 'activo'],
            ['nombre' => 'Aislamiento', 'estado' => 'activo'],
            ['nombre' => 'Funcional', 'estado' => 'activo'],
            ['nombre' => 'Cardio', 'estado' => 'activo'],
            ['nombre' => 'Pliométrico', 'estado' => 'activo'],
            ['nombre' => 'Isométrico', 'estado' => 'activo'],
            ['nombre' => 'Calistenia', 'estado' => 'activo'],
            ['nombre' => 'Máquina', 'estado' => 'activo'],
            ['nombre' => 'Peso Libre', 'estado' => 'activo'],
            ['nombre' => 'Cable', 'estado' => 'activo'],
        ];

        foreach ($tipos as $tipo) {
            TipoEjercicio::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }
    }
}
