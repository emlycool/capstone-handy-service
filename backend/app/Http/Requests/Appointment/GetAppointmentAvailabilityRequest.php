<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseValidationRequest;
use App\Models\ServiceProviderService;

class GetAppointmentAvailabilityRequest extends BaseValidationRequest
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
        ];
    }
}
