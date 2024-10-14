<?php
namespace App\Actions\Provider\ServiceCategory;

use App\Models\Service;
use Illuminate\Support\Collection;

class GetServiceCategoryAction
{
    public function handle(int|null $id = null): Collection
    {
        return Service::when(
            $id, 
            fn($query) => $query->where('id', $id)
        )->get([
            'id',
            'name',
            'description',
            'created_at'
        ]);
    }
}