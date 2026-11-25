<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Raka Pratama',
            'email' => 'raka@flipplay.test',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Nadia Putri',
            'email' => 'nadia@flipplay.test',
            'password' => Hash::make('password123'),
        ]);
    }
}