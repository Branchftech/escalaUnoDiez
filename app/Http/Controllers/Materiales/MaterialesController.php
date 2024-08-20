<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;

class MaterialesController extends Controller
{
    public function index()
    {
        return view('main-page.insumos.InsumosMain');
    }
}
