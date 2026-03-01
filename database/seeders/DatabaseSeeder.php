<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin User
        User::firstOrCreate(
            ['email' => 'super_admin@esibsocial.com'],
            [
                'name' => 'Super Admin',
                'email' => 'super_admin@esibsocial.com',
                'phone' => '+9613123123',
                'password' => Hash::make('qwe123'),
                'role' => 'super_admin',
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );

        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@esibsocial.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@esibsocial.com',
                'phone' => '+9613123123',
                'password' => Hash::make('qwe123'),
                'role' => 'admin',
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );

        // Create  User
        User::firstOrCreate(
            ['email' => 'user@esibsocial.com'],
            [
                'name' => 'User',
                'email' => 'user@esibsocial.com',
                'phone' => '+9613123123',
                'password' => Hash::make('qwe123'),
                'role' => 'user',
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );
    }
}
