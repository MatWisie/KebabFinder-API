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

    /**
     * @OA\Post(
     *     path="/api/kebabs/{kebab}/google-refresh-review",
     *     summary="Get restaurant details from Google Places",
     *     description="Fetches details such as rating and address of a kebab restaurant using its name and location.",
     *     tags={"Kebabs", "Google"},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         description="ID of the kebab",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant details",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Kebab King"),
     *             @OA\Property(property="rating", type="number", example=4.5),
     *             @OA\Property(property="address", type="string", example="123 Main St, Legnica"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kebab not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid kebab data"
     *     )
     * )
     */
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
