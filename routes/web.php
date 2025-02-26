<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatgasController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // Grup untuk semua Master
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/status', function () {
            $data['url'] = url('master/status'); // ⬅️ Gunakan URL, bukan nama view
            return app(StatusController::class)->index($data);
        })->name('status.list');
        Route::get('/status/add', [StatusController::class, 'add'])->name('status.add');
        Route::post('/status/store', [StatusController::class, 'store'])->name('status.store');
        Route::get('/status/show/{id}', [StatusController::class, 'show'])->name('status.show');
        Route::get('/status/edit/{id}', [StatusController::class, 'edit'])->name('status.edit');
        Route::put('/status/update/{id}', [StatusController::class, 'update'])->name('status.update');
        Route::delete('/status/delete/{id}', [StatusController::class, 'delete'])->name('status.delete');

        Route::get('/modul', function () {
            $data['url'] = url('master/modul'); // ⬅️ Gunakan URL, bukan nama view
            return app(ModulController::class)->index($data);
        })->name('modul.list');
    });
});

Route::middleware(['auth', 'satgasppks'])->group(function () {
    Route::get('/satgas/dashboard', [SatgasController::class, 'satgas'])->name('satgas.dashboard');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'user'])->name('user.dashboard');
});