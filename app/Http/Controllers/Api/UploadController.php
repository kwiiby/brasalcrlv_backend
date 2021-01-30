<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function fileUpload(Request $request){
        if (isset($_FILES)){
            $file = $request->file('arquivo');
            $nome = @uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('certs')->putFileAs('/', $file, $nome);
            return response()->json([
                'status' => 200,
                'url' => $nome
            ], 200);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Erro upload!!!'
        ], 400);
    }
}
