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
                    'icon'  => 'fas fa-laptop',
                    'route' => 'admin.dashboard',
                ],
                [
                    'title'   => 'Master',
                    'icon'    => 'fas fa-folder-open',
                    'submenu' => [
                        [
                            'title' => 'Status',
                            'icon'  => 'fas fa-check-circle', // Ikon untuk submenu Status
                            'route' => 'master.status.list'
                        ],
                        [
                            'title' => 'Modul',
                            'icon'  => 'fas fa-server', // Ikon untuk submenu Status
                            'route' => 'master.modul.list'
                        ],
                    ],
                ],
            ];

            $view->with('menus', $menus);
        });
    }
}