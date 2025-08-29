<?php

use App\Http\Middleware\Translate;
use App\Http\Middleware\CheckCode;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        using: function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->prefix('setting')
                ->group(base_path('routes/setting.php'));

            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->prefix('sales')
                ->group(base_path('routes/sale.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // alias middleware
        $middleware->alias([
            'trans' => Translate::class,
            'mycode' => CheckCode::class,
        ]);
        

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // custom exception handling if needed
    })
    ->create();
