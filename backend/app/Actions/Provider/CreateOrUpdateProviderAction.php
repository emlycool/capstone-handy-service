<?php
namespace App\Actions\Provider;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Arr;

class CreateOrUpdateProviderAction
{
    public function handle(User $user, array $data): Provider
    {
        return Provider::updateOrCreate([
            'user_id' => $user->id,
        ], Arr::only($data, [
            'province_id',
            'business_name',
            'city',
            'business_phone',
            'business_email',
            'address'
        ]));
    }
}