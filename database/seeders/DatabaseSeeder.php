<?php

namespace Database\Seeders;

use App\Models\BmeBrand;
use App\Models\HubLink;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() == 0) {
            $this->call([
                AdminUsersSeeder::class,
            ]);
        }

        if (Role::count() == 0) {
            $this->call([
                RoleSeeder::class,
            ]);
        }

        if (UserRole::count() == 0) {
            $this->call([
                UserRoleSeeder::class,
            ]);
        }

        if (HubLink::count() == 0) {
            $this->call([
                HubLinkSeeder::class,
            ]);
        }

        if (BmeBrand::count() == 0) {
            $this->call([
                BmeSeeder::class,
            ]);
        }
    }
}
