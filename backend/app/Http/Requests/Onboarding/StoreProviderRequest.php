<?php

namespace App\Http\Requests\Onboarding;

use App\Http\Requests\BaseValidationRequest;
use App\Models\Provider;
use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProviderRequest extends BaseValidationRequest
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
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'business_name' => ['required', Rule::unique(Provider::class, 'business_name')->where("user_id", "<>", $this->user()?->id), 'string', 'max:225'],
            'city' => ['required', 'string', 'max:225'],
            'business_phone' => ['required', 'string'],
            'business_email' => ['required', 'email'],
            'address' => ['required', 'string', 'max:255'],
            'business_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'business_description' => ['nullable', 'string']
        ];
    }
}
