<?php

namespace App\Http\Controllers\V1;

use App\Actions\User\RegisterUserAction;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    )
    {
        
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->attemptLogin($request->email, $request->password);
        return (new ApiResponse(
            data: [
                'user' => UserResource::make($data['user']),
                'auth' => $data['auth']
            ]
        ));
    }

    public function sendForgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->sendForgotPassword($request->email);
        return (new ApiResponse(
            message: "Reset password OTP sent successfully"
        ));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword(
            $request->email,
            $request->password,
            $request->otp
        );
        return (new ApiResponse(
            message: "Password reset successfully"
        ));
    }

    public function logout()
    {
        $this->authService->logout();
        return (new ApiResponse(
            message: "Logged out successfully"
        ));
    }
}
