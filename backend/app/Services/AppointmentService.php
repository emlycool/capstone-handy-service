<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use App\Exceptions\ApiException;
use App\Enums\AppointmentStatusEnum;
use App\Models\ServiceProviderService;
use App\Helpers\AppointmentSchedulerUtil;
use App\Actions\Appointment\ListAppointmentAction;
use App\Actions\Provider\Service\GetServiceAction;
use App\Actions\Appointment\CreateOrUpdateAppointment;

class AppointmentService
{
    public readonly int $buffer_time;

    public function __construct(   
    )
    {
        $this->buffer_time = 60; // 60mins
    }

    public function bookAppointment(User $client, array $requestData): Appointment
    {
        $start_date = Carbon::parse($requestData['date'] . " ". $requestData['start_time']);
        $end_date = Carbon::parse($requestData['date'] . " ". $requestData['end_time']);
        $service = resolve(GetServiceAction::class)->handle($requestData['provider_service_id']);

        throw_if(
            !$this->isSlotAvailable(
                $service,
                $start_date,
                $end_date
            ),
            new ApiException(msg: "Slot not available")
        );

        return resolve(CreateOrUpdateAppointment::class)->handle(new Appointment([]), [
            'client_id' => $client->id,
            'service_provider_id' => $service->user->id,
            'provider_service_id' => $service->id,
            'service_id' => $service->category->id,
            'appointment_start_date' => $start_date,
            'appointment_end_date' => $end_date,
            'status' => AppointmentStatusEnum::BOOKED->value,  
            'notes' => $requestData['notes'] ?? null,
        ]);
    }

    public function cancelAppointment(User $client, Appointment $appointment): bool
    {
        throw_if(
            $appointment->status != AppointmentStatusEnum::BOOKED->value,
            new ApiException(msg: "Appointment can't be cancelled anymore")
        );

        throw_if(
            !$this->isClient($appointment, $client),
            new ApiException(msg: "You are not authorized to cancel this appointment")
        );

        $this->notifyBookingCancelation($appointment);

        return $appointment->update(['status' => AppointmentStatusEnum::CANCELLED->value]);
    }

    private function notifyBooking(Appointment $appointment): void
    {
        

    }

    private function notifyBookingConfirmation(Appointment $appointment): void
    {
        
    }

    private function notifyBookingCancelation(Appointment $appointment): void
    {

    }

    private function notifyBookingRejected(Appointment $appointment): void
    {

    }

    private function isClient(Appointment $appointment, User $user): bool
    {
        return $appointment->client_id == $user->id;
    }

    private function isServiceProvider(Appointment $appointment, User $user): bool
    {
        return $appointment->service_provider_id == $user->id;
    }

    public function rescheduleAppointment() 
    {
        # TODO: Implement rescheduleAppointment() method.
    }

    public function acceptAppointmentBooked(User $provider, Appointment $appointment): bool
    {
        throw_if(
            $appointment->status != AppointmentStatusEnum::BOOKED->value,
            new ApiException(msg: "Appointment can't be accepted anymore")
        );

        throw_if(
            !$this->isServiceProvider($appointment, $provider),
            new ApiException(msg: "You are not authorized to accept this appointment")
        );

        $this->notifyBookingConfirmation($appointment);

        return $appointment->update(['status' => AppointmentStatusEnum::CONFIRMED->value]);
    }

    public function rejectAppointmentBooked(User $provider, Appointment $appointment): bool
    {
        throw_if(
            $appointment->status != AppointmentStatusEnum::BOOKED->value,
            new ApiException(msg: "Appointment can't be rejected anymore")
        );

        throw_if(
            !$this->isServiceProvider($appointment, $provider),
            new ApiException(msg: "You are not authorized to reject this appointment")
        );

        $this->notifyBookingRejected($appointment);

        return $appointment->update(['status' => AppointmentStatusEnum::CONFIRMED->value]);
    }

    public function getAvailabitySlots(ServiceProviderService $service): array
    {
        $appointments = resolve(ListAppointmentAction::class)->query(
            provider: $service->user,
            requestData: [
                'status' => AppointmentStatusEnum::activeStatus()
            ]
        )->get(['appointment_start_date', 'appointment_end_date'])
        ->map(fn($appointment) => [
            'start_date' => $appointment->appointment_start_date,
            'end_date' => $appointment->appointment_end_date,
        ])->toArray();

        $appointment_duration = $service->duration_minutes;
        $working_schedule = $service->working_hours;
        $end_date = Carbon::now()->addDays(7);

        return AppointmentSchedulerUtil::list_available_slots_by_dates(
            $appointments, 
            $this->buffer_time, 
            $appointment_duration, 
            $working_schedule, 
            $end_date
        );
    }

    public function isSlotAvailable(ServiceProviderService $service, Carbon $start_date, Carbon $end_date): bool
    {
        $slots = $this->getAvailabitySlots($service);
        foreach ($slots as $slot) {
            if(
                $start_date->isSameAs('Y-m-d H:i', $slot['start']) &&
                $end_date->isSameAs('Y-m-d H:i', $slot['end'])
            ){
                return true;
            }
        }

        return false;
    }
}