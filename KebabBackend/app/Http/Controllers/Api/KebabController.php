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
