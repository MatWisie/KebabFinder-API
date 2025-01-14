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
            ["name" => "Mild"],             //1  łagodny
            ["name" => "Mixed"],            //2  mieszany
            ["name" => "Garlic"],           //3  czosnkowy
            ["name" => "Honey-mustard"],    //4  miodowo-musztardowy
            ["name" => "Strong garlic"],    //5  mocny czosnek
            ["name" => "Spicy"],            //6  ostry
            ["name" => "Sriracha mayo"],    //7  sriracha mayo
            ["name" => "herb"],             //8  ziołowy
            ["name" => "barbecue"],         //9  barbecue
            ["name" => "thousand islands"], //10 tysiąca wysp
            ["name" => "carolina reaper"],  //11 carolina reaper
            ["name" => "trinidad scorpion"],//12 trinidad scorpion
            ["name" => "habanero"],         //13 habanero
            ["name" => "chili"],            //14 chili
            ["name" => "paprika"],          //15 paprykowy
            ["name" => "sweet chili mango"],//16 sweet chili mango
            ["name" => "mayonnaise"],       //17 majonez
            ["name" => "cheese"],           //18 serowy
            ["name" => "dill"],             //19 koperkowy
            ["name" => "mint"],             //20 miętowy
            ["name" => "Ketchup"],          //21 ketchup
        ]);
    }
}
