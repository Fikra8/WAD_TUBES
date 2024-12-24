<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set the root view for Inertia to use
        // Inertia::setRootView('layouts.app'); // This tells Inertia to look for 'resources/views/app.blade.php'
        \Illuminate\Support\Facades\URL::defaults(['redirect' => '/home']);
    }
}

