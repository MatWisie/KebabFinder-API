<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Log\NullLogger;
use App\Scrapers\PyszneplScraper;

class PyszneplScraperTest extends TestCase
{
    public function testGetRatingSuccess()
    {
        $htmlContent = '<div data-qa="restaurant-header-score"><b>4.5</b></div>';

        $mock = new MockHandler([
            new Response(200, [], $htmlContent)
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $scraper = new PyszneplScraper(new NullLogger(), $client);

        $rating = $scraper->getRating("/menu/kebab-piri-piri-szkolna");
        $this->assertEquals(4.5, $rating);
    }

    public function testGetRatingNotFound()
    {
        $htmlContent = '<div data-qa="restaurant-header-score"></div>';

        $mock = new MockHandler([
            new Response(200, [], $htmlContent)
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $scraper = new PyszneplScraper(new NullLogger(), $client);

        $rating = $scraper->getRating("/menu/kebab-piri-piri-szkolna");
        $this->assertNull($rating);
    }

    public function testGetRatingInvalidResponse()
    {
        $mock = new MockHandler([
            new Response(404, [])
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $scraper = new PyszneplScraper(new NullLogger(), $client);

        $rating = $scraper->getRating("/menu/kebab-piri-piri-szkolna");
        $this->assertNull($rating);
    }

    public function testGetRatingOutOfRange()
    {
        $htmlContent = '<div data-qa="restaurant-header-score"><b>6.5</b></div>';

        $mock = new MockHandler([
            new Response(200, [], $htmlContent)
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $scraper = new PyszneplScraper(new NullLogger(), $client);

        $rating = $scraper->getRating("/menu/kebab-piri-piri-szkolna");
        $this->assertNull($rating);
    }
}
