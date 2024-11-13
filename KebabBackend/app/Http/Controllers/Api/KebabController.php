<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kebab;
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
     *     path="/kebabs",
     *     summary="Create a new kebab",
     *     tags={"Kebabs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="The name of the kebab"),
     *             @OA\Property(property="address", type="string", description="Address of the kebab location"),
     *             @OA\Property(property="coordinates", type="string", description="Geographical coordinates"),
     *             @OA\Property(
     *                 property="sauces",
     *                 type="array",
     *                 description="List of sauce IDs",
     *                 @OA\Items(type="integer")
     *             ),
     *             @OA\Property(
     *                 property="meats",
     *                 type="array",
     *                 description="List of meat type IDs",
     *                 @OA\Items(type="integer")
     *             ),
     *             @OA\Property(
     *                 property="social_media_links",
     *                 type="array",
     *                 description="List of social media links",
     *                 @OA\Items(type="string", format="url")
     *             ),
     *             @OA\Property(
     *                 property="opening_hours",
     *                 type="object",
     *                 description="Opening hours for each day",
     *                 @OA\Property(property="monday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time")),
     *                 @OA\Property(property="tuesday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time")),
     *                 @OA\Property(property="wednesday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time")),
     *                 @OA\Property(property="thursday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time")),
     *                 @OA\Property(property="friday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time")),
     *                 @OA\Property(property="saturday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time")),
     *                 @OA\Property(property="sunday", type="object", @OA\Property(property="open", type="string", format="time"), @OA\Property(property="close", type="string", format="time"))
     *             ),
     *             @OA\Property(
     *                 property="order_ways",
     *                 type="array",
     *                 description="Different ways to order from this kebab",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="app_name", type="string", nullable=true),
     *                     @OA\Property(property="phone_number", type="string", nullable=true),
     *                     @OA\Property(property="website", type="string", format="url", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kebab created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Kebab")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */

    public function store(Request $request): JsonResource
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'coordinates' => 'required|string',
            'logo_link' => 'nullable|string',
            'open_year' => 'nullable|integer|digits:4',
            'closed_year' => 'nullable|integer|digits:4',
            'status' => 'required|in:open,closed,planned',
            'is_craft' => 'required|boolean',
            'building_type' => 'required|string',
            'is_chain' => 'required|boolean',
            'sauces' => 'array|exists:sauce_types,id',
            'meats' => 'array|exists:meat_types,id',
            'social_media_links' => 'array',
            'opening_hours' => 'array',
            'order_ways' => 'array'
        ]);

        $kebab = Kebab::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'coordinates' => $validated['coordinates'],
            'logo_link' => $validated['logo_link'] ?? null,
            'open_year' => $validated['open_year'] ?? null,
            'closed_year' => $validated['closed_year'] ?? null,
            'status' => $validated['status'],
            'is_craft' => $validated['is_craft'],
            'building_type' => $validated['building_type'],
            'is_chain' => $validated['is_chain'],
        ]);

        $kebab->sauces()->sync($validated['sauces']);

        $kebab->meatTypes()->sync($validated['meats']);

        foreach ($validated['social_media_links'] as $link) {
            KebabSocialMedia::create([
                'kebab_id' => $kebab->id,
                'social_media_link' => $link
            ]);
        }

        $openingHours = new OpeningHour(['kebab_id' => $kebab->id]);
        foreach ($validated['opening_hours'] as $day => $hours) {
            $openingHours->{$day . '_open'} = $hours['open'] ?? null;
            $openingHours->{$day . '_close'} = $hours['close'] ?? null;
        }
        $openingHours->save();

        foreach ($validated['order_ways'] as $way) {
            OrderWay::create([
                'kebab_id' => $kebab->id,
                'app_name' => $way['app_name'] ?? null,
                'phone_number' => $way['phone_number'] ?? null,
                'website' => $way['website'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Kebab created successfully'], 200);
    }

    /**
     * Delete kebab by id.
     * 
     * @OA\Delete(
     *     path="/api/kebabs/{id}",
     *     summary="Delete a kebab by ID",
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
     *         description="Kebab deleted successfully"
     *     ),
     *     @OA\Response(response=404, description="Kebab not found")
     * )
     */
    public function destroy($id)
    {
        $kebab = Kebab::find($id);

        if (!$kebab) {
            return response()->json(['message' => 'Kebab not found'], 404);
        }

        $kebab->delete();
        return response()->json(['message' => 'Kebab deleted successfully'], 200);
    }
}
