<?php

namespace App\Scrapers;

use GuzzleHttp\Client;
use Log;
use Symfony\Component\DomCrawler\Crawler;
use Psr\Log\LoggerInterface;

class PyszneplScraper
{
    protected Client $client;

    public function __construct(
        protected LoggerInterface $logger,
        Client $client = null
    ) {
        $this->client = $client ?? new Client([
            'base_uri' => 'https://www.pyszne.pl',
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Connection' => 'keep-alive',
            ],
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
            Log::info($htmlContent);
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
