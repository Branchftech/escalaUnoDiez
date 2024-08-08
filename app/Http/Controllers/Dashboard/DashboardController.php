<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function render(\Illuminate\Http\Request $request)
    {
        $name = $request->get('name');


        return view('app.dashboard.dashboard', compact('name'));
    }
}
