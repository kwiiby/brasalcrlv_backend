<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
            'companies-list' => 'array',
            'companies-list.*' => 'exists:companies,id',
        ]);

        $u = new User($request->all());
        $u->save();
        $u->companies()->attach($request->get('companies-list'));

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
        return response()->json($u, 200);
    }

    public function destroy($id)
    {
        $u = User::findOrFail($id);
        return response()->json($u, 200);
    }
}
