<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class ApiNotFoundException extends Exception
{
    public function __construct(string $msg)
    {
        parent::__construct();

        $this->message = $msg;
    }

    public function render(): JsonResponse
    {
        return (new ApiResponse(
            message: $this->message
        ))->asNotFound();
    }
}
