<?php

namespace App\Http\Controllers\Egresos;

use App\Http\Controllers\Controller;

class EgresosController extends Controller
{
    public function index()
    {
        return view('main-page.egresos.EgresosMain');
    }
}
