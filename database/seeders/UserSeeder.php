<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert(
            [
                [
                    'name' => 'Admin User',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                ],
                [
                    'name' => 'Visitor User',
                    'email' => 'user@gmail.com',
                    'password' => bcrypt('password'),
                    'role' => 'visitor',
                ],
                [
                    'name' => 'Librarian User',
                    'email' => 'amanrawat@gmail.com',
                    'password' => bcrypt('password'),
                    'role' => 'visitor',
                ],
            ]
        );
        User::factory()->count(8)->create();
    }
}
