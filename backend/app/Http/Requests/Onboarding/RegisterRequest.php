<?php

namespace App\Http\Requests\Onboarding;

use App\Http\Requests\BaseValidationRequest;
use App\Http\Requests\Rules\Concerns\HasPasswordValidationTrait;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseValidationRequest
{
    use HasPasswordValidationTrait;
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
            'first_name' => ['string', 'required', 'max:225'],
            'last_name' => ['string', 'required', 'max:225'],
            'email' => ['email', 'required', 'max:225', Rule::unique(User::class)],
            'password' => ['required', 'string', 'confirmed', $this->passValidationRules()],
            'phone' => ['nullable', 'string'],
        ];
    }
}
