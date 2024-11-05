<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            User::create([
                'name'=> 'admin',
                'email'=> 'admin@example.com',
                'password'=> Hash::make('Admin123!'),
                'is_admin' => true,
                'is_first_login' => true,
            ]);
    }
}
