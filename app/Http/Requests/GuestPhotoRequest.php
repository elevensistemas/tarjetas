<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestPhotoRequest extends FormRequest
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
            'photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240', // Max 10MB
            'comment' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'guest_name.required' => 'Tu nombre es obligatorio.',
            'photo.required' => 'La foto es obligatoria.',
            'photo.image' => 'El archivo debe ser una imagen válida.',
            'photo.mimes' => 'La foto debe estar en formato JPG, JPEG, PNG o WEBP.',
            'photo.max' => 'La foto no debe superar los 10 Megabytes (10MB).',
        ];
    }
}
