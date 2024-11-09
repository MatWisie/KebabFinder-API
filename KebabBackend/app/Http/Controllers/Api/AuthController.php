<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserAuthService;
use App\Services\AdminAuthService;
use App\Services\UserRegistrationService;

class AuthController extends Controller
{
    protected $userAuthService;
    protected $adminAuthService;
    protected $userRegistrationService;

    public function __construct(UserAuthService $userAuthService, AdminAuthService $adminAuthService, UserRegistrationService $userRegistrationService)
    {
        $this->userAuthService = $userAuthService;
        $this->adminAuthService = $adminAuthService;
        $this->userRegistrationService = $userRegistrationService;
    }
    /**
     * Register User.
     */
    public function register(Request $request)
    {
        $token = $this->userRegistrationService->register($request->all());

        return response()->json([
            'message' => 'User successfully registered.',
            'token' => $token,
        ], 201);
    }

    /**
     * Login for user.
     */
    public function userLogin(Request $request)
    {
        $token = $this->userAuthService->login($request->all());

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
        ], 200);
    }

    /**
     * Login for Admin.
     */
    public function adminLogin(Request $request)
    {
        $token = $this->adminAuthService->login($request->all());

        return response()->json([
            'message' => 'Admin login successful.',
            'token' => $token,
        ], 200);
    }

    /**
     * Logout for everyone.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
