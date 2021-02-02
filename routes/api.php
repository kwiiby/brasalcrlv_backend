<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Login routes
Route::group([
    'namespace' => 'App\Http\Controllers\Api'
], function(){

    Route::post('login', 'AuthController@login');

});

// Logged-in routes
Route::group([
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'auth:api',
], function(){

    Route::get('logout', 'AuthController@logout');
    Route::post('change_password', 'AuthController@changePassword');

    Route::resource('users', 'UsersController')->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('companies', 'CompaniesController')->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('generate', 'CrlvController@generate');

    // upload pem and key
    Route::post('upload', 'UploadController@fileUpload');
});
