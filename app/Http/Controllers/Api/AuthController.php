<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'status' => 404,
            'errors' => 'Usuario e/ou senha invalidos'
        ], 404);
    }

    public function logout() {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'status' => 200,
            'message' => 'Logout efetuado com sucess.'
        ], 200);
    }

    public function changePassword(Request $request) {

        $this->validate($request, [
            'old_password' => 'required|min:4',
            'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:4',
            'logout' => 'required|boolean',
        ]);


        $user = Auth::user();

        if (Hash::check($request->get('old_password'), $user->password)) {
            $user->password = Hash::make($request->get('password'));
            $user->save();

            if ($request->get('logout')) {

                foreach ($user->tokens as $token) {
                    $token->revoke();
                    $token->delete();
                }
                return response()->json([
                    'status' => 205,
                    'message' => 'Senha alterada com sucesso, e logout efetuado em todos os locais.'
                ], 200);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Senha alterada com sucesso.'
            ]);
        }
        return response()->json([
            'status' => 403,
            'message' => 'A Senha atual informada não confere.'
        ], 403);
    }
}
