<?php

namespace App\Http\Requests\Entrenamiento;

use Illuminate\Foundation\Http\FormRequest;

class PlanesEntrenamientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'alumno_id' => 'required|exists:alumnos,id',
            'nombre' => 'required|string|min:3|max:255',
            'objetivo' => 'nullable|string|max:1000',
            'frecuencia_semanal' => 'required|integer|min:1|max:7',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'alumno_id.required' => 'El alumno es obligatorio.',
            'alumno_id.exists' => 'El alumno seleccionado no existe.',
            'nombre.required' => 'El nombre del plan es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'objetivo.max' => 'El objetivo no puede exceder 1000 caracteres.',
            'frecuencia_semanal.required' => 'La frecuencia semanal es obligatoria.',
            'frecuencia_semanal.integer' => 'La frecuencia semanal debe ser un número.',
            'frecuencia_semanal.min' => 'La frecuencia semanal debe ser al menos 1 día.',
            'frecuencia_semanal.max' => 'La frecuencia semanal no puede exceder 7 días.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
        ];
    }
}
