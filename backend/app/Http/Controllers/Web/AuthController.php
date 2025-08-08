<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $valid = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$valid) {
            return ApiFormatter::sendValidationError('Validation failed');
        }

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return ApiFormatter::sendUnauthorized('Invalid email or password');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;

        return ApiFormatter::sendSuccess('Login successful', [
            'user' => new AuthResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return ApiFormatter::sendSuccess('Logout successful');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return ApiFormatter::sendSuccess('User data retrieved successfully', new AuthResource($user));
    }
}
