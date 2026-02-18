<?php

namespace App\Models\Alumnos;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'genero',
        'fecha_nacimiento',
        'altura_cm',
        'peso_inicial_kg',
        'telefono',
        'email',
        'objetivo',
        'estado',
        'notas',
    ];

    // casts para formatear fechas y decimales
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'peso_inicial_kg' => 'decimal:2',
    ];


    //relacion de alumno con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
