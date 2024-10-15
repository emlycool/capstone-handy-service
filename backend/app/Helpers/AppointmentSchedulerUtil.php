<?php
namespace App\Helpers;

use Carbon\Carbon;

class AppointmentSchedulerUtil
{
    public static function list_available_slots(
        array $appointments, 
        array $working_hours, 
        int $buffer_time, 
        int $appointment_duration
    ) {
        $start_time = $working_hours['start'];
        $end_time = $working_hours['end'];
        $all_slots = [];
        $current_time = $start_time;
    
        // Generate all possible slots
        while ($current_time + $appointment_duration <= $end_time) {
            $all_slots[] = ['start' => $current_time, 'end' => $current_time + $appointment_duration];
            $current_time += $appointment_duration + $buffer_time;
        }
    
        // Remove unavailable slots
        $available_slots = $all_slots;
        foreach ($appointments as $appointment) {
            foreach ($all_slots as $key => $slot) {
                if ($slot['start'] < $appointment['end'] && $slot['end'] > $appointment['start']) {
                    unset($available_slots[$key]);
                }
            }
        }
    
        return array_values($available_slots);
    }

    public static function list_available_slots_by_dates(
        array $appointments, 
        int $buffer_time, 
        int $appointment_duration, 
        array $working_schedule,
        ?Carbon $end_date = null
    ) 
    {
        $available_slots = [];
        $current_date = Carbon::today();
        $end_date = $end_date ?? $current_date->copy()->addWeeks(3);

        while ($current_date->lte($end_date)) {
            $day_of_week = strtolower($current_date->format('l'));
            foreach ($working_schedule as $schedule) {
                if ($schedule['day'] === $day_of_week) {
                    $start_time = Carbon::parse($current_date->format('Y-m-d') . ' ' . $schedule['start_time']);
                    $end_time = Carbon::parse($current_date->format('Y-m-d') . ' ' . $schedule['end_time']);
                    $current_time = $start_time->copy();

                    // Generate all possible slots for the day
                    while ($current_time->copy()->addMinutes($appointment_duration)->lte($end_time)) {
                        $slot = ['start' => $current_time->copy(), 'end' => $current_time->copy()->addMinutes($appointment_duration)];
                        $is_available = true;

                        // Check if the slot overlaps with any existing appointment
                        foreach ($appointments as $appointment) {
                            $appointment_start = Carbon::createFromTimestamp($appointment['start']);
                            $appointment_end = Carbon::createFromTimestamp($appointment['end']);
                            if ($slot['start']->lt($appointment_end) && $slot['end']->gt($appointment_start)) {
                                $is_available = false;
                                break;
                            }
                        }

                        if ($is_available) {
                            $available_slots[] = $slot;
                        }

                        $current_time->addMinutes($appointment_duration + $buffer_time);
                    }
                }
            }
            $current_date->addDay();
        }

        return $available_slots;    
    }
}