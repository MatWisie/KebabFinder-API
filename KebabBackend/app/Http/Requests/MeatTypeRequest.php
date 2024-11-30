<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeatTypeRequest extends FormRequest
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
        return [
            'name' => 'required|string|unique:meat_types|max:100',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Meat name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name can have a maximum length of 100 characters.',
        ];
    }
}
