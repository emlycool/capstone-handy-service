<?php

namespace App\Http\Controllers\V1;

use Illuminate\Support\Arr;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Exceptions\ApiNotFoundException;
use App\Http\Resources\AppointmentResource;
use App\Actions\Appointment\GetAppointmentAction;
use App\Actions\Appointment\ListAppointmentAction;
use App\Actions\Provider\Service\GetServiceAction;
use App\Http\Requests\Appointment\GetAppointmentRequest;
use App\Http\Requests\Appointment\BookAppointmentRequest;
use App\Http\Requests\Appointment\ListAppointmentRequest;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $appointmentService
    )
    {
        
    }

    public function book(BookAppointmentRequest $request): JsonResponse
    {
        $appointment = $this->appointmentService
            ->bookAppointment(auth()->user(), $request->validated());

        return (new ApiResponse(
            data: AppointmentResource::make($appointment)->toArray(request()),
            message: 'Appointment booked successfully',
        ))->asCreated();
    }

    public function cancel(GetAppointmentRequest $request, int $id): JsonResponse
    {
        $appointment = resolve(GetAppointmentAction::class)
        ->handle(
            id: $id
        );
        throw_if(!$appointment, new ApiNotFoundException(msg: "appointment not found"));

        $this->appointmentService
            ->cancelAppointment(auth()->user(), $request->id);

        return (new ApiResponse(
            message: 'Appointment cancelled successfully',
        ))->asSuccessful();

    }

    public function reschedule(GetAppointmentRequest $request, int $id): JsonResponse
    {
        $appointment = resolve(GetAppointmentAction::class)
            ->handle(
                id: $id
            );
        throw_if(!$appointment, new ApiNotFoundException(msg: "appointment not found"));

        $this->appointmentService
            ->rescheduleAppointment(auth()->user(), $request->id, $request->validated());

        return (new ApiResponse(
            message: 'Appointment rescheduled successfully',
        ))->asSuccessful();
    }

    public function clientList(ListAppointmentRequest $request): JsonResponse
    {
        $appointments = resolve(ListAppointmentAction::class)
            ->handle(
                client: auth()->user(),
                requestData: $request->validated()
            );
        
        return (new ApiResponse(
            data: AppointmentResource::collection($appointments)->toArray(request()),
            message: 'Appointments fetched successfully',
            meta: Arr::except($appointments->toArray(), ['data'])
        ))->asSuccessful();
    }

    public function providerList(ListAppointmentRequest $request): JsonResponse
    {
        $appointments = resolve(ListAppointmentAction::class)
            ->handle(
                provider: auth()->user(),
                requestData: $request->validated()
            );
        
        return (new ApiResponse(
            data: AppointmentResource::collection($appointments)->toArray(request()),
            message: 'Appointments fetched successfully',
            meta: Arr::except($appointments->toArray(), ['data'])
        ))->asSuccessful();
    }

    public function show(GetAppointmentRequest $request, int $id): JsonResponse
    {
        $appointment = resolve(GetAppointmentAction::class)
            ->handle(
                id: $id
            );
        throw_if(!$appointment, new ApiNotFoundException(msg: "appointment not found"));
        
        return (new ApiResponse(
            data: AppointmentResource::make($appointment)->toArray(request()),
            message: 'Appointment fetched successfully',
        ))->asSuccessful();
    }

    public function acceptBooking(GetAppointmentRequest $request, int $id): JsonResponse
    {
        $appointment = resolve(GetAppointmentAction::class)
            ->handle(
                id: $id
            );
        throw_if(!$appointment, new ApiNotFoundException(msg: "appointment not found"));

        $this->appointmentService
            ->acceptAppointmentBooked(auth()->user(), $appointment);

        return (new ApiResponse(
            message: 'Appointment confirmed successfully',
        ))->asSuccessful();
    }

    public function rejectBooking(GetAppointmentRequest $request, int $id): JsonResponse
    {
        $appointment = resolve(GetAppointmentAction::class)
            ->handle(
                id: $id
            );
        throw_if(!$appointment, new ApiNotFoundException(msg: "appointment not found"));

        $this->appointmentService
            ->rejectAppointmentBooked(auth()->user(), $appointment);

        return (new ApiResponse(
            message: 'Appointment rejected successfully',
        ))->asSuccessful();
    }

    public function getAvailableSlots(GetAppointmentRequest $request): JsonResponse
    {
        $service = resolve(GetServiceAction::class)->handle($request->id);
        throw_if(!$service, new ApiNotFoundException(msg: "Service not found"));
        $slots = $this->appointmentService->getAvailabitySlots($service);

        return (new ApiResponse(
            data: $slots,
            message: 'Appointment fetched successfully',
        ))->asSuccessful();
    }
}
