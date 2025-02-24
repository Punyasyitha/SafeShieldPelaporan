<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Lewati segmen 'admin' dan mulai dari Master
            $view->with('title_group', ucfirst(Request::segment(2) ?? 'Dashboard')); // Master
            $view->with('title_menu', ucfirst(str_replace('-', ' ', Request::segment(3) ?? ''))); // Status Pengaduan
        });
    }
}