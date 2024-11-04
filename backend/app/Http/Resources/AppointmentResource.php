<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client' => [
                'id' => $this->client->id,
                'first_name' => $this->client->first_name,
                'last_name' => $this->client->last_name,
                'email' => $this->client->email,
                'phone' => $this->client->phone,
            ],
            'service_category' => [
                'id' => $this->serviceCategory->id,
                'name' => $this->serviceCategory->name,
                'description' => $this->serviceCategory->description,
            ],
            'provider' => ProviderResource::make($this->providerUser?->provider),
            'service' => ProviderServiceResource::make($this->service),
            'appointment_start_date' => $this->appointment_start_date,
            'appointment_end_date' => $this->appointment_end_date,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
