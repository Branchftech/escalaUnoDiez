<?php

namespace App\Http\Controllers\Suscripciones;

use App\Http\Controllers\Controller;

class SuscripcionesController extends Controller
{
    public function render()
    {
        return view('app.suscripcion.suscripcion');
    }
}
