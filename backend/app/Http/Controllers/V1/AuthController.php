<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    )
    {
        
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->attemptLogin($request->email, $request->password);
        return (new ApiResponse(
            data: [
                'user' => UserResource::make($data['user']),
                'auth' => $data['auth']
            ]
        ))->asSuccessful();
    }

    public function sendForgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->authService->sendForgotPassword($request->email);
        return (new ApiResponse(
            message: "Reset password OTP sent successfully"
        ))->asSuccessful();
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->authService->resetPassword(
            $request->email,
            $request->password,
            $request->otp
        );
        return (new ApiResponse(
            message: "Password reset successfully"
        ))->asSuccessful();
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return (new ApiResponse(
            message: "Logged out successfully"
        ))->asSuccessful();
    }
}
