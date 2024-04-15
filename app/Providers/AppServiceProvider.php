<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
        // Compartir la cantidad de nuevas notificaciones en todas las vistas
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cantidadDeNuevasNotificaciones = Auth::user()->unreadNotifications->count();
                $view->with('cantidadDeNuevasNotificaciones', $cantidadDeNuevasNotificaciones);
            }
        });
    }
}
