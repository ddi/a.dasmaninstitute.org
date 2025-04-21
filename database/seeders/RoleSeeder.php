<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultRoles = [
            [
                'id' => 1000,
                'name' => 'ROLE_sa',
                'display_name' => '',
                'description' => ''
            ],
            [
                'id' => 1001,
                'name' => 'ROLE_admin',
                'display_name' => 'Administrator',
                'description' => ''
            ],
            [
                'id' => 1002,
                'name' => 'ROLE_hd',
                'display_name' => 'Help Desk',
                'description' => 'add user, updated user roles, manage gate employees list, manage hub links'
            ],
        ];

        foreach ($defaultRoles as $role) {
            Role::create($role);
        }
    }
}
