<?php

namespace App\Models\Entrenamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionesEntrenamiento extends Model
{
    use HasFactory;
    
    protected $table = 'sesiones_entrenamientos';

    protected $fillable = [
        'plan_entrenamiento_id',
        'numero_semana',
        'nombre',
        'dia_semana',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanesEntrenamiento::class, 'plan_entrenamiento_id');
    }

    public function ejercicios()
    {
        //return $this->hasMany(EjercicioSesion::class, 'sesion_entrenamiento_id');
    }
}
