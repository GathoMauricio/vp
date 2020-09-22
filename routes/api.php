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
//Almacenar firma del usuario final
Route::middleware('auth:api')->post('/store_firma','ApiFirmaController@store')->name('store_firma');
//Obtener firma del usuario final
Route::middleware('auth:api')->get('/show_firma','ApiFirmaController@show')->name('show_firma');
//Almacenar firma del encargado
Route::middleware('auth:api')->post('/store_firma2','ApiFirmaController@store2')->name('store_firma2');
//Obtener firma del encargado
Route::middleware('auth:api')->get('/show_firma2','ApiFirmaController@show2')->name('show_firma2');
//Actualizar token FCM usuario
Route::middleware('auth:api')->post('/update_fcm_token','ApiUserController@updateFcmToken')->name('update_fcm_token');
//Subir evidencia camera
Route::middleware('auth:api')->post('/store_evidence','ApiServiceController@storeEvidence')->name('store_evidence');
//Subir evidencia gallery
Route::middleware('auth:api')->post('/upload_evidence','ApiServiceController@uploadEvidence')->name('upload_evidence');
//Cargar evidencias
Route::middleware('auth:api')->get('/index_evidencia','ApiServiceController@indexEvidencia')->name('index_evidencia');
//Cargar Mensajes
Route::middleware('auth:api')->get('/index_mensajes','ApiServiceController@indexMensajes')->name('index_mensajes');
//Insertar mensaje 
Route::middleware('auth:api')->post('/store_mensaje','ApiServiceController@storeMensaje')->name('store_mensaje');
//Iniciar un servicio
Route::middleware('auth:api')->post('/iniciar_servicio','ApiServiceController@iniciarServicio')->name('iniciar_servicio');
//Validar evidencias
Route::middleware('auth:api')->get('/validar_evidencia','ApiServiceController@validarEvidencia')->name('validar_evidencia');
//Finalizar servicio
Route::middleware('auth:api')->put('/finalizar_servicio','ApiServiceController@finalizarServicio')->name('finalizar_servicio');
//Reagendar servicio
Route::middleware('auth:api')->post('/reagendar_servicio','ApiServiceController@reagendarServicio')->name('reagendar_servicio');
//Cancelar servicio
Route::middleware('auth:api')->post('/cancelar_servicio','ApiServiceController@cancelarServicio')->name('cancelar_servicio');
//obtener reemplazos
Route::middleware('auth:api')->get('/index_reemplazo','ApiReemplazoController@index')->name('index_reemplazo');
//Almacenar firma del reemplazo
Route::middleware('auth:api')->post('/store_firma_reemplazo','ApiReemplazoController@storeFirma')->name('store_firma_reemplazo');
//Obtener retiros de equipo
Route::middleware('auth:api')->get('/index_retiro','ApiRetiroEquipoController@index')->name('index_retiro');
//Almacenar firma del retiro
Route::middleware('auth:api')->post('/store_firma_retiro','ApiRetiroEquipoController@storeFirma')->name('store_firma_retiro');
//Crear registro de equipo
Route::middleware('auth:api')->post('/store_retiro','ApiRetiroEquipoController@store')->name('store_retiro');
//Obtener calificación del servicio 
Route::middleware('auth:api')->get('/get_rate','ApiServiceController@getRate')->name('get_rate');
//Calificar servicio 
Route::middleware('auth:api')->post('/rate_service','ApiServiceController@rateService')->name('rate_service');
//mostrar firma del ususario
Route::middleware('auth:api')->get('/show_user_firm','ApiUserController@showFirm')->name('show_user_firm');
//Actualizar firma del empleado
Route::middleware('auth:api')->post('/update_my_firm','ApiUserController@updateFirm')->name('update_my_firm');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
