<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $author->assignRole('author');
    }
}
