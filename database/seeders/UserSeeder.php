<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@pertamina.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Default user
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Default User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Some additional users
        foreach ([
            ['name' => 'Operator 1', 'email' => 'operator1@pertamina.com'],
            ['name' => 'Operator 2', 'email' => 'operator2@pertamina.com'],
            ['name' => 'Security 1', 'email' => 'security1@gmail.com'],
        ] as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
