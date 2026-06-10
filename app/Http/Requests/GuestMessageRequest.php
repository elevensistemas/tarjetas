<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestMessageRequest extends FormRequest
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
            'guest_name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'guest_name.required' => 'Tu nombre es obligatorio.',
            'message.required' => 'La dedicatoria es obligatoria.',
            'message.max' => 'El mensaje no debe superar los 1000 caracteres.',
        ];
    }
}
