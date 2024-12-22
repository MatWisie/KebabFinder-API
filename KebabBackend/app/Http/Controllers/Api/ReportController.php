<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $reports = Report::all();

        return response()->json($reports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    public function store(ReportRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $report = Report::create([
            'kebab_id' => $validated['kebab_id'],
            'content' => $validated['content'],
            'status' => 'Waiting',
        ]);

        return response()->json(['message' => 'Report submitted successfully', 'report' => $report], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report): JsonResponse
    {
        $report->delete();

        return response()->json(['message' => 'Report removed successfully'], 204);
    }

    /**
     * Change the report status to "accepted".
     */
    public function acceptReport(Report $report): JsonResponse
    {
        $report->update(['status' => 'Accepted']);

        return response()->json(['message' => 'Report accepted successfully', 'report' => $report], 200);
    }

    /**
     * Change the report status to "refused".
     */
    public function refuseReport(Report $report): JsonResponse
    {
        $report->update(['status' => 'Refused']);

        return response()->json(['message' => 'Report refused successfully', 'report' => $report], 200);
    }
}
