<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GoogleApiService
{
    protected $apiKey;
    protected $httpClient;

    public function __construct()
    {
        $this->apiKey = config('services.google.key');
        $this->httpClient = new Client(['base_uri' => 'https://maps.googleapis.com/maps/api/']);
    }

    public function fetchRatingByNameAndAddress(string $name, string $address): ?float
    {
        try {
            $requestPayload = [
                'headers' => [
                    'X-Goog-Api-Key' => $this->apiKey,
                    'X-Goog-FieldMask' => 'places.rating',
                ],
                'json' => [
                    'textQuery' => "$name $address Legnica",
                ]
            ];

            Log::info('Sending request to Google Places API', [
                'endpoint' => 'https://places.googleapis.com/v1/places:searchText',
                'payload' => $requestPayload,
            ]);

            $response = $this->httpClient->post('https://places.googleapis.com/v1/places:searchText', $requestPayload);

            $data = json_decode($response->getBody()->getContents(), true);
            Log::info('Google Places API response', [
                'request' => "$name $address Legnica",
                'response' => $data,
            ]);

            if (!isset($data['places'][0]['rating'])) {
                return 0;
            }

            return (float) $data['places'][0]['rating'];
        } catch (\Exception $e) {
            Log::error('Error in Google Places API request', [
                'request' => "$name $address",
                'error' => $e->getMessage(),
            ]);
            return 0;
        }
    }
}
