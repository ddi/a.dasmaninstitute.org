<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        echo "hello V1";
        // $user = User::where("username", "mohammad.alqersh")->first();
        // echo "<pre>";
        // $token = $user->createToken("authToken")->plainTextToken;
        // print_r($token);
        // echo "\n";
        // print_r($user);
    }
}
