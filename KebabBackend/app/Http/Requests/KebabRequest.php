<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KebabRequest extends FormRequest
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
            'name' => 'required|string',
            'address' => 'required|string',
            'coordinates' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $coordinates = explode(',', $value);
                    if (count($coordinates) !== 2) {
                        return $fail('The coordinates must contain exactly two values (latitude and longitude).');
                    }

                    $latitude = trim($coordinates[0]);
                    $longitude = trim($coordinates[1]);

                    if (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
                        return $fail('The latitude must be a valid number between -90 and 90.');
                    }

                    if (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
                        return $fail('The longitude must be a valid number between -180 and 180.');
                    }
                },
            ],
            'logo_link' => 'nullable|url',
            'open_year' => 'nullable|integer|digits:4',
            'closed_year' => 'nullable|integer|digits:4',
            'status' => 'required|in:open,closed,planned',
            'is_craft' => 'required|boolean',
            'building_type' => 'required|string',
            'is_chain' => 'required|boolean',
            'sauces' => 'array|exists:sauce_types,id',
            'meats' => 'array|exists:meat_types,id',
            'social_media_links' => 'array',
            'opening_hours' => 'array',
            'order_ways' => 'array'
        ];
    }
    /**
     * Get the custom messages for the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'coordinates.required' => 'The coordinates field is required.',
            'coordinates.string' => 'The coordinates must be a string.',
            'coordinates.regex' => 'The coordinates format is invalid.',
            'social_media_links.array' => 'The social media links must be an array.',
            'opening_hours.array' => 'The opening hours must be an array.',
            'order_ways.array' => 'The order ways must be an array.',
        ];
    }
}
