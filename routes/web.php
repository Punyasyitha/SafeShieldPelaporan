<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SatgasController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubMateriController;
use App\Http\Controllers\TerimaMateriController;
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

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // Grup Master dalam Admin
    Route::prefix('master')->name('admin.master.')->group(function () {
        Route::prefix('status')->name('status.')->group(function () {
            Route::get('/', [StatusController::class, 'index'])->name('list');
            Route::get('/add', [StatusController::class, 'add'])->name('add');
            Route::post('/store', [StatusController::class, 'store'])->name('store');
            Route::get('/show/{id}', [StatusController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [StatusController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [StatusController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [StatusController::class, 'delete'])->name('delete');
        });

        Route::prefix('modul')->name('modul.')->group(function () {
            Route::get('/', [ModulController::class, 'index'])->name('list');
            Route::get('/add', [ModulController::class, 'add'])->name('add');
            Route::post('/store', [ModulController::class, 'store'])->name('store');
            Route::get('/show/{id}', [ModulController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [ModulController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ModulController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ModulController::class, 'delete'])->name('delete');
        });

        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('list');
            Route::get('/add', [KategoriController::class, 'add'])->name('add');
            Route::post('/store', [KategoriController::class, 'store'])->name('store');
            Route::get('/show/{id}', [KategoriController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [KategoriController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [KategoriController::class, 'delete'])->name('delete');
        });

        Route::prefix('penulis')->name('penulis.')->group(function () {
            Route::get('/', [PenulisController::class, 'index'])->name('list');
            Route::get('/add', [PenulisController::class, 'add'])->name('add');
            Route::post('/store', [PenulisController::class, 'store'])->name('store');
            Route::get('/show/{id}', [PenulisController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [PenulisController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PenulisController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PenulisController::class, 'delete'])->name('delete');
        });
    });

    // Route untuk Artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('admin.artikel.list');
    Route::get('/artikel/add', [ArtikelController::class, 'add'])->name('admin.artikel.add');
    Route::post('/artikel/store', [ArtikelController::class, 'store'])->name('admin.artikel.store');
    Route::get('/artikel/show/{id}', [ArtikelController::class, 'show'])->name('admin.artikel.show');
    Route::get('/artikel/edit/{id}', [ArtikelController::class, 'edit'])->name('admin.artikel.edit');
    Route::put('/artikel/update/{id}', [ArtikelController::class, 'update'])->name('admin.artikel.update');
    Route::delete('/artikel/delete/{id}', [ArtikelController::class, 'delete'])->name('admin.artikel.delete');

    // Route untuk Materi
    Route::get('/materi', [MateriController::class, 'index'])->name('admin.materi.list');
    Route::get('/materi/add', [MateriController::class, 'add'])->name('admin.materi.add');
    Route::post('/materi/store', [MateriController::class, 'store'])->name('admin.materi.store');
    Route::get('/materi/show/{id}', [MateriController::class, 'show'])->name('admin.materi.show');
    Route::get('/materi/edit/{id}', [MateriController::class, 'edit'])->name('admin.materi.edit');
    Route::put('/materi/update/{id}', [MateriController::class, 'update'])->name('admin.materi.update');
    Route::delete('/materi/delete/{id}', [MateriController::class, 'delete'])->name('admin.materi.delete');

    // Route untuk Sub Materi
    Route::get('/submateri', [SubMateriController::class, 'index'])->name('admin.submateri.list');
    Route::get('/submateri/add', [SubMateriController::class, 'add'])->name('admin.submateri.add');
    Route::post('/submateri/store', [SubMateriController::class, 'store'])->name('admin.submateri.store');
    Route::get('/submateri/show/{id}', [SubMateriController::class, 'show'])->name('admin.submateri.show');
    Route::get('/submateri/edit/{id}', [SubMateriController::class, 'edit'])->name('admin.submateri.edit');
    Route::put('/submateri/update/{id}', [SubMateriController::class, 'update'])->name('admin.submateri.update');
    Route::delete('/submateri/delete/{id}', [SubMateriController::class, 'delete'])->name('admin.submateri.delete');

    // Route untuk Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('admin.pengaduan.list');
    Route::get('/pengaduan/show/{id}', [PengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::get('/pengaduan/edit/{id}', [PengaduanController::class, 'edit'])->name('admin.pengaduan.edit');
    Route::put('/pengaduan/update/{id}', [PengaduanController::class, 'update'])->name('admin.pengaduan.update');
    Route::delete('pengaduan/delete/{id}', [PengaduanController::class, 'delete'])->name('admin.pengaduan.delete');
});

Route::middleware(['auth', 'satgasppks'])->group(function () {
    Route::get('/satgas/dashboard', [SatgasController::class, 'satgas'])->name('satgas.dashboard');
});

Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/materi', [TerimaMateriController::class, 'index'])->name('user.materi.list');
    Route::get('/pengaduan', [FormPengaduanController::class, 'pengaduan'])->name('user.pengaduan');
    Route::post('/pengaduan/store', [FormPengaduanController::class, 'store'])->name('user.pengaduan.store');
    Route::get('/progress', [ProgressController::class, 'index'])->name('user.progress.list');
});
