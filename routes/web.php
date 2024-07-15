<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\ConstructionController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Frontend\ConstructionController as FrontendConstruction;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'postLogin'])->name('postLogin');

Route::get('/get-constructions', [FrontendConstruction::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/forgot-password', [LoginController::class, 'postForgotPassword'])->name('postForgotPassword');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/banners')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('banner.index');
        Route::post('/', [BannerController::class, 'store'])->name('banner.store');
    });

    Route::prefix('/constructions')->group(function () {
        Route::get('/', [ConstructionController::class, 'index'])->name('construction.index');
        Route::get('/create', [ConstructionController::class, 'create'])->name('construction.create');
        Route::get('/{id}', [ConstructionController::class, 'edit'])->name('construction.edit');
        Route::post('/{id?}', [ConstructionController::class, 'save'])->name('construction.save');
        Route::delete('/{id}', [ConstructionController::class, 'destroy'])->name('construction.destroy');
    });

    Route::prefix('/settings')->group(function () {
       Route::get('/', [SettingController::class, 'index'])->name('settings.index');
       Route::post('/', [SettingController::class, 'save'])->name('settings.save');
    });
});
