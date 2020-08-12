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
//Obtener token a partir del login (email y contraseña)
Route::get('/login','ApiUserController@login')->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
