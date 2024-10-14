
<?php
namespace App\Actions\Provider\Service;

use App\Models\Service;
use App\Models\User;
use App\Models\ServiceProviderService;
use Illuminate\Support\Arr;

class UpdateServiceAction
{
    public function handle(ServiceProviderService $service, array $requstData): int
    {
        return $service->update(Arr::only($requstData, [
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