<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Baris ini tetap ada sesuai file aslimu
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // --- TAMBAHAN PENTING ---
        // Memaksa Laravel percaya pada request dari Ngrok agar upload tidak error
        $middleware->trustProxies(at: '*'); 
    })
    ->withProviders([
        // Providers aslimu tetap aman di sini
        \App\Providers\RepositoryServiceProvider::class,
        \App\Providers\Filament\AdminPanelProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();