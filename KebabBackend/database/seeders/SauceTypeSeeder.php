<?php

namespace Database\Seeders;

use App\Models\SauceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SauceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SauceType::insert([
            ["name" => "Ketchup"],
            ["name" => "Mayonnaise"],
            ["name" => "Garlic"],
            ["name" => "Spicy"],
        ]);
    }
}
