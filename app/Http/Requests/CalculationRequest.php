<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expression' => [
                'required',
                'string',
                'max:500',
                'regex:/^[a-zA-Z0-9\s\+\-\*\/\^\(\)\.!,]+$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'expression.regex' => __('calculator.invalid_characters'),
        ];
    }
}
