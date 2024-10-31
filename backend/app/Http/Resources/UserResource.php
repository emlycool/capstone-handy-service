<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'email_verified' => $this->email_verified,
            'phone' => $this->phone,
            'onboarded_on' => $this->created_at,
            'provider' => ProviderResource::make($this->provider),
            'roles' => $this->roles->pluck('name'),
            'avatar' => $this->avatar ? $this->avatar : $this->defaultAvatar()
        ];
    }

    private function defaultAvatar(): string
    {
        return "https://ui-avatars.com/api/?" . http_build_query([
            'background' => '0D8ABC',
            'color' => 'fff',
            'name' => $this->first_name . ' ' . $this->last_name
        ]);
    }
}
