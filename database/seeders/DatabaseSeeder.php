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
            'role_name' => 'Administrator',
        ]);

        Role::create([
            'role_name' => 'Direktur',
        ]);

        Role::create([
            'role_name' => 'Manager',
        ]);
        Role::create([
            'role_name' => 'Supervisor',
        ]);
        Role::create([
            'role_name' => 'Staff & Guru',
        ]);
        Role::create([
            'role_name' => 'Perpustakaan',
        ]);

        Units::create([
            'name' => 'UKA',
        ]);

        Units::create([
            'name' => 'SD1',
        ]);

        Units::create([
            'name' => 'SD2',
        ]);

        Units::create([
            'name' => 'SD3',
        ]);

        Units::create([
            'name' => 'SMP',
        ]);

        Units::create([
            'name' => 'SMA',
        ]);

        Category::create([
            'name' => 'PDF',
        ]);

        Category::create([
            'name' => 'Document',
        ]);

        Category::create([
            'name' => 'Foto & Video',
        ]);

        User::create([
            'name' => 'IT YPPSB',
            'username' => 'IT',
            'email' => 'ityppsb@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => '1',
            'unit_id' => '1',
        ]);
        User::create([
            'name' => 'Perpustakaan',
            'username' => 'perpus',
            'email' => 'perpus@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => '6',
            'unit_id' => '1',
        ]);

        User::factory(5)->create();
    }
}