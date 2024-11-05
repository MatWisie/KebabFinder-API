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
