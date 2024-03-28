<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Units;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name' => 'Owner',
        ]);

        Role::create([
            'role_name' => 'Administrator',
        ]);

        Category::create([
            'name' => 'CCTV',
        ]);

        Category::create([
            'name' => 'Router',
        ]);

        Category::create([
            'name' => 'Cable',
        ]);

        User::create([
            'name' => 'Kirayu',
            'username' => 'owner',
            'email' => 'kirayu@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => '1',
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => '2',
        ]);
    }
}
