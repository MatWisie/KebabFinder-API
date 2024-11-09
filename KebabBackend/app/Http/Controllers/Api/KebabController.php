<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kebab;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KebabController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $kebab = Kebab::with(['openingHour', 'meatTypes', 'orderWay', 'sauces', 'socialMedias'])->paginate(10);

        return response()->json($kebab);
    }
}
