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
        $valid = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ], [
            'email.required'    => 'Email is required',
            'email.email'       => 'Email must be an email address',
            'password.required' => 'Password is required'
        ]);

        if ($valid->fails()) {
            return ApiFormatter::sendValidationError('Validation failed', $valid->errors()->toArray());
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

        if (!$user) {
            return ApiFormatter::sendUnauthorized('You must be logged in to perform this action');
        }

        if ($user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return ApiFormatter::sendSuccess('Logout successful');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return ApiFormatter::sendUnauthorized('Unauthorized access');
        }

        return ApiFormatter::sendSuccess('User data retrieved successfully', new AuthResource($user));
    }
}
