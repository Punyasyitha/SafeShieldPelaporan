<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            $user = Auth::user(); // Ambil user yang sedang login
            $menus = [];

            if ($user && $user->role === 'admin') {
                // Menu untuk ADMIN
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
                                'icon'  => 'fas fa-check-circle',
                                'route' => 'admin.master.status.list'
                            ],
                            [
                                'title' => 'Modul',
                                'icon'  => 'fas fa-server',
                                'route' => 'admin.master.modul.list'
                            ],
                            [
                                'title' => 'Kategori',
                                'icon'  => 'fas fa-layer-group',
                                'route' => 'admin.master.kategori.list'
                            ],
                            [
                                'title' => 'Penulis',
                                'icon'  => 'fas fa-pen-to-square',
                                'route' => 'admin.master.penulis.list'
                            ],
                        ],
                    ],
                    [
                        'title' => 'Artikel',
                        'icon'  => 'fas fa-newspaper',
                        'route' => 'admin.artikel.list',
                    ],
                    [
                        'title' => 'Materi',
                        'icon'  => 'fas fa-chalkboard',
                        'route' => 'admin.materi.list',
                    ],
                    [
                        'title' => 'Sub Materi',
                        'icon'  => 'fas fa-window-restore',
                        'route' => 'admin.submateri.list',
                    ],
                    [
                        'title' => 'Pengaduan',
                        'icon'  => 'fas fa-clipboard',
                        'route' => 'admin.pengaduan.list',
                    ],
                    [
                        'title'   => 'Report',
                        'icon'    => 'fas fa-clipboard-list',
                        'submenu' => [
                            [
                                'title' => 'Rekap Pengaduan',
                                'icon'  => 'fas fa-check-circle',
                                'route' => 'admin.report.pengaduan.filter'
                            ],
                        ],
                    ],
                    [
                        'title' => 'API',
                        'icon'  => 'fas fa-clipboard',
                        'route' => 'admin.pages.result',
                    ],
                ];
            } elseif ($user && $user->role === 'user') {
                // Menu untuk USER
                $menus = [
                    [
                        'title' => 'Dashboard',
                        'icon'  => 'fas fa-home',
                        'route' => 'user.dashboard',
                    ],
                    [
                        'title' => 'Materi',
                        'icon'  => 'fas fa-chalkboard',
                        'route' => 'user.materi.list',
                    ],
                    [
                        'title' => 'Pengaduan',
                        'icon'  => 'fas fa-exclamation-triangle',
                        'route' => 'user.pengaduan.add',
                    ],
                    [
                        'title' => 'Progress Pengaduan',
                        'icon'  => 'fas fa-history',
                        'route' => 'user.pengaduan.list',
                    ],
                ];
            }

            $view->with('menus', $menus);
        });
    }
}