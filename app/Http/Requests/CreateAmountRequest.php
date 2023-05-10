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
     * @description You need to edit the regular expression to extend the currencies.
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.currency' => ['required', 'regex:/(EUR)|(USD)|(GBP)|(eur)|(usd)|(gbp)/'],
            '*.date'     => ['date_format:Y-m-d'],
            '*.amount'   => ['required', 'numeric', 'regex:/^(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.currency.required' => 'Currency name is required.',
            '*.currency.regex'    => 'Only EUR, USD, GBP currencies.',
            '*.amount.required'   => 'Value is required.',
            '*.amount.numeric'    => 'The value must be a number.',
            '*.amount.regex'      => 'The value must be positiver.',
            '*.date'              => 'Invalid date format. Date in Y-m-d format.'
        ];
    }
}
