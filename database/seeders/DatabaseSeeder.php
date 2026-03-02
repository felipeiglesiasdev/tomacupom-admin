<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@tomacupom.com'],
            [
                'name' => 'ADMIN TOMA CUPOM',
                'password' => Hash::make('password123'),
                'role' => 'ADMIN',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'editor@tomacupom.com'],
            [
                'name' => 'EDITOR TOMA CUPOM',
                'password' => Hash::make('password123'),
                'role' => 'EDITOR',
                'email_verified_at' => now(),
            ]
        );
    }
}
