<?php

use App\Http\Controllers\FormasPago\FormasPagoController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Proveedores\ProveedoresController;
use App\Http\Controllers\Clientes\ClientesController;
use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Bancos\BancosController;
use App\Http\Controllers\BitacorasObras\BitacorasObrasController;
use App\Http\Controllers\Servicios\ServiciosController;
use App\Http\Controllers\Materiales\MaterialesController;
use App\Http\Controllers\Insumos\InsumosController;
use App\Http\Controllers\DetallesObras\DetallesObrasController;
use App\Http\Controllers\DocumentosObras\DocumentosObrasController;
use App\Http\Controllers\Egresos\EgresosController;
use App\Http\Controllers\Obras\ObrasController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    Route::get('/detalleObra/{id}', [DetallesObrasController::class, 'index'])->name('detalleObra');

    Route::get('/obras', [ObrasController::class, 'index'])->name('obras');

    Route::get('/bitacorasObras', [BitacorasObrasController::class, 'index'])->name('bitacorasObras');

    Route::get('/documentosObras', [DocumentosObrasController::class, 'index'])->name('documentosObras');

    Route::get('/egresos', [EgresosController::class, 'index'])->name('egresos');

    Route::get('/generar-pdf', function () {
        // Datos que puedes enviar a la vista (si es necesario)
        $data = [
            'nombre' => 'Mario Resendiz',
            'cantidad' => 5800,
            'obra' => 'Zirahuen',
            'concepto' => 'Plomería',
            'fecha' => '15 Enero 2024'
        ];

        // Renderiza la vista y pasa los datos
        $pdf = PDF::loadView('pdf.recibo.recibo', $data);

        // Devuelve el PDF en el navegador
        return $pdf->stream('archivo.pdf');
    });
    Route::get('/pdf/recibo/{id}', [EgresosController::class, 'pdfRecibo'])->name('pdfRecibo');

   // Route::get('/pdf/recibo', [EgresosController::class, 'pdfRecibo'])->name('pdf/recibo');
});

require __DIR__ . '/auth.php';
