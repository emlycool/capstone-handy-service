<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    public function __construct(string $msg, int $code = 400)
    {
        parent::__construct($msg, $code);

        $this->message = $msg;
    }

    public function render(): JsonResponse
    {
        if($this->code == 401){
            return (new ApiResponse(
                message: $this->message
            ))->asUnauthorizedError();
        }
        

        return (new ApiResponse(
            message: $this->message
        ))->asBadRequest();

    }
}
