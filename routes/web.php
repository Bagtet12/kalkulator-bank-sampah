<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin-create', [AdminController::class, 'create'])->name('admin.create');
    Route::get('/admin-transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::post('/admin/verifikasi/{id}', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::get('/admin-edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin-update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/admin-store', [AdminController::class, 'store'])->name('admin.store');
    Route::delete('/admin-destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
require __DIR__ . '/adminauth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/user-hasil', [UserController::class, 'index'])->name('user.hasil');
    Route::post('/user-proses', [UserController::class, 'prosesPemilihanSampah'])->name('user.proses');
    Route::get('/user-dashboard/{id}', [UserController::class, 'dashboard'])->name('user.dashboard');
});


require __DIR__ . '/auth.php';
