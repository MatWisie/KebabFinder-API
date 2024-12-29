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
     *
     *  @OA\Get(
     *     path="/api/reports",
     *     summary="Get a list of reports",
     *     description="Returns a list of all reports.",
     *     tags={"Reports"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of reports",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Report"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $reports = Report::all();

        return response()->json($reports);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *     path="/api/reports",
     *     summary="Create a new report",
     *     description="Stores a newly created report in the database with the status 'Waiting'.",
     *     tags={"Reports"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"kebab_id","content"},
     *             @OA\Property(property="kebab_id", type="integer", description="ID of the kebab"),
     *             @OA\Property(property="content", type="string", description="Content of the report")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Report submitted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Report submitted successfully"),
     *             @OA\Property(property="report", ref="#/components/schemas/Report")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid data"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function store(ReportRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $report = Report::create([
            'user_id' => auth()->id(),
            'kebab_id' => $validated['kebab_id'],
            'content' => $validated['content'],
            'status' => 'Waiting',
        ]);

        return response()->json(['message' => 'Report submitted successfully', 'report' => $report], 201);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @OA\Delete(
     *     path="/api/reports/{report}",
     *     summary="Delete a report",
     *     description="Removes a report from the database by its ID.",
     *     tags={"Reports"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="report",
     *         in="path",
     *         required=true,
     *         description="ID of the report",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Report removed successfully"
     *     ),
     *     @OA\Response(response=404, description="Report not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy(Report $report): JsonResponse
    {
        $report->delete();

        return response()->json(['message' => 'Report removed successfully'], 204);
    }

    /**
     * Change the report status to "accepted".
     * 
     * @OA\Put(
     *     path="/api/reports/{report}/accept",
     *     summary="Accept a report",
     *     description="Changes the report status to 'Accepted'.",
     *     tags={"Reports"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="report",
     *         in="path",
     *         required=true,
     *         description="ID of the report to accept",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report accepted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Report accepted successfully"),
     *             @OA\Property(property="report", ref="#/components/schemas/Report")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Report not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function acceptReport(Report $report): JsonResponse
    {
        $report->update(['status' => 'Accepted']);

        return response()->json(['message' => 'Report accepted successfully', 'report' => $report], 200);
    }

    /**
     * Change the report status to "refused".
     * 
     *  @OA\Put(
     *     path="/api/reports/{report}/refuse",
     *     summary="Refuse a report",
     *     description="Changes the report status to 'Refused'.",
     *     tags={"Reports"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="report",
     *         in="path",
     *         required=true,
     *         description="ID of the report to refuse",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report refused successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Report refused successfully"),
     *             @OA\Property(property="report", ref="#/components/schemas/Report")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Report not found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function refuseReport(Report $report): JsonResponse
    {
        $report->update(['status' => 'Refused']);

        return response()->json(['message' => 'Report refused successfully', 'report' => $report], 200);
    }
}
