<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\MuscleGroupSeeder;
use Database\Seeders\TipoEjercicioSeeder;
use Database\Seeders\EjercicioSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'entrenador@blister.com'],
            [
                'name' => 'entrenador de prueba',
                'email' => 'entrenador@blister.com',
                'role' => 'entrenador',
                'password' => bcrypt('entrenador'),
            ]
        );

        // Seeders de datos base
        $this->call([
            MuscleGroupSeeder::class,
            TipoEjercicioSeeder::class,
            EjercicioSeeder::class,
        ]);
    }
}
