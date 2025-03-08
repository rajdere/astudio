<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    // Register a new user
    public function register(Request $request) {
        try{
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);
    
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
    
            return response()->json(["response"=>"success",'user' => $user], 201);
        }catch(Exception $e){
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    // Login a user
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Logout a user
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
