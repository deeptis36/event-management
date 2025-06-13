<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // truncate table
        // DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'eventadmin@yopmail.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
                'remember_token' => null,
                'created_at' => Carbon::parse('2025-05-26 08:56:21'),
                'updated_at' => Carbon::parse('2025-05-26 08:56:21'),
            ],
            [
                'id' => 2,
                'name' => 'Reviewer User',
                'email' => 'reviewer@yopmail.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'), // hashed
                'remember_token' => null,
                'created_at' => Carbon::parse('2025-05-26 08:56:21'),
                'updated_at' => Carbon::parse('2025-05-26 08:56:21'),
            ],
            [
                'id' => 3,
                'name' => 'Speaker User',
                'email' => 'speaker@yopmail.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
                'remember_token' => null,
                'created_at' => Carbon::parse('2025-05-26 08:56:21'),
                'updated_at' => Carbon::parse('2025-05-26 08:56:21'),
            ],
        ]);
    }
}
