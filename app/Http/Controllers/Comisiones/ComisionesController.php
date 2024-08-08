<?php

namespace App\Http\Controllers\Comisiones;

use App\Http\Controllers\Controller;

class ComisionesController extends Controller
{
    public function render()
    {
        return view('app.comisiones.comisiones');
    }
}
