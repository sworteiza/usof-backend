<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;


class Reset extends Controller
{
    public function reset(Request $request){
        $cred = $request->validate(['email' => 'required|string']);

        Password::sendResetLink($cred);

        return [
            'message' => 'email send',
        ];
    }

}
