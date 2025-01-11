<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Kebab;
use App\Scrapers\PyszneplScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('kebabs:update-pyszne-reviews', function (PyszneplScraper $scraper) {
    $this->info('Updating Pyszne.pl reviews...');

    $kebabs = Kebab::whereNotNull('pyszne_pl_link')->get();

    foreach ($kebabs as $kebab) {
        $this->info("Processing kebab: {$kebab->name}");

        try {
            $rating = $scraper->getRatingForRestaurant($kebab->pyszne_pl_link);

            if ($rating !== null) {
                $kebab->pyszne_pl_review = $rating;
                $kebab->save();

                $this->info("Updated rating for {$kebab->name} to {$rating}");
            } else {
                $this->warn("Could not fetch rating for {$kebab->name}");
            }
        } catch (\Exception $e) {
            Log::error("Error updating rating for {$kebab->name}: {$e->getMessage()}");
            $this->error("Error updating rating for {$kebab->name}: {$e->getMessage()}");
        }
    }

    $this->info("Finished updating Pyszne.pl reviews.");
})->purpose('Update Pyszne.pl reviews for all kebabs with a valid link');

app(Schedule::class)->command('kebabs:update-pyszne-reviews')->daily();
