<?php

namespace App\Http\Resources;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->province);
        return [
            'id' => $this?->id,
            'province_id' => $this->province_id,
            'province' => [
                'id' => $this->province->id,
                'name' => $this->province->name,
                'code' => $this->province->code
            ],
            'city' => $this->city,
            'business_name' => $this->business_name,
            'business_phone' => $this->business_phone,
            'business_email' => $this->business_email,
            'business_logo' => $this->logo,
            'address' => $this->address
        ];
    }
}
