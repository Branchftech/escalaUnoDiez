<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\Obra;
class DashboardController extends Controller
{
    public function render(\Illuminate\Http\Request $request)
    {
        $name = $request->get('name');
        $egresosMensual = Egreso::getCantMensual();
        $ingresosMensual = Ingreso::getCantMensual();
        $obrasVencida= Obra::countObrasConEstado3();
        $obrasPendiente = Obra::countObrasConEstado2();

        return view('app.Dashboard.Dashboard', compact('name', 'egresosMensual', 'ingresosMensual','obrasVencida','obrasPendiente'));
    }
}
