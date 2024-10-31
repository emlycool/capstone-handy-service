<?php

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\OnboardingController;


Route::prefix("v1/onboarding")->controller(OnboardingController::class)->group(function(){
    Route::group([], function(){
        Route::post("register", "registerUser");

        Route::get("provinces", "listProvinces");
        Route::get("cities", "listCities");
    });

    Route::middleware(["auth:api"])->group(function(){
        Route::prefix("provider")->group(function(){
            Route::post('/', "storeProvider");
            Route::middleware(["role:".RoleEnum::SERVICE_PROVIDER->value])->group(function(){
                Route::put("/", "updateProvider");
            });
        });

        Route::put("user", "updateUser");

    });
});
