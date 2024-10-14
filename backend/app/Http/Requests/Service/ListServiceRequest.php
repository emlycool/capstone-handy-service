<?php

namespace App\Http\Requests\Service;

use App\Http\Requests\BaseValidationRequest;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ListServiceRequest extends BaseValidationRequest
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
            'province_id' => ['nullable', 'integer', ],
            'category_id' => ['nullable', 'integer', ],
            ...$this->paginateAndFilterRules()
        ];
    }
}