<?php
namespace App\Actions\User;

use App\Models\User;

class RegisterUserAction
{
    public function handle(array $data, \Closure|null $next = null): array
    {
        $user = User::create($data);
        $data['user'] = $user;
        if($next){
            $next($data);
        }
        return $data;
    }
}