<?php

Route::group([
    'middleware' => ['cors', 'api'],
], function () {
    Route::post('/auth/issue', 'AuthController@issueToken');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::post('/auth/revoke', 'AuthController@revokeToken');
        Route::resource('/categories', 'CategoriesController', [
            'except' => ['create', 'edit'],
        ]);
    });
});
