<?php

namespace App\Enum\System;

enum EnvironmentEnum: string
{
    case LOCAL = 'local';
    case TESTING = 'testing';
    case QA = 'qa';
    case STAGING = 'staging';
    case PRODUCTION = 'production';
}
