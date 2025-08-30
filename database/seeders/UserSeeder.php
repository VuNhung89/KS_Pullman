<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'adminexample@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // User thường
        User::firstOrCreate([
            'name' => 'Nhung',
            'email' => 'nhung@example.com',
            'password' => Hash::make('123456'),
            'role' => 'user',
        ]);
    }
}
