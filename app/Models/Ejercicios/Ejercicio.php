<?php

namespace App\Models\Ejercicios;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ejercicios\TipoEjercicio;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ejercicio extends Model
{

    use HasFactory;

    protected $table = 'ejercicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'grupo_muscular', 
        'tipo_ejercicio_id', 
        'nivel', 
        'video_url', 
        'estado'
        ];

    public function tipoEjercicio()
    {
        return $this->belongsTo(TipoEjercicio::class);
    }
}
