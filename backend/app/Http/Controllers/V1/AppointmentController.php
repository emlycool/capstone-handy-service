<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\BookAppointmentRequest;
use App\Http\Requests\Appointment\GetAppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $appointmentService
    )
    {
        
    }

    public function book(BookAppointmentRequest $request): JsonResponse
    {

    }

    public function cancel(GetAppointmentRequest $request): JsonResponse
    {

    }

    public function reschedule(GetAppointmentRequest $request): JsonResponse
    {

    }
}
