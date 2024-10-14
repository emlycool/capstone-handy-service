<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\RegisterRequest;
use App\Http\Requests\Onboarding\StoreProviderRequest;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\UserResource;
use App\Services\OnboardingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function __construct(
        protected OnboardingService $onboardingService
    )
    {

    }

    public function registerUser(RegisterRequest $request): JsonResponse
    {
        $data = $this->onboardingService->registerUser($request->validated());
        return (new ApiResponse(
            data: [
                'user' => UserResource::make($data['user']),
                'auth' => $data['auth']
            ]
        ))->asCreated();
    }

    public function storeProvider(StoreProviderRequest $request): JsonResponse
    {
        $provider = $this->onboardingService->storeProvider($request->user(), $request->validated());

        return (new ApiResponse(
            data: ProviderResource::make($provider)->toArray($request)
        ))->asCreated(); 
    }

    public function listProvinces(): JsonResponse
    {
        $provinces = $this->onboardingService->listProvinces();

        return (new ApiResponse(
            data: $provinces
        ))->asSuccessful(); 
    }    

    public function listCities(): JsonResponse
    {
        $cities = $this->onboardingService->listCities();

        return (new ApiResponse(
            data: $cities
        ))->asSuccessful(); 
    }    
}
