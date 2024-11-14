<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;

class ReportesController extends Controller
{
    public function index()
    {
        return view('main-page.reportes.ReportesMain');
    }
}
