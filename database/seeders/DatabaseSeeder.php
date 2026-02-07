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
                'name' => 'Super Admin User',
                'email' => 'super_admin@socialplus.com',
                'phone' => '+1234567890',
                'password' => Hash::make('qwe123'),
                'role' => 'super_admin',
                'study_year' => null,
                'major' => null,
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );

        $this->command->info('Admin user created:');
        $this->command->info('Email: super_admin@socialplus.com');
        $this->command->info('Password: qwe123');
        
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@socialplus.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@socialplus.com',
                'phone' => '+1234567890',
                'password' => Hash::make('qwe123'),
                'role' => 'admin',
                'study_year' => null,
                'major' => null,
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );

        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@socialplus.com');
        $this->command->info('Password: qwe123');

        // Create Regular User
        User::firstOrCreate(
            ['email' => 'user@socialplus.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@socialplus.com',
                'phone' => '+1234567891',
                'password' => Hash::make('qwe123'),
                'role' => 'user',
                'study_year' => '2e',
                'major' => 'Science Economique et Gestion',
                'email_verified' => true,
                'email_verified_at' => now(),
                'two_factor_enabled' => false,
            ]
        );

        $this->command->info('Regular user created:');
        $this->command->info('Email: user@socialplus.com');
        $this->command->info('Password: qwe123');
        $this->command->info('Study Year: 2');
        $this->command->info('Major: Social Sciences');
    }
}
