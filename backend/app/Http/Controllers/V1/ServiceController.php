<?php

namespace App\Http\Controllers\V1;

use App\Models\Service;
use Illuminate\Support\Arr;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ProviderService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiNotFoundException;
use App\Http\Resources\ProviderServiceResource;
use App\Actions\Provider\Service\GetServiceAction;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Actions\Provider\Service\ListServiceAction;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Actions\Provider\Service\DeleteServiceAction;
use App\Exceptions\ApiException;
use App\Http\Requests\Service\ListServiceRequest;

class ServiceController extends Controller
{
    public function __construct(
        protected ProviderService $providerService
    )
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListServiceRequest $request)
    {
        $services = resolve(ListServiceAction::class)->handle($request->validated());

        return (new ApiResponse(
            data: ProviderServiceResource::collection($services)->toArray(request()),
            message: 'Service created successfully',
            meta: Arr::except($services->toArray(), ['data'])
        ))->asSuccessful();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): JsonResponse
    {
        $service = $this->providerService->storeService($request->validated());
        
        return (new ApiResponse(
            data: ProviderServiceResource::make($service)->toArray(request()),
            message: 'Service created successfully',
        ))->asCreated();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = resolve(GetServiceAction::class)->handle($id);
        throw_if(!$service, new ApiNotFoundException(msg: "Service not found"));

        return (new ApiResponse(
            data: ProviderServiceResource::make($service)->toArray(request()),
            message: 'Service retrieved successfully',
        ))->asSuccessful();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id)
    {
        $service = resolve(GetServiceAction::class)->handle($id);
        throw_if(!$service, new ApiNotFoundException(msg: "Service not found"));

        $this->providerService->checkWritePermissions(auth()->user(), $service);

        $service = $this->providerService->updateService($service, $request->validated());
        return (new ApiResponse(
            data: ProviderServiceResource::make($service)->toArray(request()),
            message: 'Service updated successfully',
        ))->asSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = resolve(GetServiceAction::class)->handle($id);
        throw_if(!$service, new ApiNotFoundException(msg: "Service not found"));

        $this->providerService->checkWritePermissions(auth()->user(), $service);

        resolve(DeleteServiceAction::class)->handle($service);
        return (new ApiResponse(
            message: 'Service deleted successfully',
        ))->asSuccessful();
    }
}
