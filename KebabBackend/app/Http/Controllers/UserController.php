<?php

namespace App\Http\Controllers;

use \App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

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
