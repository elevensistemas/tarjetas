<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsvpRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50|unique:guests,phone',
            'assistants_count' => 'required|integer|min:0|max:20',
            'is_attending' => 'required|boolean',
            'dietary_restrictions' => 'nullable|string|max:1000',
            'comments' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre y apellido es obligatorio.',
            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.unique' => 'Ya existe una confirmación registrada con este número de teléfono.',
            'assistants_count.required' => 'Debes ingresar la cantidad de asistentes.',
            'assistants_count.min' => 'La cantidad de asistentes debe ser al menos 0.',
            'assistants_count.max' => 'La cantidad máxima de asistentes por invitación es 20.',
            'is_attending.required' => 'Debes confirmar si asistes o no.',
        ];
    }
}
