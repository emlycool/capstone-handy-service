<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseValidationRequest;
use App\Http\Requests\Rules\Concerns\HasPasswordValidationTrait;
use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends BaseValidationRequest
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
            'current_password' => ['required', $this->passValidationRules(), function(string $attribute, mixed $value, Closure $fail){
                $matches =  Hash::check($value, $this->user()->password);
                if(!$matches) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => ['required', $this->passValidationRules()],
        ];
    }
}
