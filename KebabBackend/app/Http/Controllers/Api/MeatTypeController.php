<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeatTypeRequest;
use Illuminate\Http\Request;
use App\Models\MeatType;

class MeatTypeController extends Controller
{
    public function index()
    {
        $meatTypes = MeatType::all();
        return response()->json($meatTypes);
    }

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