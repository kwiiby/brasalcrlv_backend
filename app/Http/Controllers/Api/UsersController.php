<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index()
    {
        $u = User::get();
        return response()->json($u, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:200',
            'lastname' => 'required|max:200',
            'cpf' => 'required|min:11|max:11',
            'email' => 'required|unique:users,email|max:160|regex:/^[A-Za-z0-9\.]*@(brasal)[.](com)[.](br)$/',
            'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:4',
            'permission' => 'required',
            'companies_list' => 'array',
            'companies_list.*' => 'exists:companies,id',
        ]);

        $u = new User($request->only('name','lastname', 'cpf', 'email', 'permission'));
        $u->password = Hash::make($request->get('password'));
        $u->remember_token = Str::random(10);
        $u->save();
        $u->companies()->attach($request->get('companies_list'));

        return response()->json($u, 200);
    }

    public function show($id)
    {
        $u = User::findOrFail($id);
        return response()->json($u, 200);
    }

    public function update(Request $request, $id)
    {
        $u = User::findOrFail($id);
        $u->update($request->only(['name', 'lastname', 'email', 'cpf', 'permission']));

        $u->companies()->sync($request->get('companies_list'));

        if ($request->get('password') != null && $request->get('password') != '') {
            $u->password = Hash::make($request->get('password'));
            $u->save();
        }

        return response()->json($u, 200);
    }

    public function destroy($id)
    {
        $u = User::findOrFail($id);
        $u->delete();
        return response()->json([
            'message' => 'Usuario removido com sucesso.',
        ], 200);
    }
}
