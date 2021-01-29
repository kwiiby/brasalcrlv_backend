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
        $this->validate($request, [
            'name' => 'required|max:255',
            'cnpj' => 'required|max:255',
            'certificate' => 'required|max:255',
            'certificate_password' => 'required|unique|max:160',
            'certificate_expire' => 'required|unique|max:160'
        ]);

    }

    public function show($id)
    {
        $c = Company::findOrFail($id);
        return response()->json($c, 200);
    }

    public function update(Request $request, $id)
    {
        $c = Company::findOrFail($id);
        $c->update($request->only(['name', 'cnpj', 'certificate_expire']));

        if ($request->get('certificate_password') && $request->get('certificate_password') != '') {
            $c->certificate_password = $request->get('certificate_password');
            $c->save();
        }

        $aaa = $request->file('fileSource');


        return response()->json($c, 200);
    }

    public function destroy($id)
    {
        $c = Company::findOrFail($id);
        return response()->json($c, 200);
    }
}
