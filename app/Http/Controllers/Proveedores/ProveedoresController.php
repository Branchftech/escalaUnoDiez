<?php

namespace App\Http\Controllers\Proveedores;

use App\Http\Controllers\Controller;

class ProveedoresController extends Controller
{
    public function index()
    {
        return view('main-page.proveedores.ProveedoresMain');
    }
}
