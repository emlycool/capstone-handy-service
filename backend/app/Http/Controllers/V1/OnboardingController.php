<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\RegisterRequest;
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
        ))->asSuccessful();
    }
}
