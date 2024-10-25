<?php

namespace App\Http\Controllers\Permisos;

use App\Http\Controllers\Controller;

class PermisosController extends Controller
{
    public function index()
    {
        return view('main-page.permisos.PermisosMain');
    }
}
