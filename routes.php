<?php

Route::group([
        'prefix' => 'jwt',
    ], static function () {

    Route::post('login', \ReaZzon\JWTAuth\Http\Controllers\AuthController::class);
    Route::post('refresh', \ReaZzon\JWTAuth\Http\Controllers\RefreshController::class);
    Route::post('register', \ReaZzon\JWTAuth\Http\Controllers\RegistrationController::class);
    Route::post('activate', \ReaZzon\JWTAuth\Http\Controllers\ActivationController::class);
});
