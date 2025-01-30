<?php

namespace App\Http\Controllers\Regiones;

use App\Http\Controllers\Controller;

class RegionesController extends Controller
{
    public function index()
    {
        return view('main-page.regiones.RegionesMain');
    }
}
