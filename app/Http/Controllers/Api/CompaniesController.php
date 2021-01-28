<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CompaniesController extends Controller
{

    public function index()
    {
        $c = Company::all();
        return response($c, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'cnpj' => 'required|max:255',
            'certificate' => 'required|max:255',
            'certificate_password' => 'required|unique|max:160',
            'certificate_expire' => 'required|unique|max:160'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function show($id)
    {
        $c = Company::findOrFail($id);
        return response()->json($c, 200);
    }

    public function update(Request $request, $id)
    {
        $c = Company::findOrFail($id);
        return response()->json($c, 200);
    }

    public function destroy($id)
    {
        $c = Company::findOrFail($id);
        return response()->json($c, 200);
    }
}
