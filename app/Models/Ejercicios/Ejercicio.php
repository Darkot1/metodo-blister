<?php

namespace App\Models\Ejercicios;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ejercicios\TipoEjercicio;
use App\Models\Entrenamiento\MuscleGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ejercicio extends Model
{

    use HasFactory;

    protected $table = 'ejercicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'muscle_group_id',
        'tipo_ejercicio_id',
        'nivel',
        'video_url',
        'estado'
    ];

    public function tipoEjercicio()
    {
        return $this->belongsTo(TipoEjercicio::class);
    }

    public function muscleGroup()
    {
        return $this->belongsTo(MuscleGroup::class);
    }
}
