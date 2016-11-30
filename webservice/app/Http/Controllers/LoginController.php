<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use JWTException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json(['messages' => ['E-mail ou senha não conferem']], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['messages' => ['Não foi possível gerar o token']], 500);
        }

        $user = Auth::guard('api')->user();

        // all good so return the token
        return response()->json(compact('token', 'user'));
    }
}
