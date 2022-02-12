<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //
    public function register(Request $request)
        {
        $validatedData = $request->validate([
                  'username' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:8',
                        'role' => 'required|string|max:255',
                        'deposit' => 'required|int',
        ]);

            $user = User::create([
                        'username' => $validatedData['username'],
                        'email' => $validatedData['email'],
                        'password' => Hash::make($validatedData['password']),
                        'role' => $validatedData['role'],
                        'deposit' => $validatedData['deposit'],
            ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                    'access_token' => $token,
                        'token_type' => 'Bearer',
        ]);
        }

    public function login(Request $request)
        {
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
        'message' => 'Invalid login details'
                ], 401);
            }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
        ]);
        }

    
    public function me(Request $request)
    {
    return $request->user();
    }
}
