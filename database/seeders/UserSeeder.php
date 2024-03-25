<?php

namespace Database\Seeders;

use App\Models\User;
use  App\Models\Location;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = collect([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@funvilla.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                // 'location_id' => '',
                'role' => 'super-admin',

            ],
            [
                'name' => 'Admin',
                'email' => 'admin@funvilla.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'location_id' => 1,
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'email' => 'user@funvilla.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'location_id' => 2,
                'role' => 'user',
            ],
        ]);

        $users->map(function ($user) {
            $user = collect($user);
            $newUser = User::create($user->except('role')->toArray());
            $newUser->assignRole($user['role']);
        });
    }
}