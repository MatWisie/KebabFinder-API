<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kebab;
use App\Models\SauceType;
use App\Models\MeatType;
use App\Models\KebabSocialMedia;
use App\Models\OpeningHour;
use App\Models\OrderWay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KebabController extends Controller
{

    /**
     * Get all kebabs or kebab by id.
     * 
     * @OA\Get(
     *     path="/api/kebabs",
     *     summary="Get all kebabs with related information",
     *     tags={"Kebabs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of kebabs",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Kebab"))
     *     )
     * )
     * 
     * @OA\Get(
     *     path="/api/kebabs/{id}",
     *     summary="Get a single kebab by ID",
     *     tags={"Kebabs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kebab ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kebab details",
     *         @OA\JsonContent(ref="#/components/schemas/Kebab")
     *     ),
     *     @OA\Response(response=404, description="Kebab not found")
     * )
     */
    public function index(Request $request): JsonResource
    {
        $kebab = Kebab::with([
            'openingHour',
            'meatTypes',
            'orderWay',
            'sauces',
            'socialMedias'
        ])->paginate(10);

        return response()->json($kebab);
    }

    /**
     * Add new kebab.
     * 
     * @OA\Post(
     *     path="/api/kebabs",
     *     summary="Add a new kebab with related information",
     *     tags={"Kebabs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/KebabInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kebab created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Kebab")
     *     )
     * )
     */
    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'coordinates' => 'required|string',
            'sauces' => 'array|exists:saucetypes,id',
            'meats' => 'array|exists|meattypes,id',
            'social_media_links' => 'array',
            'opening_hours' => 'array',
            'order_ways' => 'array'
        ]);

        $kebab = Kebab::create($validated);

        foreach ($validated['sauces'] as $sauceId) {
            SauceType::create([
                'kebab_id' => $kebab->id,
                'sauce_id' => $sauceId
            ]);
        }

        foreach ($validated['meats'] as $meatId) {
            MeatType::create([
                'kebab_id' => $kebab->id,
                'meat_type_id' => $meatId
            ]);
        }

        foreach ($validated['social_media_links'] as $link) {
            KebabSocialMedia::create([
                'kebab_id' => $kebab->id,
                'social_media_link' => $link
            ]);
        }

        foreach ($validated['opening_hours'] as $day => $hours) {
            OpeningHour::create([
                'kebab_id' => $kebab->id,
                $day . '_open' => $hours['open'] ?? null,
                $day . '_close' => $hours['close'] ?? null,
            ]);
        }

        foreach ($validated['order_ways'] as $way) {
            OrderWay::create([
                'kebab_id' => $kebab->id,
                'app_name' => $way['app_name'] ?? null,
                'phone_number' => $way['phone_number'] ?? null,
                'website' => $way['website'] ?? null,
            ]);
        }

        return response()->json($kebab);
    }

    public function destroy($id)
    {
        $kebab = Kebab::findOrFail($id);
        $kebab->delete();

        return response()->json(['success' => true]);
    }
}