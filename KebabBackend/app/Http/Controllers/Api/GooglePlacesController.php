<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kebab;
use App\Services\GoogleApiService;
use Illuminate\Http\JsonResponse;

class GooglePlacesController extends Controller
{
    protected GoogleApiService $googleApiService;

    public function __construct(GoogleApiService $googleApiService)
    {
        $this->googleApiService = $googleApiService;
    }

    public function getKebabDetails(Kebab $kebab): JsonResponse
    {
        $name = $kebab->name;
        $address = $kebab->address;

        if (empty($name) || empty($address)) {
            return response()->json(['message' => 'Invalid kebab data'], 400);
        }

        $rating = $this->googleApiService->fetchRatingByNameAndAddress($name, $address);

        if ($rating === 0) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        $kebab->google_review = $rating;
        $kebab->save();

        return response()->json([
            'name' => $name,
            'rating' => $rating,
        ], 200);
    }
}
