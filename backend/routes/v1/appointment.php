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
            Route::post("available-slots", "getAvailableSlots");

            Route::prefix("client/list")->group(function(){
                Route::get("/", "clientList");
                Route::get("/{id}", "show");
            });
        });


        Route::middleware(['role:' . RoleEnum::SERVICE_PROVIDER->value])->group(function(){
            Route::prefix("provider/list")->group(function(){
                Route::get("/", "providerList");
                Route::get("/{id}", "show");
            });
            Route::post("accept", "acceptBooking");
            Route::post("reject", "rejectBooking");
        });
    });
