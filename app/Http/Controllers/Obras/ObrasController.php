<?php

namespace App\Http\Controllers\Obras;

use App\Http\Controllers\Controller;

class ObrasController extends Controller
{
    public function index()
    {
        return view('main-page.obras.ObrasMain');
    }
}
