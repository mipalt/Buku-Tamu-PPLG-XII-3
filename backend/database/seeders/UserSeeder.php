<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => UserRole::ADMIN->value,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'role' => UserRole::USER->value,
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($user as $data) {
            User::create($data);
        }
    }
}
