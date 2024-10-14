<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\V1\ServiceCategoryController;
use App\Http\Controllers\V1\ServiceController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1/services")->group(function(){

    Route::prefix('categories')->controller(ServiceCategoryController::class)->group(function(){
            // categories
        Route::prefix('categories')->group(function(){
            Route::get("/", "index");
            Route::get("/{id}", "show");
        });
        Route::prefix('categories')->middleware(["auth:api", "role:".RoleEnum::ADMIN->value])->group(function(){
            Route::post("/", "store");
            Route::put("/", "update");
            Route::delete("/{id}", "destroy");
        });
    });

    Route::controller(ServiceController::class)->group(function(){
        // services
        Route::get("/", "index");
        Route::get("/{id}", "show");

        Route::prefix('/')->middleware(["auth:api", "role:".RoleEnum::SERVICE_PROVIDER->value])->group(function(){
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy");
        });
    });

});
