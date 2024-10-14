<?php

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AppointmentController;


Route::prefix("v1/appointment")
    ->controller(AppointmentController::class)
    ->group(function(){

        Route::middleware(['role:' . RoleEnum::CLIENT->value])->group(function(){
            Route::post("book", "book");
            Route::post("cancel", "cancel");
            Route::post("reschedule", "reschedule");
            Route::get("/", "list");
            Route::get("/{id}", "show");
        });

        Route::middleware(['role:' . RoleEnum::CLIENT->value . ',' . RoleEnum::SERVICE_PROVIDER->value])->group(function(){
            Route::get("/", "list");
            Route::get("/{id}", "show");
        });

        Route::middleware(['role:' . RoleEnum::SERVICE_PROVIDER->value])->group(function(){
            Route::post("accept", "acceptBooking");
            Route::post("reject", "rejectBooking");
        });
    });
