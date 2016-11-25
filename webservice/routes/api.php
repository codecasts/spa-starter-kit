<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['cors', 'api']], function () {
    Route::post('login', ['uses' => 'LoginController@login']);
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::group(['prefix' => 'categorias'], function () {
            Route::get('', ['uses' => 'CategoriesController@all']);
            Route::delete('{id}/remover', ['uses' => 'CategoriesController@remove']);
        });
    });
});

