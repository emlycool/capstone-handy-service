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
            'business_logo' => $this->logo->url ?? [
                'url' => $this->logoPlaceHolder(),
                'thumb' => $this->logoPlaceHolder()
            ],
            'address' => $this->address
        ];
    }

    private function logoPlaceHolder(): string
    {
        return "https://ui-avatars.com/api/?" . http_build_query([
            'background' => '0D8ABC',
            'color' => 'fff',
            'name' => $this->business_name
        ]);
    }
}
