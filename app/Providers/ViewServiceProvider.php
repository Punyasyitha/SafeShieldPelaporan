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
            $role = Request::segment(1); // Cek apakah "admin" atau "user"

            if ($role === 'admin') {
                // Logika untuk admin
                $group = ucfirst(Request::segment(2) ?? 'Dashboard');
                $menu = ucfirst(Request::segment(3) ?? '');
                $action = strtolower(Request::segment(4) ?? '/');

                $combined = $menu ? $group . ' / ' . $menu : $group;

                if (in_array($action, ['add', 'edit', 'show'])) {
                    $combined .= ' / ' . ucfirst($action);
                }

                $view->with('title', $combined);
            } elseif ($role === 'user') {
                // Logika untuk user
                $group = ucfirst(Request::segment(2) ?? 'Dashboard');
                $menu = ucfirst(Request::segment(3) ?? '');
                $action = strtolower(Request::segment(4) ?? '/');

                $combined = $menu ? $group . ' / ' . $menu : $group;

                if (in_array($action, ['add', 'edit', 'show'])) {
                    $combined .= ' / ' . ucfirst($action);
                }

                $view->with('title', $combined);
            }
        });
    }
}