<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kebab;
use App\Scrapers\PyszneplScraper;
use Illuminate\Support\Facades\Log;

class UpdatePyszneReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-pyszne-pl-reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Pyszne.pl reviews for all kebabs with a valid link';

    protected PyszneplScraper $scraper;

    /**
     * Create a new command instance.
     */
    public function __construct(PyszneplScraper $scraper)
    {
        parent::__construct();
        $this->scraper = $scraper;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $kebabs = Kebab::whereNotNull('pyszne_pl_link')->get();

        foreach ($kebabs as $kebab) {
            $this->info("Processing kebab: {$kebab->name}");

            try {
                $rating = $this->scraper->getRatingForRestaurant($kebab->pyszne_pl_link);

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
    }

}
