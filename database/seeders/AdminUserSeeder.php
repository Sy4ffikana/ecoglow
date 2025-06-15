<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ecoglow.com'],
            [
                'name' => 'Admin EcoGlow',
                'email' => 'admin@ecoglow.com',
                'password' => Hash::make('12345678'), // Change for production
                'is_admin' => true,
            ]
        );
    }
}

