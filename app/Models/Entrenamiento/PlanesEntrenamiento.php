<?php

namespace App\Models\Entrenamiento;

use App\Models\Alumnos\Alumno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PlanesEntrenamiento extends Model
{
    use HasFactory;
    
    protected $table = 'planes_entrenamientos';

    protected $fillable = [
        'alumno_id',
        'nombre',
        'objetivo',
        'frecuencia_semanal',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    //public function semanas()
    //{
    //    return $this->hasMany(SemanaEntrenamiento::class, 'plan_entrenamiento_id');
    //}
}
