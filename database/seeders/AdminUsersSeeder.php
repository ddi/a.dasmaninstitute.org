<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminUsers = [
            ['id' => 1000, 'person_id' => 99633, 'username' => 'mohammad.alqersh'],
            ['id' => 1001, 'person_id' => 99839, 'username' => 'hashem.behbehani'],
            //['id' => 1002, 'person_id' => 99702,'username' => 'moataz.khamis'],
        ];

        foreach ($adminUsers as $adminUser) {
            // $sql = "SELECT userId AS person_id FROM users WHERE username = '" . $adminUser['username'] . "'";
            // $personId = DB::connection('hellohealth')->select($sql);
            // $adminUser['person_id'] = $personId[0]->person_id;
            User::create($adminUser);
        }
    }
}
