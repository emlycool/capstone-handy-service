<?php
namespace App\Actions\Appointment;

use App\Models\Appointment;

class GetAppointmentAction
{
    public function handle(int $id): ?Appointment
    {
        return Appointment::find($id);
    }
}