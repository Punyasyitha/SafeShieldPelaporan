<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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


    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menus = [
                [
                    'title' => 'Dashboard',
                    'icon'  => 'fas fa-tachometer-alt',
                    'route' => 'admin.dashboard',
                ],
                [
                    'title'   => 'Master',
                    'icon'    => 'fas fa-database',
                    'submenu' => [
                        ['title' => 'Status Pengaduan', 'route' => 'master.status.list'],
                    ],
                ],
            ];

            $view->with('menus', $menus);
        });
    }
}