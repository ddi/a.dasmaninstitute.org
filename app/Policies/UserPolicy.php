<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends Policy
{
    public function manage(User $user): bool
    {
        if ($user->roles()->where('name', 'ROLE_admin')->exists()) {
            return true;
        }
        return false;
    }
}
