<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kebab;
use App\Scrapers\PyszneplScraper;
use Illuminate\Http\JsonResponse;

class PyszneRatingController extends Controller
{
    protected PyszneplScraper $scraper;

    public function __construct(PyszneplScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    /**
     * @OA\Post(
     *     path="/api/kebabs/{kebab}/pysznepl-refresh-review",
     *     summary="Get restaurant rating for a specific kebab",
     *     description="Fetches the rating of a restaurant from Pyszne.pl using the kebab's link.",
     *     tags={"Kebabs", "Pyszne"},
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
     *             @OA\Property(property="rating", type="number", format="float", example=4.5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kebab not found or link missing"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid Pyszne.pl link"
     *     )
     * )
     */
    public function getRating(Kebab $kebab): JsonResponse
    {
        $url = $kebab->pyszne_pl_link;

        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['message' => 'Invalid or missing Pyszne.pl link'], 400);
        }

        $rating = $this->scraper->getRatingForRestaurant($url);

        if ($rating === null) {
            return response()->json(['message' => 'Rating not found or could not be retrieved'], 404);
        }

        return response()->json(['rating' => $rating], 200);
    }
}
