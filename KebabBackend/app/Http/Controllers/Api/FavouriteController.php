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

    public function addToFavourites(Kebab $kebab): JsonResponse
    {
        $user = auth()->user();

        if (!$this->favouriteService->addFavourite($user, $kebab)) {
            return response()->json(['message' => 'Kebab already in favourites'], 409);
        }

        return response()->json(['message' => 'Kebab added to favourites'], 201);
    }

}