<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['cors', 'api']], function () {
    Route::post('login', ['uses' => 'LoginController@login']);
});

