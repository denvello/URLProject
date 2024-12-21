<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

//project user middleware
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Mendaftarkan service provider untuk middleware
$app->register(App\Providers\RouteMiddlewareServiceProvider::class);
//sd batas disini project user middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Menambahkan middleware di dalam app.php
        // $app->middleware([ValidateToken::class,]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

   
