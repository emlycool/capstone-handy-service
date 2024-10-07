<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class ApiValidationException extends Exception
{
    protected array $errors;

    public function __construct(array $errors, ?string $msg = null)
    {
        $this->message = $msg ?? "A validation error has occurred.";

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function render(): JsonResponse
    {
        return (new ApiResponse(
            data: [],
            message: $this->message,
            error: $this->errors
        ))->asValidationError();
    }
}
