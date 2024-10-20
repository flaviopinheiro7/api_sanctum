<?php

namespace App\Http\Controllers;

use App\Services\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        // login attempt
        $attempt = auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$attempt) {
            return ApiResponses::unauthorized();
        }

        // authenticate user
        $user = auth()->user();


        // $token = $user->createToken($user->name)->plainTextToken;
        
        $token = $user->createToken($user->name, ["*"], now()->addHour())->plainTextToken;

        // return access token

        return ApiResponses::success([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ApiResponses::success('Logout success');
    }

    // public function logout(Request $request)
    // {
    //     $request->user()->tokens()->delete();
    //     return ApiResponses::success('Logout success');
    // }

}
