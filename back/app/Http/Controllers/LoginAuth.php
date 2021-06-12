<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginAuth extends Controller
{
    public function login(Request $request){
        $input = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        
        ]);

        $user = User::where('login', $input['login'])->first();
        if(!$user || !Hash::check($input['password'], $user->password)){
            return response([
                'message' => 'Incorrect login or password'
            ], 401);
        }

        $token = $user->createToken('userToken')->plainTextToken;
        $response =[
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
