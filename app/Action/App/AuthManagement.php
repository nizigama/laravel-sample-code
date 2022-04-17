<?php

declare(strict_types=1);

namespace App\Action\App;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthManagement
{
    public static function registerNewUser(string $name, string $email, string $password): ?string
    {
        try {
            /** @var User */
            $user = User::create([
                "name" => $name,
                "email" => $email,
                "password" => Hash::make($password),
            ]);

            return $user->createToken("userAuthToken")->plainTextToken;
        } catch (\Throwable $th) {
            Log::error("Failed registering a new user", [
                "exception" => $th
            ]);
        }
    }

    public static function loginUser(User $user): string
    {
        $user->tokens()->delete();
        return $user->createToken("userAuthToken")->plainTextToken;
    }
}
