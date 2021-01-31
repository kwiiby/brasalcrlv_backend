<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;
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
            'cnpj' => 'required|min:14|max:14',
            'pem' => 'required|max:255',
            'key' => 'required|max:160',
            'certificate_expire' => 'required|max:160',
            'certificate_password' => 'required|max:160',
        ]);

        $c = new Company();
        $c->name = $request->get('name');
        $c->cnpj = $request->get('cnpj');
        $c->certificate_pem = $request->get('pem');
        $c->certificate_key = $request->get('key');
        $c->certificate_password = $request->get('certificate_expire');
        $c->certificate_expire = Carbon::parse($request->get('certificate_expire'))->format('Y-m-d');
        $c->save();
        return response()->json($c, 200);
    }

    public function show($id)
    {
        $c = Company::findOrFail($id);
        return response()->json($c, 200);
    }

    public function update(Request $request, $id)
    {
        $c = Company::findOrFail($id);
        $c->update($request->only(['name', 'cnpj']));

        if ($request->get('certificate_expire') && $request->get('certificate_expire') != '') {
            $c->certificate_expire = Carbon::parse($request->get('certificate_expire'))->format('Y-m-d');
            $c->save();
        }

        if ($request->get('pem') && $request->get('pem') != '' && $request->get('key') && $request->get('key') != '' ) {
            $c->certificate_key = $request->get('key');
            $c->certificate_pem = $request->get('pem');
            $c->save();
        }

        if ($request->get('certificate_password') && $request->get('certificate_password') != '') {
            $c->certificate_password = base64_encode($request->get('certificate_password'));
            $c->save();
        }
        return response()->json($c, 200);
    }

    public function destroy($id)
    {
        $c = Company::findOrFail($id);
        $c->delete();
        return response()->json([
            'message' => 'Empresa removido com sucesso.',
        ], 200);
    }
}
