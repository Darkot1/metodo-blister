<?php

namespace App\Models\Entrenamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entrenamiento\PlanesEntrenamiento;
use App\Models\Entrenamiento\EjerciciosSesion;

class SesionesEntrenamiento extends Model
{
    use HasFactory;

    protected $table = 'sesiones_entrenamientos';

    protected $fillable = [
        'plan_entrenamiento_id',
        'muscle_group_id',
        'numero_semana',
        'dia_semana',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanesEntrenamiento::class, 'plan_entrenamiento_id');
    }

    public function ejercicios()
    {
        return $this->hasMany(EjerciciosSesion::class, 'sesiones_entrenamientos_id');
    }

    public function muscleGroup()
    {
        return $this->belongsTo(MuscleGroup::class, 'muscle_group_id');
    }

    public function muscleGroups()
    {
        return $this->belongsToMany(
            MuscleGroup::class,
            'muscle_group_sesion_entrenamiento',
            'sesion_entrenamiento_id',
            'muscle_group_id'
        );
    }
}
