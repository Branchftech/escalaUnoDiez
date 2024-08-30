<?php

namespace App\Http\Controllers\DocumentosObras;

use App\Http\Controllers\Controller;
use App\Models\DocumentoObra;
use Illuminate\Http\Request;

class DocumentosObrasController extends Controller
{
    public function index()
    {
        return view('main-page.documentosObras.documentosObrasMain');
    }


}
