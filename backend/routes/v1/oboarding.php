<?php

use App\Http\Controllers\V1\OnboardingController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1/onboarding")->controller(OnboardingController::class)->group(function(){
    Route::group([], function(){
        Route::post("register", "registerUser");

        Route::get("provinces", "listProvinces");
        Route::get("cities", "listCities");
    });

    Route::middleware(["auth:api"])->group(function(){
        Route::prefix("provider")->group(function(){
            Route::post('/', "storeProvider");
        });
    });
});
