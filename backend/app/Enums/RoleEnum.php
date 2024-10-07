<?php

namespace App\Enums;

enum RoleEnum:string
{
    case ADMIN = "admin";
    case SERVICE_PROVIDER = "service_provider";
    case CLIENT = "client";
}
