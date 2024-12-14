<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SauceTypeRequest extends FormRequest
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
            'name' => 'required|string|unique:sauce_types|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Sauce name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name can have a maximum length of 100 characters.',
        ];
    }
}
