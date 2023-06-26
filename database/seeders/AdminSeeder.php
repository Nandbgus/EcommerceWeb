<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            [
                'name' => 'admin',
                'email' => 'admin@ecoshop.com',
                'password' => bcrypt('12345'),
                'is_admin' => true,
            ]
        ];
        User::insert($admin);
    }
}
