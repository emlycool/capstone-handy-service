<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1/user")->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get("me", "me");

    });
});

