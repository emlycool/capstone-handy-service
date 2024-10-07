<?php
namespace App\Helpers;

class FrontendUrlHelper
{
    public static function baseUrl(): string
    {
        return rtrim(config("frontend.base_url"), "/");
    }

    public static function resetPasswordUrl(): string
    {
        return static::baseUrl() . "/". ltrim(config("frontend.reset_password_path", "/"));
    }
}