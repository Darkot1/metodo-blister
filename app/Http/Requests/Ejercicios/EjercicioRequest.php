<?php

namespace App\Http\Requests\Ejercicios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EjercicioRequest extends FormRequest
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
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ejercicios', 'nombre')->ignore($this->route('ejercicio')?->id)
            ],
            'descripcion' => 'nullable|string',
            'grupo_muscular' => 'required|string|max:100',
            'tipo_ejercicio_id' => 'required|exists:tipo_ejercicios,id',
            'nivel' => 'required|in:principiante,intermedio,avanzado',
            'video_url' => 'nullable|url|max:500',
            'estado' => 'required|in:activo,inactivo',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del ejercicio es obligatorio',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres',
            'nombre.unique' => 'Ya existe un ejercicio con este nombre. Por favor usa otro',
            'grupo_muscular.required' => 'El grupo muscular es obligatorio',
            'tipo_ejercicio_id.required' => 'Debes seleccionar un tipo de ejercicio',
            'tipo_ejercicio_id.exists' => 'El tipo de ejercicio seleccionado no es válido',
            'nivel.required' => 'El nivel es obligatorio',
            'nivel.in' => 'El nivel debe ser principiante, intermedio o avanzado',
            'video_url.url' => 'La URL del video debe ser válida',
            'estado.required' => 'El estado es obligatorio',
            'estado.in' => 'El estado debe ser activo o inactivo',
        ];
    }
}
