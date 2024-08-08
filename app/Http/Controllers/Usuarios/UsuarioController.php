<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller2;
use Illuminate\Routing\Controllers\Middleware;

class UsuarioController extends Controller2 
{
    public function profile()
    {
        return view('main-page.auth.ProfileMain');
    }
}
