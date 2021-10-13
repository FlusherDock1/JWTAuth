<?php

Route::group(['prefix' => 'jwt'], function () {

    Route::post('login', [\ReaZzon\JWTAuth\Controllers\Authentication::class, 'login']);
    Route::post('register', [\ReaZzon\JWTAuth\Controllers\Authentication::class, 'register']);
    Route::post('refresh', [\ReaZzon\JWTAuth\Controllers\Authentication::class, 'refresh']);

});
