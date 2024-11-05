<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthService
{
    public function authenticate(array $credentials): void
    {
        $user = User::where("email", $credentials["email"])->first();

        if (!$user || !$user->is_admin) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }    
}