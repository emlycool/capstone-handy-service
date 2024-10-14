<?php

namespace App\Http\Requests\Service;

use App\Enums\PriceModelEnum;
use App\Models\Service;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseValidationRequest;

class StoreServiceRequest extends BaseValidationRequest
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
            'name' => ['required', 'string', 'max:225'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'price_model' => ['required', 'string', Rule::in(PriceModelEnum::valueArray())],
            'duration' => ['required', 'numeric'],
            'service_category_id' => ['required', Rule::exists(Service::class, 'id')],
            // 'images' => ['required', 'array'],
            // 'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:1024'],
            'working_hours' => ['required', 'array'],
            'working_hours.*.day' => ['required', 'string', 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday'],
            'working_hours.*.start_time' => ['required', 'date_format:H:i'],
            'working_hours.*.end_time' => ['required', 'date_format:H:i', 'after:working_hours.*.start_time'],
            'included_benefits' => ['required', 'array']
        ];
    }
}
