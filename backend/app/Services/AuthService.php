<?php
namespace App\Services;

use App\Models\User;
use App\Exceptions\ApiException;
use App\Helpers\AppUtil;
use App\Helpers\OtpHelper;
use App\Notifications\User\SendForgotPasswordNotification;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        protected OtpHelper $otpHelper
    )
    {
        
    }

    public function attemptLogin(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();
        if(!is_null($user) && $user->is_disabled){
            throw new ApiException('Your account has been disabled. Please contact support for more info.');
        }

        if (! $token = Auth::attempt([
            'email' => $email,
            'password' => $password
        ])) {
            throw new ApiException('The provided credentials are incorrect.');
        }

        return [
            'auth' => $this->authResponse($token),
            'user' => $user
        ];
    }

    public function login(User $user): string
    {
        return (string) auth('api')->login($user);
    }

    public function resetPassword(
        string $email,
        string $password,
        string $userOtp
    ): bool
    {
        $user = User::whereEmail($email)->first();
        if($user){
            $vaultOtp = $this->otpHelper->getOtp($user->email);
            $isValid = $this->otpHelper->check($vaultOtp, $userOtp);
            if(!$isValid){
                throw new ApiException("Otp is invalid");
            }
            return $this->updatePassword($user, $password);

        }
        return false;
    }

    private function updatePassword(User $user, string $password): bool
    {
        return $user->update([
            'password' => $password
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function sendForgotPassword(string $email): bool
    {
        $user = User::whereEmail($email)->first();
        if($user){
            $otp = $this->otpHelper->createOtp($email);
            AppUtil::defer(fn() => $user->notify(new SendForgotPasswordNotification($user, $otp)));
        }

        return true;
    }   

    public function changePassword(User $user, string $password)
    {
        $user->update([
            'password' => $password
        ]);
    }

    public function authResponse(string $token): array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->expireTtlInSeconds(),
        ];
    }

    public function expireTtlInSeconds(): int
    {
        return Auth::factory()->getTTL() * 60;
    }
}