<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application service.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application service.
     */
    public function boot(): void
    {
        Inertia::share([
            'auth' => [
                'user' => fn() => Auth::user() ? Auth::user()->only('id', 'name', 'email') : null,
            ],
        ]);
    }
}
