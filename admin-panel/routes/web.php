<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminMediaItemController;
use App\Http\Controllers\ApiContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('admin.dashboard'));

Route::prefix('api')->group(function () {
    Route::get('/content', [ApiContentController::class, 'index'])->name('api.content');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.session')
    ->group(function () {
        Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('media', AdminMediaItemController::class)->parameters(['media' => 'medium'])->except('show');
    });
