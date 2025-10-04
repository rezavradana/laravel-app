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
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'nama' => 'Reza',
            'role' => 'Admin',
        ]);
    }
}
