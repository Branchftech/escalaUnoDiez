<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;

class ServiciosController extends Controller
{
    public function index()
    {
        return view('main-page.proveedores.ProveedoresMain');
    }
}
