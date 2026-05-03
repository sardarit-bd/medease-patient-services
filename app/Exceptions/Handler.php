<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return ApiResponse::error($exception->errors(), 422);
        }

        if ($exception instanceof NotFoundHttpException) {
            return ApiResponse::error('Route not found', 404);
        }

        if ($exception instanceof HttpException) {
            return ApiResponse::error(
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }

        return ApiResponse::error(
            config('app.debug') ? $exception->getMessage() : 'Server Error',
            500
        );
    }
}