<?php
namespace App\Actions\Appointment;

class CreateOrUpdateAppointment
{
    public function handle($appointment, $data)
    {
        $appointment->fill($data);
        $appointment->save();
        return $appointment;
    }
}