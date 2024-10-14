<?php
namespace App\Helpers;

class AppUtil 
{
    public static function defer(\Closure $closure): void
    {
        // dispatch(fn() => $closure())
        // ->onConnection('sync')
        // ->afterResponse();
        defer(fn() => $closure());
    }
}