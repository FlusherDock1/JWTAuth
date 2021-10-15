<?php

Route::group([
        'prefix' => 'jwt',
        'namespace' => 'ReaZzon\\JWTAuth\\Http\\Controllers',
    ], static function () {

    Route::post('login', 'AuthController');
    Route::post('refresh', 'RefreshController');
    Route::post('register', 'RegistrationController');
});
