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
            ["name" => "Chicken"],  //1 kurczak
            ["name" => "Poultry]"], //2 drobiowe
            ["name" => "Pork"],     //3 wieprzowe
            ["name" => "Beef"],     //4 wołowe
            ["name" => "Mutton"],   //5 baranina
            ["name" => "Falafel"],  //6 falafel
            ["name" => "Mixed"],    //7 mieszane
            ["name" => "Loin"],     //8 Schab     
        ]);
    }
}
