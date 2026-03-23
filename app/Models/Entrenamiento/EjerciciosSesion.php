<?php

namespace App\Models\Entrenamiento;

use App\Models\Ejercicios\Ejercicio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjerciciosSesion extends Model
{
    use HasFactory;

    protected $table = "ejercicios_sesions";

    protected $fillable = [
        'sesiones_entrenamientos_id',
        'ejercicio_id',
        'series',
        'repeticiones',
        'peso',
        'descanso_segundos',
        'orden',
    ];

    public function sesion()
    {
        return $this->belongsTo(SesionesEntrenamiento::class, 'sesiones_entrenamientos_id');
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id');
    }
}
