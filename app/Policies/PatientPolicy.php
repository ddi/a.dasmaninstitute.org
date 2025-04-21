<?php

namespace App\Policies;

use App\Models\User;

class PatientPolicy
{
    public function search(User $user): bool
    {
        if ($user->roles()->where('name', 'ROLE_med_him')->exists()) {
            return true;
        }
        return false;
    }

    public function printConsentForm(User $user): bool
    {
        if ($user->roles()->where('name', 'ROLE_med_him')->exists()) {
            return true;
        }
        return false;
    }
}
