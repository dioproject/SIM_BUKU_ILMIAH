<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $usersData = [
            [
               'first_name' => 'admin',
               'email'  =>'admin@admin.com',
               'user_role' => 'ADMIN',
               'password' => Hash::make('admin123'),
            ],
            [
               'first_name' => 'editor',
               'email' => 'editor@editor.com',
               'user_role' => 'EDITOR',
               'password' => Hash::make('editor123'),
            ],
            [
               'first_name' => 'author',
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
