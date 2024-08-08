<?php

use App\Http\Controllers\Comisiones\ComisionesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Servicios\ServiciosController;
use App\Http\Controllers\Suscripciones\SuscripcionesController;
use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Bancos\BancosController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::middleware(['auth'])->group(function () {

    // logout
    Route::get('/logout', function () {
        auth()->logout();
        Session::flush();
        return Redirect::to('/login');
    })->name('logout');

    Route::post('/logout', function () {
        auth()->logout();
        Session::flush();
        return Redirect::to('/login');
    })->name('logout');

    Route::get('/home', [DashboardController::class, 'render'])->name('home');

    Route::get('/', [DashboardController::class, 'render'])->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'render'])->name('dashboard');

    Route::get('/profile', [UsuarioController::class, 'profile'])->name('profile');

    Route::get('/comisiones', [ComisionesController::class, 'render'])->name('comisiones');

    Route::get('/comisiones', [ComisionesController::class, 'render'])->name('comisiones');

    Route::get('/suscripciones', [SuscripcionesController::class, 'render'])->name('suscripciones');

    Route::get('/servicios', [ServiciosController::class, 'render'])->name('servicios');

    Route::get('/bancos', [BancosController::class, 'index'])->name('bancos');

});

require __DIR__ . '/auth.php';
