<?php

use App\Http\Controllers\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1/auth")->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get("login", "login");
        Route::get("forgot-password", "sendForgotPassword");
    });

    Route::middleware(["auth:api"])->group(function(){
        Route::post("logout", "logout");
    });
});
