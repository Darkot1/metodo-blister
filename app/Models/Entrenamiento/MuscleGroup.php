<?php

namespace App\Models\Entrenamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuscleGroup extends Model
{
    use HasFactory;

    protected $table = 'muscle_groups';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
    ];

    public function sesiones()
    {
        return $this->hasMany(SesionesEntrenamiento::class, 'muscle_group_id');
    }

    public function sesionesMultiples()
    {
        return $this->belongsToMany(
            SesionesEntrenamiento::class,
            'muscle_group_sesion_entrenamiento',
            'muscle_group_id',
            'sesion_entrenamiento_id'
        );
    }
}
