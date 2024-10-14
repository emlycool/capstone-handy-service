<?php
namespace App\Actions\Provider\Service;

use App\Models\ServiceProviderService;

class GetServiceAction
{
    public function handle(int $id): ?ServiceProviderService
    {
        return ServiceProviderService::find($id);
    }
}