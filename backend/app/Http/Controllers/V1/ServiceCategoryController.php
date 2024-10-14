<?php

namespace App\Http\Controllers\V1;

use App\Actions\Provider\ServiceCategory\DeleteServiceCategoryAction;
use App\Actions\Provider\ServiceCategory\GetServiceCategoryAction;
use App\Actions\Provider\ServiceCategory\StoreServiceCategoryAction;
use App\Actions\Provider\ServiceCategory\UpdateServiceCategoryAction;
use App\Exceptions\ApiNotFoundException;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceCategory\StoreServiceCategoryRequest;
use App\Http\Requests\ServiceCategory\UpdateServiceCategoryRequest;
use Illuminate\Http\JsonResponse;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceCategory = resolve(GetServiceCategoryAction::class)->handle();
        
        return (new ApiResponse(
            data: $serviceCategory->toArray(),
            message: 'Service categories retrived successfully',
        ))->asSuccessful();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceCategoryRequest $request): JsonResponse
    {
        $serviceCategory = resolve(StoreServiceCategoryAction::class)
            ->handle($request->validated());   

        return (new ApiResponse(
            data: $serviceCategory->toArray(),
            message: 'Service category created successfully',
        ))->asCreated();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceCategory = resolve(GetServiceCategoryAction::class)->handle($id)->first();
        
        throw_if(!$serviceCategory, new ApiNotFoundException('Service category not found.'));

        return (new ApiResponse(
            data: $serviceCategory->toArray(),
            message: 'Service category retrived successfully',
        ))->asCreated();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceCategoryRequest $request)
    {
        $serviceCategory = resolve(GetServiceCategoryAction::class)->handle($request->id)->first();
        resolve(UpdateServiceCategoryAction::class)
            ->handle($serviceCategory, $request->validated());   

        return (new ApiResponse(
            data: $serviceCategory->toArray(),
            message: 'Service category created successfully',
        ))->asSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceCategory = resolve(GetServiceCategoryAction::class)->handle($id)->first();
        
        throw_if(!$serviceCategory, new ApiNotFoundException('Service category not found.'));

        resolve(DeleteServiceCategoryAction::class)
            ->handle($serviceCategory);  

        return (new ApiResponse(
            message: 'Service category deleted successfully',
        ))->asSuccessful();
    }
}
