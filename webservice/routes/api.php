<?php

Route::group([
    'middleware' => ['cors', 'api'],
], function () {
    Route::post('/auth/issue', 'AuthController@issueToken');
    Route::post('/auth/refresh', 'AuthController@refreshToken');

    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::post('/auth/revoke', 'AuthController@revokeToken');
        Route::get('/categories/full-list', ['uses' => 'CategoriesController@fullList']);
        Route::resource('/categories', 'CategoriesController', [
            'except' => ['create', 'edit'],
        ]);

        Route::resource('/products', 'ProductsController', [
            'except' => ['create', 'edit'],
        ]);
    });
});
