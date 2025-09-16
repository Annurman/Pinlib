<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Middleware global
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\RoleMiddleware::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\Routing\Middleware\ValidateSignature::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // Tambahkan ini
    ];

    protected $routeMiddleware = [
        'auth.admin' => \App\Http\Middleware\AdminAuth::class,
        'auth.user' => \App\Http\Middleware\UserAuth::class,

    ];
    
    
    
}
