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
        Route::prefix('status')->name('status.')->group(function () {
        Route::get('/', [StatusController::class, 'index'])->name('list');
        Route::get('/add', [StatusController::class, 'add'])->name('add');
        Route::post('/store', [StatusController::class, 'store'])->name('store');
        Route::get('/show/{id}', [StatusController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [StatusController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [StatusController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [StatusController::class, 'delete'])->name('delete');
    });

        Route::get('/modul', function () {
            $data['url'] = url('master/modul'); // ⬅️ Gunakan URL, bukan nama view
            return app(ModulController::class)->index($data);
        })->name('modul.list');
        Route::get('/modul/add', [ModulController::class, 'add'])->name('modul.add');
        Route::post('/modul/store', [ModulController::class, 'store'])->name('modul.store');
    });
});

Route::middleware(['auth', 'satgasppks'])->group(function () {
    Route::get('/satgas/dashboard', [SatgasController::class, 'satgas'])->name('satgas.dashboard');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'user'])->name('user.dashboard');
});