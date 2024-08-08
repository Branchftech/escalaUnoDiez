<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;

class ServiciosController extends Controller
{
    public function render()
    {
        return view('app.servicios.servicios');
    }
}
