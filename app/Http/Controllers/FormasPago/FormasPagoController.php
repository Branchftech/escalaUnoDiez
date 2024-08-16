<?php

namespace App\Http\Controllers\FormasPago;

use App\Http\Controllers\Controller;

class FormasPagoController extends Controller
{
    public function index()
    {
        return view('main-page.formasPago.FormasPagoMain');
    }
}
