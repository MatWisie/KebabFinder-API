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
    public function store(KebabRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $kebab = Kebab::create($this->kebabService->getKebabData($validated));

        $this->kebabService->syncRelations($kebab, $validated);

        return response()->json(['message' => 'Kebab created successfully'], 201);
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
    public function update(KebabRequest $request, Kebab $kebab): JsonResponse
    {
        $validated = $request->validated();

        $kebab->update($this->kebabService->getKebabData($validated));

        $this->kebabService->syncRelations($kebab, $validated);

        return response()->json(['message' => 'Kebab updated successfully'], 200);
    }

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
