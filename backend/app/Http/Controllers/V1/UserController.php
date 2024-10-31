<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\OnboardingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProviderResource;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Http\Requests\Onboarding\UpdateUserProviderRequest;

class UserController extends Controller
{
    public function __construct(
        protected OnboardingService $onboardingService
    )
    {
        
    }

    public function me(): JsonResponse
    {
        return (new ApiResponse(
            data: UserResource::make(auth()->user())->toArray(request()),
            message: 'User retrieved successfully'
        ))->asSuccessful();
    }
}
