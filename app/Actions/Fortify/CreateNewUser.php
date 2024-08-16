<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateNewUser
{
    use PasswordValidationRules;


    public function login(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
    
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json([
                'status' => 'success',
                'user' => auth()->user()->name,
                'email' => $request['email'],
                'token' => $token,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json($user, 201);

    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
