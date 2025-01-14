<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'kebab_id' => 'required|exists:kebabs,id',
            'content' => 'required|string|max:100',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'kebab_id.required' => 'You must specify a kebab to report.',
            'kebab_id.exists' => 'The specified kebab does not exist.',
            'content.required' => 'Content of the comment is required.',
            'content.string' => 'Content must be a valid string.',
            'content.max' => 'Content can have a maximum length of 100 characters.',
        ];
    }
}
