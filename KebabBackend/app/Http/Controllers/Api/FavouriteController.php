<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kebab;
use Illuminate\Http\JsonResponse;
use App\Services\FavouriteService;

class FavouriteController extends Controller
{
    protected FavouriteService $favouriteService;

    public function __construct(FavouriteService $favouriteService)
    {
        $this->favouriteService = $favouriteService;
    }

    /**
     * Add a kebab to the authenticated user's favourites.
     *
     * @OA\Post(
     *     path="/kebabs/{kebab}/favourite",
     *     summary="Add a kebab to favourites",
     *     tags={"Favourites"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         required=true,
     *         description="ID of the kebab",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=201, description="Kebab added to favourites"),
     *     @OA\Response(response=409, description="Already in favourites"),
     *     @OA\Response(response=404, description="Kebab not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function addToFavourites(Kebab $kebab): JsonResponse
    {
        $user = auth()->user();

        if (!$this->favouriteService->addFavourite($user, $kebab)) {
            return response()->json(['message' => 'Kebab already in favourites'], 409);
        }

        return response()->json(['message' => 'Kebab added to favourites'], 201);
    }

    /**
     * Remove a kebab from the authenticated user's favourites.
     *
     * @OA\Delete(
     *     path="/kebabs/{kebab}/favourite",
     *     summary="Remove a kebab from favourites",
     *     tags={"Favourites"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         required=true,
     *         description="ID of the kebab",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Kebab removed from favourites"),
     *     @OA\Response(response=404, description="Kebab not found in favourites"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function removeFromFavourites(Kebab $kebab): JsonResponse
    {
        $user = auth()->user();

        if (!$this->favouriteService->removeFavourite($user, $kebab)) {
            return response()->json(['message' => 'Kebab not found in favourites'], 404);
        }

        return response()->json(null, 204);
    }

    /**
     * Get all favourite kebabs of the authenticated user.
     *
     * @OA\Get(
     *     path="/user/favourites",
     *     summary="Get all favourite kebabs",
     *     tags={"Favourites"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of favourite kebabs"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function getFavourites(): JsonResponse
    {
        $user = auth()->user();

        $favourites = $this->favouriteService->getFavourites($user);

        return response()->json($favourites, 200);
    }
}
