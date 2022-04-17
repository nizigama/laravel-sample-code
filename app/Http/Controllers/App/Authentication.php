<?php

declare(strict_types=1);

namespace App\Http\Controllers\App;

use App\Action\App\AuthManagement;
use App\Action\App\UserManagement;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;

class Authentication extends Controller
{
    public function register(RegistrationRequest $request)
    {

        if ($token = AuthManagement::registerNewUser($request->name, $request->email, $request->password)) {
            return response()->json(["token" => $token]);
        }

        return response()->json(["message" => "Registration failed"], 500);
    }

    public function signin(LoginRequest $request)
    {

        $token = AuthManagement::loginUser($request->user);
        return response()->json(["token" => $token]);
    }
}
