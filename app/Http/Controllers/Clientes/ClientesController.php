<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;

class ClientesController extends Controller
{
    public function index()
    {
        return view('main-page.clientes.ClientesMain');
    }
}
