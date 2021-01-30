<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
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

            $user = $request->user();
            $tokenCreate = $user->createToken('Personal Access Token');
            $tokenCreate->token->expires_at = $request->remember_me ? Carbon::now()->addDays(30) : Carbon::now()->addHours(12);
            $tokenCreate->token->save();

            return response()->json([
                'access_token' => $tokenCreate->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenCreate->token->expires_at)->toDateTimeString(),
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
