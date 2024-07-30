<?php


use App\Exceptions\Handler;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Throwable $e, $request) {
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'error' => 'Unauthenticated',
                    'message' => 'You must be logged in to access this resource.',
                    'status_code' => 401
                ], 401);
            }

            if ($e instanceof HttpException && $request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'status_code' => $e->getStatusCode()
                ], $e->getStatusCode());
            }
        });
    })->create();
