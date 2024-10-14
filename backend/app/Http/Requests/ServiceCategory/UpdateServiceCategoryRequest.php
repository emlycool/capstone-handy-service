<?php

namespace App\Http\Requests\ServiceCategory;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseValidationRequest;
use App\Models\Service;

class UpdateServiceCategoryRequest extends BaseValidationRequest
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
            'id' => ['required', Rule::exists(Service::class)],
            'name' => ['required', Rule::unique(Service::class)->where('id', '<>', $this->id), 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}