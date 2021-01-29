<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrlvController extends Controller
{
    public function generate(Request $request)
    {
//        $response = $client->post(
//            $endpoint, [
//                'json' => $content,
//                'headers' => $headers,
//                'connect_timeout' => 650,
//                // add these
//                'cert' => '/path/to/openyes.crt.pem',
//                'ssl_key' => '/path/to/openyes.key.pem'
//            ]
//        );

        $URI = "https://hom-wsdenatran.estaleiro.serpro.gov.br/v3/veiculos/crlv/placa/{$request->get('placa')}/renavam/{$request->get('renavam')}";
        $config = [
            'cert' => [storage_path() . '/certs/brasal_2.pem', 'brasal'],
            'ssl_key' => [storage_path() . '/certs/brasal.key', 'brasal'],
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
            return response()->json($res->pdfBase64, 200);
        }
        return response()->json([
            'status' => 'error'
        ], 404);
    }
}
