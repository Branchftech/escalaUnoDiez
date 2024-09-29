<?php

namespace App\Http\Controllers\Ingresos;

use App\Http\Controllers\Controller;

class IngresosController extends Controller
{
    public function index()
    {
        return view('main-page.ingresos.IngresosMain');
    }
}
