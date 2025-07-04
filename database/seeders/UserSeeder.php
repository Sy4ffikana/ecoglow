<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@ecoglow.com',
            'password' => Hash::make('12345678'),
            'is_admin' => 0, 
        ]);
    }
}
