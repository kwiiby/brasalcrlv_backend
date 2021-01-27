<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 406,
                'errors' => $validator->errors()
            ], 406);
        }

        if (Auth::attempt($request->only(['email', 'password']))) {
            $token = Auth::user()->createToken('users')->accessToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'refresh_token' => null,
                'user' => Auth::user(),
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'errors' => 'Usuario e/ou senha invalidos'
        ], 200);
    }
}
