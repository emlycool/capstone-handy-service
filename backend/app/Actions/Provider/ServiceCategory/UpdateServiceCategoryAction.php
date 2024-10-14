<?php
namespace App\Actions\Provider\ServiceCategory;

use App\Models\Service;

class UpdateServiceCategoryAction
{
    public function handle(Service $service, array $data): bool
    {
        return $service?->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }
}