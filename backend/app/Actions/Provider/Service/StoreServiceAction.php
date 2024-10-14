<?php
namespace App\Actions\Provider\Service;

use App\Models\User;
use App\Models\Service;
use App\Models\ServiceProviderService;
use Illuminate\Support\Arr;

class StoreServiceAction
{
    public function handle($data, User $user): ServiceProviderService
    {
        return $user->services()->create(Arr::only($data, [
            'name',
            'service_id',
            'description',
            'included_benefits',
            'price_model',
            "duration_minutes",
            "working_hours"
        ]));
    }
}