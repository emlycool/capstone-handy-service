<?php

namespace App\Enums;

use App\Enums\Traits\PhpEnum;

enum PriceModelEnum:string
{
    use PhpEnum;
    
    case HOURLY = "hourly"; 
    case FIXED = "fixed"; 
    case QOUTE = "qoute"; 
}
