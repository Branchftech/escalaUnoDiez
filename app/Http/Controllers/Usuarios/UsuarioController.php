<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    public function profile()
    {
        return view('main-page.auth.ProfileMain');
    }
    public function index()
    {
        return view('main-page.usuarios.UsuariosMain');
    }
}
