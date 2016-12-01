<?php

Route::group([
    'middleware' => ['cors', 'api'],
], function () {
    Route::post('/login', 'LoginController@login');

    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::resource('/categories', 'CategoriesController', [
            'except' => ['create', 'edit'],
        ]);
    });
});
