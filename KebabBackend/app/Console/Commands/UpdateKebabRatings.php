<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kebab;
use App\Scrapers\PyszneplScraper;
use App\Scrapers\GlovoScraper;
use Illuminate\Support\Facades\Log;

class UpdateKebabRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-kebab-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update ratings for all kebabs from Pyszne.pl and Glovo with valid links';

    protected PyszneplScraper $pyszneScraper;
    protected GlovoScraper $glovoScraper;

    /**
     * Create a new command instance.
     */
    public function __construct(PyszneplScraper $pyszneScraper, GlovoScraper $glovoScraper)
    {
        parent::__construct();
        $this->pyszneScraper = $pyszneScraper;
        $this->glovoScraper = $glovoScraper;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $kebabs = Kebab::all();

        foreach ($kebabs as $kebab) {
            $this->info("Processing kebab: {$kebab->name}");

            // Update Pyszne.pl rating
            if ($kebab->pyszne_pl_link) {
                try {
                    $rating = $this->pyszneScraper->getRatingForRestaurant($kebab->pyszne_pl_link);

                    if ($rating !== null) {
                        $kebab->pyszne_pl_review = $rating;
                        $this->info("Updated Pyszne.pl rating for {$kebab->name} to {$rating}");
                    } else {
                        $this->warn("Could not fetch Pyszne.pl rating for {$kebab->name}");
                    }
                } catch (\Exception $e) {
                    Log::error("Error updating Pyszne.pl rating for {$kebab->name}: {$e->getMessage()}");
                    $this->error("Error updating Pyszne.pl rating for {$kebab->name}: {$e->getMessage()}");
                }
            }

            // Update Glovo rating
            if ($kebab->glovo_link) {
                try {
                    $ratingData = $this->glovoScraper->getRatingForRestaurant($kebab->glovo_link);

                    if ($ratingData !== null) {
                        $kebab->glovo_review = $ratingData['rating'];
                        $this->info("Updated Glovo rating for {$kebab->name} to {$ratingData['rating']}");
                    } else {
                        $this->warn("Could not fetch Glovo rating for {$kebab->name}");
                    }
                } catch (\Exception $e) {
                    Log::error("Error updating Glovo rating for {$kebab->name}: {$e->getMessage()}");
                    $this->error("Error updating Glovo rating for {$kebab->name}: {$e->getMessage()}");
                }
            }

            $kebab->save();
        }

        $this->info("Finished updating ratings for all kebabs.");
    }
}
