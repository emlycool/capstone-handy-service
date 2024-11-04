<?php
namespace App\Helpers;

class FrontendUrlHelper
{
    public static function baseUrl(): string
    {
        return rtrim(config("frontend.base_url"), "/");
    }

    public static function resetPasswordUrl(string $email): string
    {
        return __(static::baseUrl() . "/". ltrim(config("frontend.reset_password_path", "/")), [
            'email' => urlencode($email)
        ]);
    }
}