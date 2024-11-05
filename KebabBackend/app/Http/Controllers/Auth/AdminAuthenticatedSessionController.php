<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AdminAuthService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminAuthenticatedSessionController extends Controller
{
    protected $adminAuthService;

    public function __construct(AdminAuthService $adminAuthService)
    {
        $this->adminAuthService = $adminAuthService;
    }
    /**
     * Handle an incoming authentication request.
     *
     * @OA\Post(
     *     path="/api/admin/login",
     *     summary="Admin login",
     *     tags={"Admin Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $this->adminAuthService->authenticate($request->only("email"));

        $request->authenticate();
        $request->session()->regenerate();
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token');
        return response()->json([
                'token'=> $token,
        ]);
    }
}
