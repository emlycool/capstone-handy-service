<?php
namespace App\Actions\Provider\Service;

use App\Models\ServiceProviderService;

class DeleteServiceAction
{
    public function handle(ServiceProviderService $service): int 
    {
        return $service->delete();
    }
}
