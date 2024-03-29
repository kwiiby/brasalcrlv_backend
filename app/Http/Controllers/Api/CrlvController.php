<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrlvController extends Controller
{
    public function generate(Request $request)
    {
        $this->validate($request, [
            'placa' => 'required|min:7|max:7',
            'renavam' => 'required|min:6',
            'company' => 'exists:companies,id',
        ]);

        $path = storage_path();
        $c = Company::find($request->get('company'));

        $ws = env('SERPRO', 'https://hom.wsdenatran.estaleiro.serpro.gov.br/v3');

        $URI = "{$ws}/veiculos/crlv/placa/{$request->get('placa')}/renavam/{$request->get('renavam')}";

        if ($request->get('filial') != null && $request->get('filial') != '') {
            $URI .= "/cnpj/{$request->get('filial')}";
        }

        $config = [
            'cert' => ["{$path}/certs/{$c->certificate_pem}", $c->certificate_password],
            'ssl_key' => ["{$path}/certs/{$c->certificate_key}", $c->certificate_password],
            'connect_time_out' => 650,
            'protocols' => ['https'],
            'verify' => false,
            'headers' => [
                'x-cpf-usuario' => Auth::user()->cpf,
                'accept' => 'application/json; charset=utf-8',
                'Content-Type' => 'application/json',
                'pragma' => 'no-cache',
                'cache-control' => 'no-cache',
            ],
        ];

        $client = new Client();
        $response = $client->request('get', $URI, $config);

        if ($response->getStatusCode() == 200) {
            $res = json_decode($response->getBody());
            return response()->json(['base64' => $res->pdfBase64], 200);
        }
        return response()->json([
            'status' => 'error'
        ], 404);
    }
}
