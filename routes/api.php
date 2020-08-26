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
//Obtiene los servicios de cada usuario dependiendo de su rol
Route::middleware('auth:api')->get('/index_service','ApiServiceController@index')->name('index_service');
//Obtiene todos los datos de un servicio en particular
Route::middleware('auth:api')->get('/show_service','ApiServiceController@show')->name('show_service');
//Almacenar firma del usuario atendido
Route::middleware('auth:api')->post('/store_firma','ApiFirmaController@store')->name('store_firma');
//Obtener firma del usuario_final
Route::middleware('auth:api')->get('/show_firma','ApiFirmaController@show')->name('show_firma');
//Actualizar token FCM usuario
Route::middleware('auth:api')->post('/update_fcm_token','ApiUserController@updateFcmToken')->name('update_fcm_token');
//Subir evidencia camera
Route::middleware('auth:api')->post('store_evidence','ApiServiceController@storeEvidence')->name('store_evidence');
//Subir evidencia gallery
Route::middleware('auth:api')->post('upload_evidence','ApiServiceController@uploadEvidence')->name('upload_evidence');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
