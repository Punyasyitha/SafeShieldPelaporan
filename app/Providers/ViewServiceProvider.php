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
            // Ambil title_group dan title_menu
            $title_group = ucfirst(Request::segment(2) ?? 'Dashboard'); // Master
            $title_menu = ucfirst(str_replace('-', ' ', Request::segment(3) ?? '')); // Status Pengaduan

            // ✅ Format $title: "Master / Status"
            $title = $title_group . ($title_menu ? ' / ' . $title_menu : '');

            // Kirim variabel ke view
            $view->with('title_group', $title_group);
            $view->with('title_menu', $title_menu);
            $view->with('title', $title);
        });
    }
}
