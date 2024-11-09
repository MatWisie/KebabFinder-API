<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserAuthService
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

        if ($user->is_admin) {
            throw new ValidationException($validator, response()->json(['message' => 'Admins cannot login through user login route'], 403));
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return $token;
    }
}
