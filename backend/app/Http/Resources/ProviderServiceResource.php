<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderServiceResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'service' => [
                'id' => $this->category?->id,
                'name' => $this->category->name,
                'description' => $this->category->description
            ],
            'provider' => $this->when(
                ! ($this->whenLoaded('provider') instanceof MissingValue) &&
                !is_null($this->provider),
                ProviderResource::make($this->provider),
                null
            ),
            // 'user' => new UserResource($this->user),
            'price' => $this->price,
            'price_model' => $this->price_model,
            'duration_minutes' => $this->duration_minutes,
            'working_hours' => $this->working_hours,
            'included_benefits' => $this->included_benefits,
            'images' => $this->images,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
