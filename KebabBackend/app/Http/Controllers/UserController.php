<?php

namespace App\Http\Controllers;

use \App\Models\User;
use Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function isFirstLogin(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'is_first_login' => $user->is_first_login,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'],404);
        }

        $user->delete();

        return response()->json(['message'=> 'User deleted successfully'],200);
    }

    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }
}
