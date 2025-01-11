<?php

namespace App\Scrapers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Psr\Log\LoggerInterface;

class PyszneplScraper
{
    public function __construct(
        protected LoggerInterface $logger,
        protected ?Client $client = null
    ) {
        $this->client = $this->client ?? new Client([
            'base_uri' => 'https://www.pyszne.pl',
            'timeout' => 10,
        ]);
    }

    public function getRatingForRestaurant(string $url): ?float
    {
        return $this->getRating($url);
    }

    public function getRating(string $url): ?float
    {
        try {
            $response = $this->client->get($url);

            if ($response->getStatusCode() !== 200) {
                $this->logger->error("PyszneScraper: Bad status code", [
                    'url' => $url,
                    'status' => $response->getStatusCode(),
                ]);
                return null;
            }

            $htmlContent = (string) $response->getBody();
            $crawler = new Crawler($htmlContent);

            $element = $crawler->filter('[data-qa="restaurant-header-score"] b')->first();

            if ($element->count() === 0) {
                $this->logger->warning("PyszneScraper: Rating element not found", [
                    'url' => $url,
                ]);
                return null;
            }

            $ratingText = $element->text();
            $ratingValue = (float) $ratingText;

            if ($ratingValue <= 0 || $ratingValue > 5) {
                $this->logger->warning("PyszneScraper: Rating out of expected range", [
                    'url' => $url,
                    'rating' => $ratingValue,
                ]);
                return null;
            }

            return $ratingValue;
        } catch (\Exception $e) {
            $this->logger->error("PyszneScraper: Exception occurred", [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
