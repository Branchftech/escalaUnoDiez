<?php

namespace App\Http\Controllers\DetallesObras;

use App\Http\Controllers\Controller;

class DetallesObrasController extends Controller
{
    public function index()
    {
        return view('main-page.detallesObras.DetallesObrasMain');
    }
}
