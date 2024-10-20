<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/health',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'editor' => \App\Http\Middleware\EditorMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'publisher' => \App\Http\Middleware\PublisherMiddleware::class,
            'reviewer' => \App\Http\Middleware\ReviewerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
