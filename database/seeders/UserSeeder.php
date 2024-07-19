<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $usersData = [
            [
                'username' => 'admin',
                'email'  => 'admin@admin.com',
                'user_role' => 'ADMIN',
                'password' => Hash::make('admin123'),
            ],
            [
                'username' => 'reviewer',
                'email' => 'reviewer@reviewer.com',
                'user_role' => 'REVIEWER',
                'password' => Hash::make('reviewer123'),
            ],
            [
                'username' => 'author',
                'email' => 'author@author.com',
                'user_role' => 'AUTHOR',
                'password' => Hash::make('author123'),
            ],
        ];
        foreach ($usersData as $key => $val) {
            User::create($val);
        }
    }
}
