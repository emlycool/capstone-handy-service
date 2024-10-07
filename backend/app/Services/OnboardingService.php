<?php
namespace App\Services;

use App\Actions\User\RegisterUserAction;
use App\Actions\User\SendEmailVerficationMailAction;
use Illuminate\Pipeline\Pipeline;

class OnboardingService
{
    public function __construct(
        protected AuthService $authService
    )
    {
        
    }

    public function registerUser(array $data)
    {
        $data = app(Pipeline::class)
            ->send($data)
            ->through([
                RegisterUserAction::class,
                SendEmailVerficationMailAction::class
            ])
            ->then(function (array $data) {
                return $data;
            });

        $token = $this->authService->login($data['user']);
        $data['auth'] = $this->authService->authResponse($token);
        return $data;
    }
}