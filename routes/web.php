<?php

use App\Http\Controllers\FormasPago\FormasPagoController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Proveedores\ProveedoresController;
use App\Http\Controllers\Clientes\ClientesController;
use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Bancos\BancosController;
use App\Http\Controllers\Servicios\ServiciosController;
use App\Http\Controllers\Materiales\MaterialesController;
use App\Http\Controllers\Insumos\InsumosController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth'])->group(function () {


    Route::post('/logout', function () {
        Auth::logout();
        Session::flush();
        return Redirect::to('/login');
    })->name('logout');

    Route::get('/home', [DashboardController::class, 'render'])->name('home');

    Route::get('/', [DashboardController::class, 'render']);

    Route::get('/dashboard', [DashboardController::class, 'render'])->name('dashboard');

    Route::get('/profile', [UsuarioController::class, 'profile'])->name('profile');

    Route::get('/formasPago', [FormasPagoController::class, 'index'])->name('formasPago');

    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes');

    Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores');

    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios');

    Route::get('/bancos', [BancosController::class, 'index'])->name('bancos');

    Route::get('/materiales', [MaterialesController::class, 'index'])->name('materiales');

    Route::get('/insumos', [InsumosController::class, 'index'])->name('insumos');
});

require __DIR__ . '/auth.php';
