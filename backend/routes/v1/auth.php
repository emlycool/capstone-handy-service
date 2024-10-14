<?php

use App\Http\Controllers\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1/auth")->controller(AuthController::class)->group(function(){
    Route::group([], function(){
        Route::post("login", "login");
        Route::post("forgot-password", "sendForgotPassword");
        Route::post("reset-password", "resetPassword");
        Route::post("logout", "logout");
    });

    Route::middleware(["auth:api"])->group(function(){
        Route::post("logout", "logout");
    });
});
