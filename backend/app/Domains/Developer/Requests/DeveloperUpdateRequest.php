<?php

namespace App\Domains\Developer\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeveloperUpdateRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse($validator->errors()->first(), 400, $validator->errors()->toArray())
        );
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'level_id' => ['integer', 'exists:levels,id'],
            'gender' => ['string', 'in:M,F'],
            'birth_date' => ['date', 'date_format:Y-m-d', 'before_or_equal:today', 'after_or_equal:today -100 years'],
            'hobby' => ['string', 'max:255'],
        ];
    }
}
