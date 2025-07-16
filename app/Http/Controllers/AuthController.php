<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $validatedData = $request->all();

        DB::beginTransaction();
        try {
            $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'email_verified_at'=> now(),
            'is_active' => true,
            ]);

            $user->roles()->sync([User::Normal_User]);

            $token = $user->createToken(name: 'auth_token')->plainTextToken;

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Registration failed'], 500);
        }

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->all();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->is_active == User::STATUS_INACTIVE) {
            return response()->json(['message' => 'User is not active'], 403);
        }

        $token = $user->createToken(name: 'auth_token')->plainTextToken;

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'],200);
    }
}
