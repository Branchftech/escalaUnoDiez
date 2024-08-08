<?php

namespace App\Http\Controllers\Bancos;

use App\Http\Controllers\Controller;

class BancosController extends Controller
{
    public function index()
    {
        return view('main-page.bancos.BancosMain');
    }
}
