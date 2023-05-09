<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAmountRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.currency' => 'required|string|max:3',
            '*.date'     => 'date_format:Y-m-d',
            '*.amount'   => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            '*.currency.required' => 'Currency name is required.',
            '*.currency.string'   => 'The currency name must be a string.',
            '*.currency.max'      => 'The maximum number of characters is max: :max',
            '*.amount.required'   => 'Value is required.',
            '*.amount.numeric'    => 'The value must be a number.',
            '*.date'              => 'Invalid date format. Date in Y-m-d format.'
        ];
    }
}
