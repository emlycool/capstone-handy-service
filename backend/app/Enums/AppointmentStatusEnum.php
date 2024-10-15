<?php
namespace App\Enums;

use App\Enums\Traits\PhpEnum;

enum AppointmentStatusEnum:string
{
    use PhpEnum;
    
    case PENDING = 'pending';
    case BOOKED = 'booked';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
    case NO_SHOW = 'no_show';
    case CONFIRMED = 'confirmed';
    case RESCHEDULED = 'rescheduled';   
    case REJECTED = 'rejected';

    public static function activeStatus(): array
    {
        return [
            self::PENDING->value,
            self::BOOKED->value,
            self::CONFIRMED->value,
            self::RESCHEDULED->value,
            self::COMPLETED->value
        ];
    }
}
