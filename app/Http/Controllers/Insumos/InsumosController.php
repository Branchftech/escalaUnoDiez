<?php

namespace App\Http\Controllers\Insumos;

use App\Http\Controllers\Controller;

class InsumosController extends Controller
{
    public function index()
    {
        return view('main-page.insumos.InsumosMain');
    }
}
