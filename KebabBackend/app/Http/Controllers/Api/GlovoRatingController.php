<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kebab;
use App\Scrapers\GlovoScraper;
use Illuminate\Http\JsonResponse;

class GlovoRatingController extends Controller
{
    protected GlovoScraper $scraper;

    public function __construct(GlovoScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    /**
     * @OA\Get(
     *     path="/api/kebabs/{kebab}/glovo-refresh-review",
     *     summary="Get restaurant rating for a specific kebab",
     *     description="Fetches the rating of a restaurant from Glovo using the kebab's link.",
     *     tags={"Kebabs", "Glovo"},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         description="ID of the kebab",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant rating",
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="string", example="89%"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kebab not found or link missing"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid Glovo link"
     *     )
     * )
     */
    public function getRating(Kebab $kebab): JsonResponse
    {
        $url = $kebab->glovo_link;

        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['message' => 'Invalid or missing Glovo link'], 400);
        }

        $ratingData = $this->scraper->getRatingForRestaurant($url);

        if ($ratingData === null) {
            return response()->json(['message' => 'Rating not found or could not be retrieved'], 404);
        }

        return response()->json([
            'rating' => $ratingData['rating'],
        ], 200);
    }
}
