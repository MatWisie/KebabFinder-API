<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AdminAuthService
{
    public function login(array $data)
    {
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new ValidationException($validator, response()->json(['message' => 'Invalid credentials'], 401));
        }

        if (!$user->is_admin) {
            throw new ValidationException($validator, response()->json(['message' => 'Only admins can login here'], 403));
        }

        $token = $user->createToken('Admin API Token')->plainTextToken;

        return $token;
    }
}
