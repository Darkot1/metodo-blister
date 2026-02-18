<?php

namespace App\Models\Ejercicios;

use App\Models\Ejercicios\Ejercicio;

use Illuminate\Database\Eloquent\Model;

class TipoEjercicio extends Model
{
    protected $table = 'tipo_ejercicios';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class);
    }
}
