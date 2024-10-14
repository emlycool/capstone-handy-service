<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: [
            __DIR__.'/../routes/v1/auth.php',
            __DIR__.'/../routes/v1/user.php',
            __DIR__.'/../routes/v1/oboarding.php',
            __DIR__.'/../routes/v1/service.php',
            __DIR__.'/../routes/v1/appointment.php',
            __DIR__.'/../routes/v1/admin.php',
        ],
        apiPrefix: 'api'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
