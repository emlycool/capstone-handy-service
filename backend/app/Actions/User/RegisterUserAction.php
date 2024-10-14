<?php
namespace App\Actions\User;

use App\Models\User;

class RegisterUserAction
{
    public function handle(array $data, \Closure|null $next = null): array|User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            "phone" => $data['phone'] ?? null
        ]);
        $data['user'] = $user;
        if($next){
            $next($data);
        }
        return $user;
    }
}