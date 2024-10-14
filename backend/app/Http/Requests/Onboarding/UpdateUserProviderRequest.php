<?php

namespace App\Http\Requests\Onboarding;

use App\Http\Requests\BaseValidationRequest;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProviderRequest extends BaseValidationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'province_id' => ['required', Rule::exists('pronvinces', 'id')],
            'business_name' => ['required', 'unique', 'string', 'max:225'],
            'city' => ['required', 'string', 'max:225'],
            'business_phone' => ['required', 'string'],
            'business_email' => ['required', 'email'],
            'address' => ['required', 'string', 'max:255']
        ];
    }
}
