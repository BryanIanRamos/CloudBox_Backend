<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email',
            'password' => ['required', 'string', Password::min(6)->mixedCase()->numbers()->symbols()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'Account has been registered!',
            'user' => $user['name'],
            'token' => $token,
        ]);
    }

    public function login(Request $request){

        $request->validate([
            'email'=>'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password.' 
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login Successfully.',
            'bearer-token' => $token,
        ], 200);
    }

    public function logout(Request $request){
        
        try{
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Logout Successfully.'
            ], 200);

        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'error' => $e
            ], 401);
        }
    }
}
