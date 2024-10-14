<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseValidationRequest;
use App\Models\ServiceProviderService;

class BookAppointmentRequest extends BaseValidationRequest
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
            'provider_service_id' => ['required', Rule::exists(ServiceProviderService::class, "id")],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
