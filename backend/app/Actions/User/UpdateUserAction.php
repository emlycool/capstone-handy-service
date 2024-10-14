<?php
namespace App\Actions\User;

use App\Models\User;

class UpdateUserAction
{
    public function handle(User $user, array $data): bool
    {
        return $user->update($data);
    }
}