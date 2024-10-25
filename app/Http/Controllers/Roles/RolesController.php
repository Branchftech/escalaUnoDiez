<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function index()
    {
        return view('main-page.roles.RolesMain');
    }
}
