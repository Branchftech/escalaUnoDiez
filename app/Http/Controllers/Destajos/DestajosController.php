<?php

namespace App\Http\Controllers\Destajos;

use App\Http\Controllers\Controller;

class DestajosController extends Controller
{
    public function index()
    {
        return view('main-page.destajos.DestajosMain');
    }
}
