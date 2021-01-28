<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'cpf' => 'required|max:11',
            'email' => 'required|unique:users,email|max:160'
        ]);

        $a = $request->all();
        return response()->json($a, 200);
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
