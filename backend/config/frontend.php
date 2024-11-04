<?php

return [
    'base_url' => env("FE_BASE_URL", "http://127.0.0.1:3000"),
    'reset_password_path' => env("FE_RESET_PASSWORD_PATH", "/auth/:email/reset-password")
    
];