<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KebabRequest;
use App\Models\Kebab;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\KebabService;

class KebabController extends Controller
{
    protected $kebabService;

    public function __construct(KebabService $kebabService)
    {
        $this->kebabService = $kebabService;
    }

    /**
     * @OA\Get(
     *     path="/api/kebabs/{kebab}",
     *     summary="Get details of a specific kebab",
     *     description="Returns the details of a specific kebab including associated sauces, meat types, social media links, opening hours, and order methods.",
     *     tags={"Kebabs"},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         description="Kebab ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kebab details",
     *         @OA\JsonContent(ref="#/components/schemas/Kebab")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kebab not found"
     *     )
     * )
     */
    public function show(Kebab $kebab): JsonResponse
    {
        $kebab->load([
            'sauces:id,name',
            'meatTypes:id,name',
            'socialMedias:id,social_media_link',
            'openingHour',
            'orderWay:id,app_name,phone_number,website'
        ]);

        return response()->json($kebab);
    }

    /**
     * @OA\Get(
     *     path="/api/kebabs",
     *     summary="Get a list of all kebabs",
     *     description="Returns a list of all kebabs along with their associated data.",
     *     tags={"Kebabs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of kebabs",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Kebab"))
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $kebab = Kebab::with([
            'openingHour',
            'meatTypes',
            'orderWay',
            'sauces',
            'socialMedias'
        ])->get();

        return response()->json($kebab);
    }

    /**
     * @OA\Post(
     *     path="/api/kebabs",
     *     summary="Create a new kebab",
     *     description="Creates a new kebab with the provided data and associates related entities like sauces, meats, social media links, opening hours, and order methods.",
     *     tags={"Kebabs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "address", "status", "coordinates", "is_craft", "is_chain", "building_type", "sauces", "meats", "social_media_links", "opening_hours", "order_ways"},
     *             @OA\Property(property="name", type="string", description="The name of the kebab", example="Sample Kebab Place"),
     *             @OA\Property(property="address", type="string", description="The address of the kebab", example="123 Kebab St, Kebab City"),
     *             @OA\Property(property="coordinates", type="string", description="Coordinates of the kebab (latitude,longitude)", example="51.5074, -10.1278"),
     *             @OA\Property(property="logo_link", type="string", format="uri", description="URL of the logo (optional)", example="http://example.com"),
     *             @OA\Property(property="open_year", type="integer", description="Year the kebab opened", example=1999),
     *             @OA\Property(property="closed_year", type="integer", description="Year the kebab closed", example=2020),
     *             @OA\Property(property="status", type="string", enum={"open", "closed", "planned"}, description="The status of the kebab", example="open"),
     *             @OA\Property(property="is_craft", type="boolean", description="Whether the kebab is a craft kebab", example=true),
     *             @OA\Property(property="building_type", type="string", description="The type of building where the kebab is located", example="domek"),
     *             @OA\Property(property="is_chain", type="boolean", description="Whether the kebab is part of a chain", example=true),
     *             @OA\Property(property="sauces", type="array", @OA\Items(type="integer"), description="List of sauce types associated with the kebab", example={1, 2}),
     *             @OA\Property(property="meats", type="array", @OA\Items(type="integer"), description="List of meat types associated with the kebab", example={2, 4}),
     *             @OA\Property(property="social_media_links", type="array", @OA\Items(type="string", format="uri"), description="Social media links for the kebab", example={
     *                 "https://facebook.com/samplekebab",
     *                 "https://instagram.com/samplekebab"
     *             }),
     *             @OA\Property(property="opening_hours", type="object", description="Opening hours for the kebab", 
     *                 @OA\AdditionalProperties(
     *                     type="object", 
     *                     @OA\Property(property="open", type="string", example="10:00"),
     *                     @OA\Property(property="close", type="string", example="22:00")
     *                 ), 
     *                 example={
     *                     "monday": { "open": "10:00", "close": "22:00" },
     *                     "tuesday": { "open": "10:00", "close": "22:00" },
     *                     "wednesday": { "open": "10:00", "close": "22:00" },
     *                     "thursday": { "open": "10:00", "close": "22:00" },
     *                     "friday": { "open": "10:00", "close": "23:00" }
     *                 }
     *             ),
     *             @OA\Property(property="order_ways", type="array", description="Order methods for the kebab",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="app_name", type="string", description="The name of the app", example="UberEats"),
     *                     @OA\Property(property="phone_number", type="string", description="Phone number for orders", example="123-456-789"),
     *                     @OA\Property(property="website", type="string", format="uri", description="Website URL for the app", example="https://ubereats.com/samplekebab")
     *                 ), 
     *                 example={
     *                     {"app_name": "UberEats", "phone_number": "123-456-789", "website": "https://ubereats.com/samplekebab"},
     *                     {"app_name": "DoorDash", "phone_number": null, "website": "https://doordash.com/samplekebab"}
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kebab created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kebab created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data provided"
     *     )
     * )
     */
    public function store(KebabRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $kebab = Kebab::create($this->kebabService->getKebabData($validated));

        $this->kebabService->syncRelations($kebab, $validated);

        return response()->json(['message' => 'Kebab created successfully'], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/kebabs/{kebab}",
     *     summary="Update an existing kebab",
     *     description="Updates the details of an existing kebab along with its associated entities like sauces, meats, social media links, opening hours, and order methods.",
     *     tags={"Kebabs"},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         description="Kebab ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "address", "coordinates", "status", "is_craft", "building_type", "is_chain"},
     *             @OA\Property(property="name", type="string", description="The name of the kebab"),
     *             @OA\Property(property="address", type="string", description="The address of the kebab"),
     *             @OA\Property(property="coordinates", type="string", description="Coordinates of the kebab (latitude,longitude)"),
     *             @OA\Property(property="logo_link", type="string", format="uri", description="URL of the logo (optional)"),
     *             @OA\Property(property="open_year", type="integer", description="Year the kebab opened (optional)"),
     *             @OA\Property(property="closed_year", type="integer", description="Year the kebab closed (optional)"),
     *             @OA\Property(property="status", type="string", enum={"open", "closed", "planned"}, description="The status of the kebab"),
     *             @OA\Property(property="is_craft", type="boolean", description="Whether the kebab is a craft kebab"),
     *             @OA\Property(property="building_type", type="string", description="The type of building where the kebab is located"),
     *             @OA\Property(property="is_chain", type="boolean", description="Whether the kebab is part of a chain"),
     *             @OA\Property(property="sauces", type="array", @OA\Items(type="integer"), description="List of sauce types associated with the kebab"),
     *             @OA\Property(property="meats", type="array", @OA\Items(type="integer"), description="List of meat types associated with the kebab"),
     *             @OA\Property(property="social_media_links", type="array", @OA\Items(type="string", format="uri"), description="Social media links for the kebab"),
     *             @OA\Property(property="opening_hours", type="array", description="Opening hours for the kebab", @OA\Items(type="object")),
     *             @OA\Property(property="order_ways", type="array", description="Order methods for the kebab", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kebab updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kebab updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kebab not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content"
     *     )
     * )
     */
    public function update(KebabRequest $request, Kebab $kebab): JsonResponse
    {
        $validated = $request->validated();

        $kebab->update($this->kebabService->getKebabData($validated));

        $this->kebabService->syncRelations($kebab, $validated);

        return response()->json(['message' => 'Kebab updated successfully'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/kebabs/{kebab}",
     *     summary="Delete a kebab",
     *     description="Deletes a kebab by its ID.",
     *     tags={"Kebabs"},
     *     @OA\Parameter(
     *         name="kebab",
     *         in="path",
     *         description="Kebab ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Kebab deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kebab not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $kebab = Kebab::find($id);

        if (!$kebab) {
            return response()->json(['message' => 'Kebab not found'], 404);
        }

        $kebab->delete();

        return response()->json(['message' => 'Kebab deleted successfully'], 204);
    }
}
