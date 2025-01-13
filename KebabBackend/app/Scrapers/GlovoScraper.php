<?php

namespace App\Scrapers;

use GuzzleHttp\Client;
use Log;
use Symfony\Component\DomCrawler\Crawler;
use Psr\Log\LoggerInterface;

class GlovoScraper
{
    protected Client $client;

    public function __construct(
        protected LoggerInterface $logger,
        Client $client = null
    ) {
        $this->client = $client ?? new Client([
            'base_uri' => 'https://www.glovoapp.com',
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Connection' => 'keep-alive',
            ],
        ]);
    }

    public function getRatingForRestaurant(string $url): ?array
    {
        try {
            $response = $this->client->get($url);

            if ($response->getStatusCode() !== 200) {
                $this->logger->error("GlovoScraper: Bad status code", [
                    'url' => $url,
                    'status' => $response->getStatusCode(),
                ]);
                return null;
            }

            $htmlContent = (string) $response->getBody();
            $crawler = new Crawler($htmlContent);

            $ratingElement = $crawler->filter('[data-test-id="store-rating-label"]');
            if ($ratingElement->count() === 0) {
                $this->logger->warning("GlovoScraper: Rating element not found", [
                    'url' => $url,
                ]);
                return null;
            }

            $rating = $ratingElement->text();
            $rating = rtrim($rating, '%');

            return [
                'rating' => is_numeric($rating) ? $rating : null,
            ];
        } catch (\Exception $e) {
            $this->logger->error("GlovoScraper: Exception occurred", [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

}
