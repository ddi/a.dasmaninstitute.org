<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initUserRoles = [
            [
                'user_id' => 1000,
                'role_id' => 1000,
            ],
        ];

        foreach ($initUserRoles as $userRoles) {
            UserRole::create($userRoles);
        }
    }
}
