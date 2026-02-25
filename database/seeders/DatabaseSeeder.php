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
            ['email' => 'super_admin@socialplus.com'],
            [
                'name' => 'Serena Nassif',
                'email' => 'serenanassif2002@gmail.com',
                'phone' => '+96171195101',
                'password' => Hash::make('qwe123'),
                'role' => 'super_admin',
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );
    }
}
