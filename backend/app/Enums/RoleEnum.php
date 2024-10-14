<?php

namespace App\Enums;

use App\Enums\Traits\PhpEnum;

enum RoleEnum:string
{
    use PhpEnum;
    
    case SUPER_ADMIN = "super_admin";
    case ADMIN = "admin";
    case SERVICE_PROVIDER = "service_provider";
    case CLIENT = "client";
}
