<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SauceType;
use App\Http\Requests\SauceTypeRequest;

/**
 * @OA\Tag(
 *     name="Sauce Types",
 *     description="Operations about Sauce Types"
 * )
 */

/**
 * @OA\Schema(
 *     schema="SauceType",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Spicy"),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="SauceTypeRequest",
 *     type="object",
 *     required={"name"},
 *     properties={
 *         @OA\Property(property="name", type="string", example="Sweet Chili")
 *     }
 * )
 */

class SauceTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sauce-types",
     *     tags={"Sauce Types"},
     *     summary="Get all sauce types",
     *     description="Retrieve a list of all sauce types.",
     *     @OA\Response(
     *         response=200,
     *         description="List of sauce types",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SauceType"))
     *     )
     * )
     */
    public function index()
    {
        $sauceTypes = SauceType::all();
        return response()->json($sauceTypes);
    }

    /**
     * @OA\Post(
     *     path="/api/sauce-types",
     *     tags={"Sauce Types"},
     *     summary="Add a new sauce type",
     *     description="Create a new sauce type.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SauceTypeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sauce type added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="SauceType added successfully"),
     *             @OA\Property(property="saucetype", ref="#/components/schemas/SauceType")
     *         )
     *     )
     * )
     */
    public function store(SauceTypeRequest $request)
    {
        $validated = $request->validated();
        $sauceType = SauceType::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'SauceType added successfully',
            'saucetype' => $sauceType,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/sauce-types/{id}",
     *     tags={"Sauce Types"},
     *     summary="Update a sauce type",
     *     description="Update an existing sauce type.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sauce type",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SauceTypeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sauce type updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sauce type updated successfully"),
     *             @OA\Property(property="sauceType", ref="#/components/schemas/SauceType")
     *         )
     *     )
     * )
     */
    public function update(SauceTypeRequest $request, string $id)
    {
        $validated = $request->validated();
        $sauceType = SauceType::findOrFail($id);

        $sauceType->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'Sauce type updated successfully',
            'sauceType' => $sauceType,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/sauce-types/{id}",
     *     tags={"Sauce Types"},
     *     summary="Delete a sauce type",
     *     description="Delete a specific sauce type.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sauce type",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="SauceType deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="SauceType deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $sauceType = SauceType::findOrFail($id);

        $sauceType->kebabs()->detach();
        $sauceType->delete();

        return response()->json([
            'message' => 'SauceType deleted successfully',
        ]);
    }
}
