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

        $aaaaaaa = storage_path() . '/certs/brasal.pem';

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
                'pragma' => 'no-cache',
                'cache-control' => 'no-cache',
            ],
        ];

        $client = new Client();
        $res = $client->get($URI, $config);
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
