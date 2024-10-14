<?php
namespace App\Services;

use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use App\Exceptions\ApiException;
use Illuminate\Http\UploadedFile;
use App\Models\ServiceProviderService;
use App\Actions\Provider\Service\StoreServiceAction;
use App\Actions\Provider\Service\UpdateServiceAction;

class ProviderService
{
    public function __construct()
    {
        
    }

    public function storeService(array $requestData): ServiceProviderService
    {
        $service = resolve(StoreServiceAction::class)->handle([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'price' => $requestData['price'],
            'service_id' => $requestData['service_category_id'],
            'included_benefits' => $requestData['included_benefits'],
            'price_model' => $requestData['price_model'],
            "duration_minutes" => $requestData['duration'],
            "working_hours" => $requestData['working_hours']
        ], auth()->user());

        $this->storeServiceImages($service, $requestData['images'] ?? []);

        return $service;
    }

    private function storeServiceImages(ServiceProviderService $service, array $images): void
    {
        foreach ($images as $image) {
            if($image instanceof UploadedFile){
                $service->addMedia($image)
                    ->usingFileName(basename(Str::slug($service->name)) . "." . $image->getClientOriginalExtension())    
                    ->toMediaCollection();
            }
        }
    }

    public function updateService(ServiceProviderService $service, array $requestData): ServiceProviderService
    {
        resolve(UpdateServiceAction::class)->handle($service, [
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'price' => $requestData['price'],
            'service_id' => $requestData['service_category_id'],
            'included_benefits' => $requestData['included_benefits'],
            'price_model' => $requestData['price_model'],
            "duration_minutes" => $requestData['duration'],
            "working_hours" => $requestData['working_hours']
        ]);

        $this->storeServiceImages($service, $requestData['images']);

        #TODO: Delete removed images
        
        return $service;
    }

    public function checkWritePermissions(?User $user, ServiceProviderService $service):void
    {
        throw_if($service->service_provider_id != $user?->id, new ApiException(msg: "Unauthorized to perform action on this service"));
    }
}