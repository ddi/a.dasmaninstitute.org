<?php

namespace App\Policies;

use App\Models\HubLink;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HubLinkPolicy
{
    public function manage(User $user): bool
    {
        if ($user->roles()->where('name', 'ROLE_hd')->exists()) {
            return true;
        }
        return false;
    }
}
