<?php

namespace App\Http\Requests\Alumnos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $alumnoId = $this->route('alumno')?->id;

        return [
            'nombres'          => 'required|string|max:255',
            'apellidos'        => 'required|string|max:255',
            'genero'           => 'required|in:masculino,femenino',
            'fecha_nacimiento' => 'required|date',
            'altura_cm'        => 'required|integer|min:1',
            'peso_inicial_kg'  => 'nullable|numeric|min:0',
            'telefono'         => 'nullable|string|max:50',
            'email'            => ['nullable', 'email', Rule::unique('alumnos', 'email')->ignore($alumnoId)],
            'objetivo'         => 'nullable|string',
            'estado'           => 'required|in:activo,en_pausa,inactivo',
            'notas'            => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'nombres.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género debe ser masculino o femenino.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
            'altura_cm.required' => 'La altura es obligatoria.',
            'altura_cm.integer' => 'La altura debe ser un número entero.',
            'altura_cm.min' => 'La altura debe ser mayor o igual a 1.',
            'peso_inicial_kg.numeric' => 'El peso inicial debe ser un número.',
            'peso_inicial_kg.min' => 'El peso inicial debe ser mayor o igual a 0.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activo, en pausa o inactivo.',
        ];
    }
}
