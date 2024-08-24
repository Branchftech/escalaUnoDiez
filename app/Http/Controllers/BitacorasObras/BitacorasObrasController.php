<?php

namespace App\Http\Controllers\BitacorasObras;

use App\Http\Controllers\Controller;

class BitacorasObrasController extends Controller
{
    public function index()
    {
        return view('main-page.detallesObras.DetallesObrasMain');
    }
}
