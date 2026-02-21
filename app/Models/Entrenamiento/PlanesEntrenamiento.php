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

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];


    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function sesiones()
    {
        return $this->hasMany(SesionesEntrenamiento::class, 'plan_entrenamiento_id');
    }


    // Calcular semanas 
    public function getNumeroSemanasAttribute()
    {
        return max(
            1,
            $this->fecha_inicio->diffInWeeks($this->fecha_fin)
        );
    }
}
