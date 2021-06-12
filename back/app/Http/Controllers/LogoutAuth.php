<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class LogoutAuth extends Controller
{
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return[
        'message' => 'You were logged out'
        ];
    }
    
}
