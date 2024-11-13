<?php

namespace Database\Seeders;

use App\Models\MeatType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeatType::insert([
            ["name" => "Chicken"],
            ["name" => "Beef"],
            ["name" => "Lamb"],
            ["name" => "Mixed"],
        ]);
    }
}
