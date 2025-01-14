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
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Piri-Piri Kebab Legnica',
            'address' => 'Szkolna 1, 59-220 Legnica',
            'coordinates' => '51.20420148586715, 16.160658581224446',
            'logo_link' => 'https://piripirisklep.pl/skins/user/rwd_shoper_1/images/logo.png',
            'open_year' => 2024,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => true,
            'is_chain' => true,
            'building_type' => 'lokal',
            'google_review' => null,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/kebab-piri-piri-szkolna',
            'pyszne_pl_review' => null,
            'glovo_link' => '',
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add sauces - mieszany, miodowo-musztardowy, mocny czosnek, ostry, sriracha mayo, łagodny
        $sauceIds = [3, 4, 5, 6, 7, 1];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add meat types - chicken, pork, beef and lamb(wołowo-baranina)
        $meatIds = [1, 3, 4, 7];
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
            'https://www.facebook.com/piripirilublin',
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
            'monday' => ['open' => '11:00', 'close' => '22:00'],
            'tuesday' => ['open' => '11:00', 'close' => '22:00'],
            'wednesday' => ['open' => '11:00', 'close' => '22:00'],
            'thursday' => ['open' => '11:00', 'close' => '22:00'],
            'friday' => ['open' => '11:00', 'close' => '23:00'],
            'saturday' => ['open' => '11:00', 'close' => '23:00'],
            'sunday' => ['open' => '12:00', 'close' => '22:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'pyszne.pl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/kebab-piri-piri-szkolna',
            ],
            [
                'app_name' => 'Glovo',
                'phone_number' => null,
                'website' => 'https://glovoapp.com/pl/pl/legnica/piri-piri-kebab-legnica-lga/',
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

        $kebabIdBafra = DB::table('kebabs')->insertGetId([
            'name' => 'BAFRA Kebab Legnica',
            'address' => 'Gwiezdna 4, 59-220 Legnica',
            'coordinates' => '51.20878980975163, 16.181608305305083',
            'logo_link' => 'https://www.dobrepomyslynabiznes.pl/upload/fot93-bafra-kebab.png',
            'open_year' => 2022,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => true,
            'is_chain' => true,
            'building_type' => 'stall',
            'google_review' => null,
            'pyszne_pl_link' => '',
            'pyszne_pl_review' => null,
            'glovo_link' => 'https://glovoapp.com/pl/pl/legnica/bafra-kebab-legnica/',
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //łagodny, ostry
        $sauceIdsBafra = [1, 6];
        foreach ($sauceIdsBafra as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabIdBafra,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //drobiowe, wołowe
        $meatIdsBafra = [2, 4];
        foreach ($meatIdsBafra as $meatId) {
            DB::table('kebab_meat_types')->insert([
                'kebab_id' => $kebabIdBafra,
                'meat_type_id' => $meatId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $socialMediaLinksBafra = [
            'https://www.facebook.com/bafralegnica/?locale=pl_PL',
            'https://www.instagram.com/bafra_kebab_legnica/?hl=en',
        ];
        foreach ($socialMediaLinksBafra as $link) {
            DB::table('kebab_social_medias')->insert([
                'kebab_id' => $kebabIdBafra,
                'social_media_link' => $link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $openingHoursBafra = [
            'monday' => ['open' => '10:00', 'close' => '21:00'],
            'tuesday' => ['open' => '10:00', 'close' => '21:00'],
            'wednesday' => ['open' => '10:00', 'close' => '21:00'],
            'thursday' => ['open' => '10:00', 'close' => '21:00'],
            'friday' => ['open' => '10:00', 'close' => '21:00'],
            'saturday' => ['open' => '10:00', 'close' => '20:00'],
            'sunday' => ['open' => '11:00', 'close' => '20:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabIdBafra,
            'monday_open' => $openingHoursBafra['monday']['open'],
            'monday_close' => $openingHoursBafra['monday']['close'],
            'tuesday_open' => $openingHoursBafra['tuesday']['open'],
            'tuesday_close' => $openingHoursBafra['tuesday']['close'],
            'wednesday_open' => $openingHoursBafra['wednesday']['open'],
            'wednesday_close' => $openingHoursBafra['wednesday']['close'],
            'thursday_open' => $openingHoursBafra['thursday']['open'],
            'thursday_close' => $openingHoursBafra['thursday']['close'],
            'friday_open' => $openingHoursBafra['friday']['open'],
            'friday_close' => $openingHoursBafra['friday']['close'],
            'saturday_open' => $openingHoursBafra['saturday']['open'],
            'saturday_close' => $openingHoursBafra['saturday']['close'],
            'sunday_open' => $openingHoursBafra['sunday']['open'],
            'sunday_close' => $openingHoursBafra['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderWaysBafra = [
            [
                'app_name' => 'BAFRA KEBAB LEGNICA',
                'phone_number' => '793142594',
                'website' => 'https://www.bafrakebablegnica.pl/',
            ],
            [
                'app_name' => null,
                'phone_number' => null,
                'website' => ' https://glovoapp.com/pl/pl/legnica/bafra-kebab-legnica/',
            ],
        ];
        foreach ($orderWaysBafra as $orderWay) {
            DB::table('order_ways')->insert([
                'kebab_id' => $kebabIdBafra,
                'app_name' => $orderWay['app_name'],
                'phone_number' => $orderWay['phone_number'],
                'website' => $orderWay['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /////////////////////

        $kebabIdAMAM = DB::table('kebabs')->insertGetId([
            'name' => 'AM AM Kebab',
            'address' => 'Wrocławska 155, 59-220 Legnica',
            'coordinates' => '51.20983124848106, 16.186928820316158',
            'logo_link' => 'https://amamkebab.pl/wp-content/uploads/2024/10/amamlogopop.png',
            'open_year' => 2024,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => true,
            'building_type' => 'stall',
            'google_review' => null,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/am-am-kebab-legnica-wroclawska',
            'pyszne_pl_review' => null,
            'glovo_link' => 'https://glovoapp.com/pl/pl/legnica/am-am-kebab-lga/',
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //łagodny, ostry
        $sauceIdsAmAm = [1, 6];
        foreach ($sauceIdsAmAm as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabIdAMAM,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //drobiowe, wołowe, falafel
        $meatIdsAmAm = [2, 4, 6];
        foreach ($meatIdsAmAm as $meatId) {
            DB::table('kebab_meat_types')->insert([
                'kebab_id' => $kebabIdAMAM,
                'meat_type_id' => $meatId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $socialMediaLinksAmAm = [
            'https://www.facebook.com/amam.kebab.lca/',
        ];
        foreach ($socialMediaLinksAmAm as $link) {
            DB::table('kebab_social_medias')->insert([
                'kebab_id' => $kebabIdAMAM,
                'social_media_link' => $link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $openingHoursAmAm = [
            'monday' => ['open' => '10:00', 'close' => '20:00'],
            'tuesday' => ['open' => '10:00', 'close' => '20:00'],
            'wednesday' => ['open' => '10:00', 'close' => '20:00'],
            'thursday' => ['open' => '10:00', 'close' => '20:00'],
            'friday' => ['open' => '10:00', 'close' => '20:00'],
            'saturday' => ['open' => '10:00', 'close' => '20:00'],
            'sunday' => ['open' => '11:00', 'close' => '20:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabIdAMAM,
            'monday_open' => $openingHoursAmAm['monday']['open'],
            'monday_close' => $openingHoursAmAm['monday']['close'],
            'tuesday_open' => $openingHoursAmAm['tuesday']['open'],
            'tuesday_close' => $openingHoursAmAm['tuesday']['close'],
            'wednesday_open' => $openingHoursAmAm['wednesday']['open'],
            'wednesday_close' => $openingHoursAmAm['wednesday']['close'],
            'thursday_open' => $openingHoursAmAm['thursday']['open'],
            'thursday_close' => $openingHoursAmAm['thursday']['close'],
            'friday_open' => $openingHoursAmAm['friday']['open'],
            'friday_close' => $openingHoursAmAm['friday']['close'],
            'saturday_open' => $openingHoursAmAm['saturday']['open'],
            'saturday_close' => $openingHoursAmAm['saturday']['close'],
            'sunday_open' => $openingHoursAmAm['sunday']['open'],
            'sunday_close' => $openingHoursAmAm['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderWaysAmAm = [
            [
                'app_name' => null,
                'phone_number' => '451164390',
                'website' => 'https://www.pyszne.pl/menu/am-am-kebab-legnica-wroclawska',
            ],
            [
                'app_name' => null,
                'phone_number' => null,
                'website' => 'https://glovoapp.com/pl/pl/legnica/am-am-kebab-lga/',
            ],
        ];
        foreach ($orderWaysAmAm as $orderWay) {
            DB::table('order_ways')->insert([
                'kebab_id' => $kebabIdAMAM,
                'app_name' => $orderWay['app_name'],
                'phone_number' => $orderWay['phone_number'],
                'website' => $orderWay['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /////////////////////

        $kebabIdKov = DB::table('kebabs')->insertGetId([
            'name' => 'Kavovarka - kebab kraft',
            'address' => 'Górnicza 10B, 59-220 Legnica',
            'coordinates' => '51.20576984040918, 16.186463774663128',
            'logo_link' => 'https://restaumatic-production.imgix.net/uploads/restaurants/327453/logo/1719563792.png?auto=compress%2Cformat&crop=focalpoint&fit=clip&h=500&w=500',
            'open_year' => 2023,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => true,
            'is_chain' => false,
            'building_type' => 'stall',
            'google_review' => null,
            'pyszne_pl_link' => null,
            'pyszne_pl_review' => null,
            'glovo_link' => 'https://glovoapp.com/pl/pl/legnica/kavovarka-lga/?utm_source=google&utm_medium=organic&utm_campaign=google_reserve_place_order_action',
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //czosnkowy, ostry, ziołowy, barbecue, tysiąca wysp
        $sauceIdsKov = [3, 6, 8, 9, 10];
        foreach ($sauceIdsKov as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabIdKov,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //drobiowe, wołowe, baranina
        $meatIdsKov = [2, 4, 5];
        foreach ($meatIdsKov as $meatId) {
            DB::table('kebab_meat_types')->insert([
                'kebab_id' => $kebabIdKov,
                'meat_type_id' => $meatId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $socialMediaLinksKov = [
            'https://www.facebook.com/p/Kraft-Kebab-100086871970091/',
        ];
        foreach ($socialMediaLinksKov as $link) {
            DB::table('kebab_social_medias')->insert([
                'kebab_id' => $kebabIdKov,
                'social_media_link' => $link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $openingHoursKov = [
            'monday' => ['open' => '12:00', 'close' => '21:00'],
            'tuesday' => ['open' => '12:00', 'close' => '21:00'],
            'wednesday' => ['open' => '12:00', 'close' => '21:00'],
            'thursday' => ['open' => '12:00', 'close' => '21:00'],
            'friday' => ['open' => '12:00', 'close' => '21:00'],
            'saturday' => ['open' => '12:00', 'close' => '21:00'],
            'sunday' => ['open' => '12:00', 'close' => '21:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabIdKov,
            'monday_open' => $openingHoursKov['monday']['open'],
            'monday_close' => $openingHoursKov['monday']['close'],
            'tuesday_open' => $openingHoursKov['tuesday']['open'],
            'tuesday_close' => $openingHoursKov['tuesday']['close'],
            'wednesday_open' => $openingHoursKov['wednesday']['open'],
            'wednesday_close' => $openingHoursKov['wednesday']['close'],
            'thursday_open' => $openingHoursKov['thursday']['open'],
            'thursday_close' => $openingHoursKov['thursday']['close'],
            'friday_open' => $openingHoursKov['friday']['open'],
            'friday_close' => $openingHoursKov['friday']['close'],
            'saturday_open' => $openingHoursKov['saturday']['open'],
            'saturday_close' => $openingHoursKov['saturday']['close'],
            'sunday_open' => null,
            'sunday_close' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderWaysKov = [
            [
                'app_name' => "KAVOVARKA",
                'phone_number' => '690922578',
                'website' => 'https://www.pyszne.pl/menu/am-am-kebab-legnica-wroclawska',
            ],
            [
                'app_name' => null,
                'phone_number' => null,
                'website' => 'https://glovoapp.com/pl/pl/legnica/kavovarka-lga?content=menu-c.2293475477',
            ],
            [
                'app_name' => null,
                'phone_number' => null,
                'website' => 'www.kavovarka.pl/',
            ],
        ];
        foreach ($orderWaysKov as $orderWay) {
            DB::table('order_ways')->insert([
                'kebab_id' => $kebabIdKov,
                'app_name' => $orderWay['app_name'],
                'phone_number' => $orderWay['phone_number'],
                'website' => $orderWay['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        ///////////////////////

        $kebabIdKing = DB::table('kebabs')->insertGetId([
            'name' => 'King House Kebab',
            'address' => 'aleja Piłsudskiego 38, 59-220 Legnica',
            'coordinates' => '51.204847355501975, 16.188547448631038',
            'logo_link' => 'https://restaumatic-production.imgix.net/uploads/accounts/199811/media_library/1263f201-3da1-43af-ba4e-b58dae0be171.jpg?auto=compress%2Cformat&blur=0&crop=focalpoint&fit=crop&fp-x=0.5&fp-y=0.5&max-h=586&max-w=390&rect=97%2C0%2C1901%2C1333',
            'open_year' => 2022,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => false,
            'building_type' => 'restaurant',
            'google_review' => null,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/king-house-kebab-legnica',
            'pyszne_pl_review' => null,
            'glovo_link' => 'https://glovoapp.com/pl/pl/legnica/king-house-kebab-lga/',
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //czosnkowy, ostry, łagodny, barbecue
        $sauceIdsKing = [3, 6, 1, 9];
        foreach ($sauceIdsKing as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabIdKing,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //drobiowe, baranina
        $meatIdsKing = [2, 5];
        foreach ($meatIdsKing as $meatId) {
            DB::table('kebab_meat_types')->insert([
                'kebab_id' => $kebabIdKing,
                'meat_type_id' => $meatId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $socialMediaLinksKing = [
            'https://www.facebook.com/p/King-House-KEBAB-100088738987179/?locale=pl_PL',
        ];
        foreach ($socialMediaLinksKing as $link) {
            DB::table('kebab_social_medias')->insert([
                'kebab_id' => $kebabIdKing,
                'social_media_link' => $link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $openingHoursKing = [
            'monday' => ['open' => '10:00', 'close' => '20:00'],
            'tuesday' => ['open' => '12:00', 'close' => '21:30'],
            'wednesday' => ['open' => '12:00', 'close' => '21:30'],
            'thursday' => ['open' => '12:00', 'close' => '21:30'],
            'friday' => ['open' => '12:00', 'close' => '22:00'],
            'saturday' => ['open' => '12:00', 'close' => '22:00'],
            'sunday' => ['open' => '12:00', 'close' => '21:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabIdKing,
            'monday_open' => null,
            'monday_close' => null,
            'tuesday_open' => $openingHoursKing['tuesday']['open'],
            'tuesday_close' => $openingHoursKing['tuesday']['close'],
            'wednesday_open' => $openingHoursKing['wednesday']['open'],
            'wednesday_close' => $openingHoursKing['wednesday']['close'],
            'thursday_open' => $openingHoursKing['thursday']['open'],
            'thursday_close' => $openingHoursKing['thursday']['close'],
            'friday_open' => $openingHoursKing['friday']['open'],
            'friday_close' => $openingHoursKing['friday']['close'],
            'saturday_open' => $openingHoursKing['saturday']['open'],
            'saturday_close' => $openingHoursKing['saturday']['close'],
            'sunday_open' => $openingHoursKing['sunday']['open'],
            'sunday_close' => $openingHoursKing['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderWaysKing = [
            [
                'app_name' => "King House Kebab",
                'phone_number' => '789977721',
                'website' => 'https://glovoapp.com/pl/pl/legnica/king-house-kebab-lga/',
            ],
            [
                'app_name' => null,
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/king-house-kebab-legnica',
            ],
            [
                'app_name' => null,
                'phone_number' => null,
                'website' => 'https://www.kinghousekebab.pl',
            ],
        ];
        foreach ($orderWaysKing as $orderWay) {
            DB::table('order_ways')->insert([
                'kebab_id' => $kebabIdKing,
                'app_name' => $orderWay['app_name'],
                'phone_number' => $orderWay['phone_number'],
                'website' => $orderWay['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        ////////////

        $kebabIdKTruck = DB::table('kebabs')->insertGetId([
            'name' => 'KEBAB TRUCK',
            'address' => 'Iwaszkiewicza 1, 59-220 Legnica',
            'coordinates' => '51.20837154152122, 16.213543233583827',
            'logo_link' => 'https://img.restaurantguru.com/rc11-KEBAB-TRUCK-menu.jpg',
            'open_year' => 2015,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => false,
            'building_type' => 'stall',
            'google_review' => null,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/kebab-truck-iwaszkiewicza',
            'pyszne_pl_review' => null,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //łagodny, ostry, czosnkowy, ziołowy
        $sauceIdsKTruck = [1, 6, 3, 8];
        foreach ($sauceIdsKTruck as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabIdKTruck,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //drobiowe, wieprzowe, wołowe
        $meatIdsKTruck = [2, 3, 4];
        foreach ($meatIdsKTruck as $meatId) {
            DB::table('kebab_meat_types')->insert([
                'kebab_id' => $kebabIdKTruck,
                'meat_type_id' => $meatId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $socialMediaLinksKTruck = [
            'https://www.facebook.com/KEBABTRUCK/?locale=pl_PL',
        ];
        foreach ($socialMediaLinksKTruck as $link) {
            DB::table('kebab_social_medias')->insert([
                'kebab_id' => $kebabIdKTruck,
                'social_media_link' => $link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $openingHoursKTruck = [
            'monday' => ['open' => '10:00', 'close' => '19:00'],
            'tuesday' => ['open' => '10:00', 'close' => '19:00'],
            'wednesday' => ['open' => '10:00', 'close' => '19:00'],
            'thursday' => ['open' => '10:00', 'close' => '19:00'],
            'friday' => ['open' => '10:00', 'close' => '19:00'],
            'saturday' => ['open' => '10:00', 'close' => '19:00'],
            'sunday' => ['open' => '11:00', 'close' => '20:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabIdKTruck,
            'monday_open' => $openingHoursKTruck['monday']['open'],
            'monday_close' => $openingHoursKTruck['monday']['close'],
            'tuesday_open' => $openingHoursKTruck['tuesday']['open'],
            'tuesday_close' => $openingHoursKTruck['tuesday']['close'],
            'wednesday_open' => $openingHoursKTruck['wednesday']['open'],
            'wednesday_close' => $openingHoursKTruck['wednesday']['close'],
            'thursday_open' => $openingHoursKTruck['thursday']['open'],
            'thursday_close' => $openingHoursKTruck['thursday']['close'],
            'friday_open' => $openingHoursKTruck['friday']['open'],
            'friday_close' => $openingHoursKTruck['friday']['close'],
            'saturday_open' => $openingHoursKTruck['saturday']['open'],
            'saturday_close' => $openingHoursKTruck['saturday']['close'],
            'sunday_open' => null,
            'sunday_close' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderWaysKTruck = [
            [
                'app_name' => "pyszne.pl",
                'phone_number' => '735602702',
                'website' => 'https://www.pyszne.pl/menu/kebab-truck-iwaszkiewicza',
            ]
        ];
        foreach ($orderWaysKTruck as $orderWay) {
            DB::table('order_ways')->insert([
                'kebab_id' => $kebabIdKTruck,
                'app_name' => $orderWay['app_name'],
                'phone_number' => $orderWay['phone_number'],
                'website' => $orderWay['website'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        //Piekielna Babcia
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'PIEKIELNA BABCIA Tex-Mex Bar',
            'address' => 'Żwirki i Wigury 54',
            'coordinates' => '51.20882515160446, 16.14690107407074',
            'logo_link' => 'https://scontent.fktw1-1.fna.fbcdn.net/v/t39.30808-6/428480975_781352574045917_5921777719874352443_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=cc71e4&_nc_ohc=1at06MKFGOIQ7kNvgHVizPm&_nc_zt=23&_nc_ht=scontent.fktw1-1.fna&_nc_gid=AadilAl-O12jOMjbgc1tOor&oh=00_AYCvR-aG8pyzmp_9-ejwPa6KO_2MF4Bbdo6PVX1d6q8exA&oe=678ADB71',
            'open_year' => 2021,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => false,
            'building_type' => 'restaurant',
            'google_review' => 4.7,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/piekielna-babcia-tex-mex-bar',
            'pyszne_pl_review' => 4.9,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ostre: carolina reaper, trinidad scorpion, habanero, chili,
        //łagodne paprykowy, sweet chili mango, majonez, barbeque, serowy, sriracho mayo, czosnkowy
        $sauceIds = [11, 12, 13, 14, 15, 16, 17, 9, 18, 7, 3];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // wołowina, schab, kurczak
        $meatIds = [1, 3, 7];
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
            'https://www.facebook.com/profile.php?id=100065135455564',
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
            'wednesday' => ['open' => '14:00', 'close' => '20:00'],
            'thursday' => ['open' => '14:00', 'close' => '20:00'],
            'friday' => ['open' => '14:00', 'close' => '20:00'],
            'saturday' => ['open' => '14:00', 'close' => '20:00'],
            'sunday' => ['open' => '14:00', 'close' => '20:00'],
        ];

        DB::table('opening_hours')->insert([
            'kebab_id' => $kebabId,
            'monday_open' => null,
            'monday_close' => null,
            'tuesday_open' => null,
            'tuesday_close' => null,
            'wednesday_open' => $openingHours['wednesday']['open'],
            'wednesday_close' => $openingHours['wednesday']['close'],
            'thursday_open' => $openingHours['thursday']['open'],
            'thursday_close' => $openingHours['thursday']['close'],
            'friday_open' => $openingHours['friday']['open'],
            'friday_close' => $openingHours['friday']['close'],
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '536-948-206',
                'website' => null,
            ],
            [
                'app_name' => 'PysznePl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/piekielna-babcia-tex-mex-bar',
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

        //Mix Kebab
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'MIX Kebab',
            'address' => 'Wrocławska 23a',
            'coordinates' => '51.20922822073663, 16.16930226161652',
            'logo_link' => 'https://res.cloudinary.com/tkwy-prod-eu/image/upload/c_thumb,h_120,w_176/f_auto/q_auto/dpr_1.0/v1736777602/static-takeaway-com/images/restaurants/pl/QPRR5113/logo_465x320',
            'open_year' => null,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => false,
            'building_type' => 'restaurant',
            'google_review' => 4.3,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/mix-kebab-legnica',
            'pyszne_pl_review' => 4.2,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add sauces łagodny, ostry
        $sauceIds = [1, 6];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add meat types drobiowe, baranina
        $meatIds = [2, 5];
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
            'monday' => ['open' => '11:00', 'close' => '21:00'],
            'tuesday' => ['open' => '11:00', 'close' => '21:00'],
            'wednesday' => ['open' => '11:00', 'close' => '21:00'],
            'thursday' => ['open' => '11:00', 'close' => '21:00'],
            'friday' => ['open' => '11:00', 'close' => '21:00'],
            'saturday' => ['open' => '12:00', 'close' => '21:00'],
            'sunday' => ['open' => '12:00', 'close' => '21:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '576-765-815',
                'website' => null,
            ],
            [
                'app_name' => 'PysznePl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/mix-kebab-legnica',
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

        //Had Food - Pizza Kebab Burger
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Had Food - Pizza Kebab Burger',
            'address' => 'Fabryczna 13',
            'coordinates' => '51.20683216751553, 16.178697234228586',
            'logo_link' => 'https://scontent.fktw1-1.fna.fbcdn.net/v/t39.30808-6/392961103_6659007470821068_1704781470570580247_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=Jl-A9ktfavQQ7kNvgErhUNZ&_nc_zt=23&_nc_ht=scontent.fktw1-1.fna&_nc_gid=AZTsDRR_lx8BzjshgDFa4FG&oh=00_AYBVlrkiug0LXNnakmV-IuferayL_QwGHzsVT7CDGd3L5Q&oe=678AE8CE',
            'open_year' => 2023,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => true,
            'is_chain' => false,
            'building_type' => 'restaurant',
            'google_review' => 4.4,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/had-food',
            'pyszne_pl_review' => 4.6,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add sauces łagodny, ostry
        $sauceIds = [1, 6];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add meat types drobiowe, baranina
        $meatIds = [2, 5];
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
            'https://www.facebook.com/hadfoodlegnica/',
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
            'monday' => ['open' => '12:00', 'close' => '22:00'],
            'tuesday' => ['open' => '12:00', 'close' => '22:00'],
            'wednesday' => ['open' => '12:00', 'close' => '22:00'],
            'thursday' => ['open' => '12:00', 'close' => '22:00'],
            'friday' => ['open' => '12:00', 'close' => '23:00'],
            'saturday' => ['open' => '12:00', 'close' => '23:00'],
            'sunday' => ['open' => '12:00', 'close' => '21:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '573-677-536',
                'website' => null,
            ],
            [
                'app_name' => 'PysznePl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/had-food',
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

        //Zahir Kebab
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Zahir Kebab',
            'address' => 'Kolejowa 3',
            'coordinates' => '51.212926796109215, 16.16857736844329',
            'logo_link' => 'https://zahirkebab.pl/wp-content/uploads/2020/05/Logo-test2.png',
            'open_year' => 2014,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => true,
            'building_type' => 'restaurant',
            'google_review' => 4.0,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/zahir-kebab-legnica-kolejowa',
            'pyszne_pl_review' => 4.1,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Łagodny Ostry Czosnkowy Barbeque Koperkowy Ketchup
        $sauceIds = [1, 6, 3, 9, 19, 21];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kurczak Baranina
        $meatIds = [1, 5];
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
            'https://www.facebook.com/zahirkebab',
            'https://www.instagram.com/zahirkebab/',
            'https://www.youtube.com/channel/UCcvjNQ_Zc9x0vX4Vmu5o3ag',
            'https://pl.linkedin.com/company/zahir-kebab',
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
            'monday' => ['open' => '09:00', 'close' => '00:00'],
            'tuesday' => ['open' => '09:00', 'close' => '00:00'],
            'wednesday' => ['open' => '09:00', 'close' => '00:00'],
            'thursday' => ['open' => '09:00', 'close' => '00:00'],
            'friday' => ['open' => '09:00', 'close' => '02:00'],
            'saturday' => ['open' => '09:00', 'close' => '02:00'],
            'sunday' => ['open' => '09:00', 'close' => '02:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '577-122-801',
                'website' => null,
            ],
            [
                'app_name' => 'PysznePl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/zahir-kebab-legnica-kolejowa',
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

        //Lara Doner
        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Lara Döner Kebab Legnica',
            'address' => 'Wrocławska 13',
            'coordinates' => '51.2098037741647, 16.16776712491952',
            'logo_link' => '',
            'open_year' => 2023,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => false,
            'building_type' => 'restaurant',
            'google_review' => 4.6,
            'pyszne_pl_link' => '',
            'pyszne_pl_review' => null,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // czosnkowy, ostry, ziołowy, ketchup, miętowy 
        $sauceIds = [3, 6, 8, 21, 20];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // kurczak, wołowina, mieszane
        $meatIds = [2, 4, 7];
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
            'friday' => ['open' => '10:00', 'close' => '22:00'],
            'saturday' => ['open' => '10:00', 'close' => '22:00'],
            'sunday' => ['open' => '12:00', 'close' => '22:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '577-122-801',
                'website' => null,
            ],
            [
                'app_name' => 'Glovo',
                'phone_number' => null,
                'website' => 'https://glovoapp.com/pl/pl/legnica/lara-doner-kebab-lga/?content=menu-c.2583162117',
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

        //////

        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Leo Kebab',
            'address' => 'Kolejowa 3, 59-222 Legnica',
            'coordinates' => '51.20453613095878, 16.15983830591723',
            'logo_link' => null,
            'open_year' => null,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => true,
            'is_chain' => false,
            'building_type' => 'lokal',
            'google_review' => null,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/leo-kebab-and-grill',
            'pyszne_pl_review' => null,
            'glovo_link' => 'https://glovoapp.com/pl/pl/legnica/leo-kebab-legnica-lga/',
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // łagodny ostry czosnkowy mieszany
        $sauceIds = [1, 6, 2, 3];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // kurczaK WOŁOWINA, MIESZANE, falafel
        $meatIds = [1, 4, 6, 7];
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
            'https://www.facebook.com/p/Leo-Kebab-Legnica-61555702835902/',
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
            'monday' => ['open' => '11:00', 'close' => '21:30'],
            'tuesday' => ['open' => '11:00', 'close' => '21:30'],
            'wednesday' => ['open' => '11:00', 'close' => '21:30'],
            'thursday' => ['open' => '11:00', 'close' => '21:30'],
            'friday' => ['open' => '11:00', 'close' => '21:30'],
            'saturday' => ['open' => '11:00', 'close' => '21:30'],
            'sunday' => ['open' => '11:00', 'close' => '21:30'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'webside',
                'phone_number' => 509047182,
                'website' => 'https://www.leokebab-legnica.pl',
            ],
            [
                'app_name' => 'pyszne.pl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/leo-kebab-and-grill',
            ],
            [
                'app_name' => 'Glovo',
                'phone_number' => null,
                'website' => 'https://glovoapp.com/pl/pl/legnica/leo-kebab-legnica-lga/',
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

        ///////

        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Zahir Kebab',
            'address' => 'Jaworzyńska 8, 52-220 Legnica',
            'coordinates' => '51.20435904135975, 16.160214406689793',
            'logo_link' => 'https://zahirkebab.pl/wp-content/uploads/2020/05/Logo-test2.png',
            'open_year' => null,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => true,
            'building_type' => 'restaurant',
            'google_review' => 4.0,
            'pyszne_pl_link' => 'https://zahirkebab.pl/lokale/legnica/legnica-jaworzynska/',
            'pyszne_pl_review' => null,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Łagodny Ostry Czosnkowy Barbeque Koperkowy Ketchup
        $sauceIds = [1, 6, 3, 9, 19, 21];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kurczak Baranina
        $meatIds = [1, 5];
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
            'https://www.facebook.com/zahirkebab',
            'https://www.instagram.com/zahirkebab/',
            'https://www.youtube.com/channel/UCcvjNQ_Zc9x0vX4Vmu5o3ag',
            'https://pl.linkedin.com/company/zahir-kebab',
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
            'monday' => ['open' => '10:00', 'close' => '00:00'],
            'tuesday' => ['open' => '10:00', 'close' => '00:00'],
            'wednesday' => ['open' => '10:00', 'close' => '00:00'],
            'thursday' => ['open' => '10:00', 'close' => '00:00'],
            'friday' => ['open' => '10:00', 'close' => '02:00'],
            'saturday' => ['open' => '10:00', 'close' => '02:00'],
            'sunday' => ['open' => '10:00', 'close' => '02:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '459 566 602',
                'website' => null,
            ],
            [
                'app_name' => 'PysznePl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/zahir-kebab-legnica-kolejowa',
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

        ////////////////

        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Stambul kebab',
            'address' => 'Jaworzyńska 8, 52-220 Legnica',
            'coordinates' => '51.20727376787114, 16.15701219222163',
            'logo_link' => 'https://zahirkebab.pl/wp-content/uploads/2020/05/Logo-test2.png',
            'open_year' => null,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => true,
            'building_type' => 'restaurant',
            'google_review' => 3.7,
            'pyszne_pl_link' => 'https://www.pyszne.pl/menu/kebab-stambul-legnica-gwarna',
            'pyszne_pl_review' => null,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Łagodny Ostry Czosnkowy mieszany
        $sauceIds = [1, 6, 3, 2];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kurczak wołowina mieszany 
        $meatIds = [2, 4, 7];
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
            'https://www.facebook.com/kebab.istambul/?locale=pl_PL',
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
            'monday' => ['open' => '12:00', 'close' => '00:00'],
            'tuesday' => ['open' => '12:00', 'close' => '00:00'],
            'wednesday' => ['open' => '12:00', 'close' => '00:00'],
            'thursday' => ['open' => '12:00', 'close' => '00:00'],
            'friday' => ['open' => '12:00', 'close' => '01:00'],
            'saturday' => ['open' => '12:00', 'close' => '01:00'],
            'sunday' => ['open' => '12:00', 'close' => '00:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '510 111 592',
                'website' => null,
            ],
            [
                'app_name' => 'PysznePl',
                'phone_number' => null,
                'website' => 'https://www.pyszne.pl/menu/kebab-stambul-legnica-gwarna',
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

        ///////////////////////

        $kebabId = DB::table('kebabs')->insertGetId([
            'name' => 'Cyrus Kebab Restauracja Kurdyjska',
            'address' => 'Rynek 20, 59-200 Legnica',
            'coordinates' => '51.20800413035202, 16.161131780044432',
            'logo_link' => 'https://scontent-waw2-1.xx.fbcdn.net/v/t39.30808-6/302181489_592209778998072_15209454530947678_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=O44ay_3DTL0Q7kNvgGPgfgy&_nc_zt=23&_nc_ht=scontent-waw2-1.xx&_nc_gid=AGmxvQ0oGOg-QFJ0spjVwe1&oh=00_AYBnAdknrFpaMhaI00bUqGg_-hwgNkA9UfYVpOcma3vwHQ&oe=678C54D6',
            'open_year' => null,
            'closed_year' => null,
            'status' => 'open',
            'is_craft' => false,
            'is_chain' => true,
            'building_type' => 'restaurant',
            'google_review' => 4.0,
            'pyszne_pl_link' => null,
            'pyszne_pl_review' => null,
            'glovo_link' => null,
            'glovo_review' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Łagodny Ostry Czosnkowy mieszany
        $sauceIds = [1, 6, 3, 2];
        foreach ($sauceIds as $sauceId) {
            DB::table('kebab_sauces')->insert([
                'kebab_id' => $kebabId,
                'sauce_type_id' => $sauceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kurczak wołowina mieszany 
        $meatIds = [2, 4, 7];
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
            'https://www.facebook.com/cyruskebab/',
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
            'friday' => ['open' => '10:00', 'close' => '24:00'],
            'saturday' => ['open' => '10:00', 'close' => '24:00'],
            'sunday' => ['open' => '10:00', 'close' => '22:00'],
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
            'saturday_open' => $openingHours['saturday']['open'],
            'saturday_close' => $openingHours['saturday']['close'],
            'sunday_open' => $openingHours['sunday']['open'],
            'sunday_close' => $openingHours['sunday']['close'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add order ways
        $orderWays = [
            [
                'app_name' => 'Phone number',
                'phone_number' => '509 969 117',
                'website' => null,
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