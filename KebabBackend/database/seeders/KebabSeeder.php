<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KebabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Kebab record
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'seeded kebab',
            'address' => 'seed seed seed',
            'coordinates' => '456, 123',
            'logo_link' => 'https://logo.com/example',
            'open_year' => 1999,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => true,
            'is_chain' => true,
            'building_type' => 'domek',
            'google_review' => null,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/example',
            'pyszne_pl_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add sauces
        $sauceIds = [1, 2];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add meat types
        $meatIds = [2, 4];
        foreach ($meatIds as $meatId) {
            DB::table('kebab_meat_types')->insert([
                'kebab_id' => $kebabId,
                'meat_type_id' => $meatId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add social media links
        $socialMediaLinks = [
            'https://facebook.com/samplekebab',
            'https://instagram.com/samplekebab',
        ];
        foreach ($socialMediaLinks as $link) {
            DB::table('kebab_social_medias')->insert([
                'kebab_id' => $kebabId,
                'social_media_link' => $link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add opening hours
        $openingHours = [
            'monday' => ['open' => '10:00', 'close' => '22:00'],
            'tuesday' => ['open' => '10:00', 'close' => '22:00'],
            'wednesday' => ['open' => '10:00', 'close' => '22:00'],
            'thursday' => ['open' => '10:00', 'close' => '22:00'],
            'friday' => ['open' => '10:00', 'close' => '23:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabId,
            'monday_open' => $openingHours['monday']['open'],
            'monday_close' => $openingHours['monday']['close'],
            'tuesday_open' => $openingHours['tuesday']['open'],
            'tuesday_close' => $openingHours['tuesday']['close'],
            'wednesday_open' => $openingHours['wednesday']['open'],
            'wednesday_close' => $openingHours['wednesday']['close'],
            'thursday_open' => $openingHours['thursday']['open'],
            'thursday_close' => $openingHours['thursday']['close'],
            'friday_open' => $openingHours['friday']['open'],
            'friday_close' => $openingHours['friday']['close'],
            'saturday_open' => null,
            'saturday_close' => null,
            'sunday_open' => null,
            'sunday_close' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'UberEats',
                'phone_number' => '123-456-789',
                'website' => 'https://ubereats.com/samplekebab',
            ],
            [
                'app_name' => 'DoorDash',
                'phone_number' => null,
                'website' => 'https://doordash.com/samplekebab',
            ],
        ];
        foreach ($orderWays as $orderWay) {
            DB::table('order_ways')->insert([
                'kebab_id' => $kebabId,
                'app_name' => $orderWay['app_name'],
                'phone_number' => $orderWay['phone_number'],
                'website' => $orderWay['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
