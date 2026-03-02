<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ===================================================
        // GATE PARA AREAS RESTRITAS DE USUARIOS
        // ===================================================
        Gate::define('manage-users', fn ($user) => $user->isAdmin());
    }
}
