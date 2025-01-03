<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseValidationRequest;
use App\Http\Requests\Rules\Concerns\HasPasswordValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends BaseValidationRequest
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
            'email' => ['required', 'email'],
            'password' => [ 'required', 'confirmed', $this->passValidationRules()],
            'otp' => ['required', 'digits:6']
        ];
    }
}
