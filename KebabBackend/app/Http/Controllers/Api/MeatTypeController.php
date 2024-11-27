<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeatTypeRequest;
use Illuminate\Http\Request;
use App\Models\MeatType;

/**
 * @OA\Tag(name="MeatTypes", description="Operations related to Meat Types")
 * 
 * @OA\Schema(
 *     schema="MeatTypeRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Chicken")
 * )
 */
class MeatTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/meattypes",
     *     summary="Get all meat types",
     *     tags={"MeatTypes"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved all meat types",
     *         @OA\JsonContent(type="array", items=@OA\Items(ref="#/components/schemas/MeatType"))
     *     ),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index()
    {
        $meatTypes = MeatType::all();
        return response()->json($meatTypes);
    }

    /**
     * @OA\Post(
     *     path="/api/meattypes",
     *     summary="Create a new meat type",
     *     tags={"MeatTypes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MeatTypeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="MeatType added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="MeatType added successfully"),
     *             @OA\Property(property="meattype", ref="#/components/schemas/MeatType")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(MeatTypeRequest $request)
    {
        $validated = $request->validated();
        $meatType = MeatType::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'MeatType added successfully',
            'meattype' => $meatType,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/meattypes/{id}",
     *     summary="Update an existing meat type",
     *     tags={"MeatTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MeatTypeRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Meat type updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Meat type updated successfully"),
     *             @OA\Property(property="meatType", ref="#/components/schemas/MeatType")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Meat type not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(MeatTypeRequest $request, string $id)
    {
        $validated = $request->validated();
        $meatType = MeatType::findOrFail($id);

        $meatType->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'Meat type updated successfully',
            'meatType' => $meatType,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/meattypes/{id}",
     *     summary="Delete a meat type",
     *     tags={"MeatTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Meat type deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Meat type deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Meat type not found")
     * )
     */
    public function destroy(string $id)
    {
        $meatType = MeatType::findOrFail($id);

        $meatType->kebabs()->detach();
        $meatType->delete();

        return response()->json([
            'message' => 'Meat type deleted successfully',
        ]);
    }
}