<?php

namespace App\Policies;

use App\Models\User;

class Policy
{
    public function before(User $user): ?bool
    {
        if ($user->roles()->where('name', 'ROLE_sa')->exists()) {
            return true;
        }
        return null;
    }
}
