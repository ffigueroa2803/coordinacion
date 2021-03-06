<?php

/*
\DB::listen(function($query) {
    echo "<pre>{$query->sql}</pre>";
});
*/

// api en la version 1
Route::group(['prefix' => "v1"], function() {

    //Agregamos nuestra ruta al controller
    Route::resource('document', 'DocumentController')->except('create', 'edit');
    Route::resource('type_document', 'TypeDocumentController');
    Route::resource('type_request', 'TypeRequestController');

    // authenticacion
    Route::post("/login", "AuthController@login");
    // cerrar sesión
    Route::post("/logout", "AuthController@logout");
    // obtener usuario authenticado
    Route::get("/me", "AuthController@me");
    // obtener perfiles
    Route::get('/profile', 'AuthController@profile');

});