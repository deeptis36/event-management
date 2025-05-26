<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist (in case RoleSeeder hasn't been run yet)
        $roles = ['admin', 'reviewer', 'speaker'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'eventadmin@yopmail.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $admin->assignRole('admin');

        // Create Reviewer User
        $reviewer = User::firstOrCreate(
            ['email' => 'reviewer@yopmail.com'],
            ['name' => 'Reviewer User', 'password' => bcrypt('password')]
        );
        $reviewer->assignRole('reviewer');

        // Create Speaker User
        $speaker = User::firstOrCreate(
            ['email' => 'speaker@yopmail.com'],
            ['name' => 'Speaker User', 'password' => bcrypt('password')]
        );
        $speaker->assignRole('speaker');
    }
}
