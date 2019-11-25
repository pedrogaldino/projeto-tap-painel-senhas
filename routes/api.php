<?php


Route::group(['namespace' => 'API'], function() {

    Route::get('filas', 'FilasController@index');

    Route::get('filas/{fila}', 'FilasController@view');

    Route::post('filas/{fila}/senhas', 'SenhasController@store');

    Route::put('/senhas/notifications', 'SenhasController@notification');


    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

        Route::get('filas', 'FilasController@index');

        Route::put('filas/{senha}/chamar', 'FilasController@chamar');

    });

});
