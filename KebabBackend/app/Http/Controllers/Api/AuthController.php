<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * @OA\Post(
     *     path="/api/register",
     *     summary="User Registration",
     *     description="Registers a new user and returns an authentication token.",
     *     operationId="registerUser",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully registered",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
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
     * 
     * @OA\Post(
     *     path="/api/user-login",
     *     summary="User Login",
     *     description="Logs in a user and returns an authentication token.",
     *     operationId="loginUser",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
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
     * Login for admin.
     * 
     * @OA\Post(
     *     path="/api/admin-login",
     *     summary="Admin Login",
     *     description="Logs in an admin and returns an authentication token.",
     *     operationId="loginAdmin",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
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
     * Logout for everyone
     * 
     * @OA\Post(
     *     path="/api/logout-from-all",
     *     summary="User Logout",
     *     description="Logs out the currently authenticated user and invalidates their tokens.",
     *     operationId="logoutUser",
     *     tags={"Auth"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logoutFromAll(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out from all devices successfully.'], 200);
    }
}
