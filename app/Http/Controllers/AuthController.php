<?php

namespace App\Http\Controllers;

use auth;

//to use bcrypt for password hashing
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
        

    }
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)){
            return response([
                'message' => 'INVALID CREDENTIALS!'
            ], 401);
        } 

        

        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
        

    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out!'
        ];
    }
}
