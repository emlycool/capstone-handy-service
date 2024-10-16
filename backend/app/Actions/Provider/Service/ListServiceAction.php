<?php
namespace App\Actions\Provider\Service;

use Illuminate\Support\Arr;
use App\Models\ServiceProviderService;
use Illuminate\Pagination\LengthAwarePaginator;

class ListServiceAction
{
    public function handle($data): LengthAwarePaginator
    {
        $services = ServiceProviderService::query()
            ->with([
                'category:id,name,description',
                'provider:providers.id,business_name,business_phone,business_email,address,city,province_id',
                'provider.province:id,name,code',
                'media'
            ])
            ->when(
                Arr::get($data, 'province_id'),
                fn($query) => $query->whereHas('provider', fn($q) => $q->where('province_id', Arr::get($data, 'province_id')))
            )->when(
                Arr::get($data, 'category_id'),
                fn($query) => $query->whereHas('category', fn($q) => $q->where('id', Arr::get($data, 'category_id')))
            )->when(
                Arr::get($data, 'search'),
                fn($query) => $query->where(function($query) use($data){
                    $query->whereHas(
                        'provider', 
                        fn($q) => $q->where('business_name', 'like', '%' . Arr::get($data, 'search') . '%')
                    )->orWhereHas(
                        'category',
                        fn($q) => $q->where('name', 'like', '%' . Arr::get($data, 'search') . '%')
                    )->orWhere("name", "like", "%" . Arr::get($data, 'search') . "%");
                })
            )
            ->orderBy(\DB::raw("service_provider_services.id"), Arr::get($data, 'order_by', 'desc'))
            ->paginate(Arr::get($data, 'limit', 10));

        return $services;
    }
}