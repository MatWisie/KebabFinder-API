<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SauceType;
use App\Http\Requests\SauceTypeRequest;

class SauceTypeController extends Controller
{
    public function index()
    {
        $sauceTypes = SauceType::all();
        return response()->json($sauceTypes);
    }

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
