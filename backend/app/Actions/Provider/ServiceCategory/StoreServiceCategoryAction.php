<?php
namespace App\Actions\Provider\ServiceCategory;

use App\Models\Service;

class StoreServiceCategoryAction
{
    public function handle(array $data): Service
    {
        return Service::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }
}