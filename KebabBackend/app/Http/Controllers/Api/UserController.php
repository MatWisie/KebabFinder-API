<?php

namespace App\Http\Controllers\Api;

use \App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use \App\Http\Controllers\Controller;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model",
 *     required={"id", "name", "email", "is_admin", "is_first_login", "created_at", "updated_at"},
 *     @OA\Property(property="id", type="integer", description="ID of the user"),
 *     @OA\Property(property="name", type="string", description="Name of the user"),
 *     @OA\Property(property="email", type="string", format="email", description="Email address of the user"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, description="Email verification timestamp"),
 *     @OA\Property(property="is_admin", type="boolean", description="Indicates if the user is an admin"),
 *     @OA\Property(property="is_first_login", type="boolean", description="Indicates if this is the user's first login"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp"),
 * )
 */

class UserController extends Controller
{
    /**
     * Check if the user is logged in for the first time.
     *
     * @OA\Get(
     *     path="/api/user/first-login",
     *     summary="Check if the user is logging in for the first time",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="is_first_login", type="boolean", example=true)
     *         )
     *     )
     * )
     */
    public function isFirstLogin(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'is_first_login' => $user->is_first_login,
        ]);
    }

    /**
     * Delete a user by ID.
     *
     * @OA\Delete(
     *     path="/api/admin/{id}",
     *     summary="Delete a user by ID",
     *     tags={"Admin"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="User deleted successfully"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="User not found"))
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'],404);
        }

        $user->delete();

        return response()->json(['message'=> 'User deleted successfully'],200);
    }

    /**
     * Get the currently authenticated user.
     *
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get the currently authenticated user",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved user",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Get a user by id
     * 
     * @OA\Get(
     *      path="/api/user/{id}",
     *      summary="Get a user by id",
     *      tags={"User"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="The user with this id",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * )
     */

    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json($user);
    }

    /**
     * Get all users.
     *
     * @OA\Get(
     *     path="/api/admin/users",
     *     summary="Get all users",
     *     tags={"Admin"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Change the user's username.
     *
     * @OA\Post(
     *     path="/api/user/change-username",
     *     summary="Change the user's username",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="newUsername")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Username updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Username updated successfully"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function changeUsername(Request $request): JsonResponse
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
        ]);

        $user->name = $request->input('name');
        $user->save();

        return response()->json(['message' => 'Username updated successfully', 'user' => $user], 200);
    }

    /**
     * Change the user's password.
     *
     * @OA\Post(
     *     path="/api/user/change-password",
     *     summary="Change the user's password",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"current_password", "new_password", "new_password_confirmation"},
     *             @OA\Property(property="current_password", type="string", example="oldpassword"),
     *             @OA\Property(property="new_password", type="string", example="newpassword123"),
     *             @OA\Property(property="new_password_confirmation", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Password updated successfully"))
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Current password is incorrect",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Current password is incorrect"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function changePassword(Request $request): JsonResponse
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!\Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 403);
        }

        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully'],200);
    }

    /**
     * Change the password for the first admin login.
     *
     * @OA\Post(
     *     path="/api/admin/change-password-first-login",
     *     summary="Change password for the first login",
     *     tags={"Admin"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"new_password", "new_password_confirmation"},
     *             @OA\Property(property="new_password", type="string", example="newpassword123"),
     *             @OA\Property(property="new_password_confirmation", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password changed successfully",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Password changed successfully"))
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Password already changed",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Already changed password"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function changePasswordForFirstLogin(Request $request): JsonResponse
    {
        $user = auth()->user();

        if (! $user->is_first_login) {
            return response()->json(['message'=> 'Already changed password'], 403);
        }

        $request->validate([
            'new_password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($request->input('new_password'));
        $user->is_first_login = false;
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }
}
