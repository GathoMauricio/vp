<?php
//Rutas de autenticación
Auth::routes();
//Rutas no autenticadas
Route::get('/', function () {
    return view('index');
})->middleware('guest');
//Rutas autenticadas
Route::middleware(['check_login'])->group(function () {

    //Retorna la vista principal del sistema en este caso los servicios
    Route::get('dashboard','ServiceController@index')->name('dashboard');
    Route::get('index_ajax','ServiceController@indexAjax')->name('index_ajax');
    #RUTAS PARA USUARIOS
    //Retorna la lista de usuarios del sistema
    Route::get('index_user', 'UserController@index')->name('index_user');

    //Retorna el formulario de registro de un usuario
    Route::get('create_user', 'UserController@create')->name('create_user');

    //Inserta un nuevo usuario
    Route::post('store_user', 'UserController@store')->name('store_user');

    //Retorna un usuario especifico
    Route::get('show_user/{id}', 'UserController@show')->name('show_user');

    //Retorna el formulario para editar un usuario
    Route::get('edit_user/{id}', 'UserController@edit')->name('edit_user');

    //Actualiza la información de un usuario
    Route::put('update_user/{id}', 'UserController@update')->name('update_user');

    //Retorna el formulario de confirmación para eliminar un usuario
    Route::get('confirm_user/{id}', 'UserController@confirm')->name('confirm_user');

    //Elimina completamente a un usuario
    Route::delete('destroy_user/{id}', 'UserController@destroy')->name('destroy_user');

    //Retorna el formulario para cambiar la contraseña de un usuario
    Route::get('edit_pwd_user/{id}','UserController@editPwd')->name('edit_pwd_user');

    //Actualiza la contraseña de un usuario
    Route::put('update_pwd_user/{id}','UserController@updatePwd')->name('update_pwd_user');

    #RUTAS PARA CLIENTES
    //Retorna la lista de usuarios del sistema
    Route::get('index_customer', 'CustomerController@index')->name('index_customer');

    //Retorna el formulario de registro de un usuario
    Route::get('create_customer', 'CustomerController@create')->name('create_customer');

    //Inserta un nuevo usuario
    Route::post('store_customer', 'CustomerController@store')->name('store_customer');

    //Retorna un usuario especifico
    Route::get('show_customer/{id}', 'CustomerController@show')->name('show_customer');

    //Retorna el formulario para editar un usuario
    Route::get('edit_customer/{id}', 'CustomerController@edit')->name('edit_customer');

    //Actualiza la información de un usuario
    Route::put('update_customer/{id}', 'CustomerController@update')->name('update_customer');

    //Retorna el formulario de confirmación para eliminar un usuario
    Route::get('confirm_customer/{id}', 'CustomerController@confirm')->name('confirm_customer');

    //Elimina completamente a un usuario
    Route::delete('destroy_customer/{id}', 'CustomerController@destroy')->name('destroy_customer');

     #RUTAS PARA SERVICIOS
    //Retorna la lista de servicio del sistema
    Route::get('index_service', 'ServiceController@index')->name('index_service');

    //Retorna el formulario de registro de un servicio
    Route::get('create_service', 'ServiceController@create')->name('create_service');

    //Inserta un nuevo servicio
    Route::post('store_service', 'ServiceController@store')->name('store_service');

    //Retorna un servicio especifico
    Route::get('show_service/{id?}', 'ServiceController@show')->name('show_service');

    //Retorna el formulario para editar un servicio
    Route::get('edit_service/{id}', 'ServiceController@edit')->name('edit_service');

    //Actualiza la información de un servicio
    Route::put('update_service/{id}', 'ServiceController@update')->name('update_service');

    //Retorna el formulario de confirmación para eliminar un servicio
    Route::get('confirm_service/{id}', 'ServiceController@confirm')->name('confirm_service');

    //Elimina completamente a un servicio
    Route::delete('destroy_service/{id}', 'ServiceController@destroy')->name('destroy_service');

    //Carga el combo dinámigo con los empleados
    Route::get('cargar_empleados','ServiceController@loadEmployees')->name('cargar_empleados');

    //Carga el combo dinámico de usuarios finales 
    Route::get('cargar_usuario_final','ServiceController@loadFinalUsers')->name('cargar_usuario_final');

    //Imprime el formato del servicio en pdf
    Route::get('formato_pdf_servicio/{id}','ServiceController@printSErviceFormat')->name('formato_pdf_servicio');

    #Rutas para usuarios finales 
    //Retorna formulario para crear un usuario final
    Route::get('create_final_user/{id}','FinalUserController@create')->name('create_final_user');

    //Obtiene datos de sepomex
    Route::get('getSepomex','SepomexController@getSepomex')->name('getSepomex');

    //Inserta un nuevo usuario final
    Route::post('store_final_user','FinalUserController@store')->name('store_final_user');

    //Inserta un nuevo usuario final ajax
    Route::post('store_final_user_ajax','FinalUserController@storeAjax')->name('store_final_user_ajax');
    
    //Muesra un usuario final en particular
    Route::get('show_final_user/{id}','FinalUserController@show')->name('show_final_user');

    //Muestra mensaje de confirmación para eliminar un usuario final en particular
    Route::get('confirm_final_user/{id}','FinalUserController@confirm')->name('confirm_final_user');

    //Elimina por completo un usuario final en particular
    Route::delete('destroy_final_user/{id}','FinalUserController@destroy')->name('destroy_final_user');

    //Muestra formulario de edicioón para usuario final
    Route::get('edit_final_user/{id}','FinalUserController@edit')->name('edit_final_user');

    //Actualiza los datos de un usuario final
    Route::put('update_final_user/{id}','FinalUserController@update')->name('update_final_user');

    //Inserta un nuevo comentario a un servicio
    Route::post('store_comment','CommentController@store')->name('store_comment');

    //retorna la pantalla de cambio de estatus 
    Route::get('edit_status_service/{id}/{status}','ServiceController@editStatusService')->name('edit_status_service');

    Route::post('update_status_service','ServiceController@updateStatusService')->name('update_status_service');
    //Route subir archivos al servidor
    Route::post('subir_archivo','ServiceController@uploadFile')->name('subir_archivo');

    //Obtener dirección de la empresa para usuario final 
    Route::get('get_customer_address','FinalUserController@getCustomerAddress')->name('get_customer_address');

    //Cargar mensajes push
    Route::get('cargar_mensajes_push','NotificationController@cargarMensajesPush')->name('cargar_mensajes_push');

    //Abrir mensaje de burbuja
    Route::get('open_message/{id}/{service_id}','NotificationController@openMessage')->name('open_message');

    //Route almacenar un nuevo producto
    Route::post('store_producto','ProductoController@store')->name('store_producto');

    //Cagar todos los mensajes
    Route::get('index_mensajes','MensajeController@index')->name('index_mensajes');

    //Cargar todos los pendientes
    Route::get('index_pendiente','PendienteController@index')->name('index_pendiente');

    //Obtener bitacora ajax
    Route::get('get_bitacora_ajax','BitacoraController@getBitacoraAjax')->name('get_bitacora_ajax');

    //Inserta bitacora ajax
    Route::post('store_comment','BitacoraController@store')->name('store_comment');

    //Buscar servicios por parametros
    Route::get('search_service','ServiceController@searchService')->name('search_service');
});

Route::get('fcm', function(){
    //return sendFcm();
})->name('fcm');

