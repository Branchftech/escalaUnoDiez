<?php
// app/Http/Controllers/Accesos/AccesosController.php
namespace App\Http\Controllers\Accesos;

use App\Http\Controllers\Controller;
use App\Models\Acceso;
use Illuminate\Support\Facades\Auth;

class AccesosController extends Controller
{
    /**
     * Obtiene los accesos permitidos para el usuario autenticado.
     */
    public function getSidebarAccesos()
    {
        $userRoles = Auth::user()->roles->pluck('id'); // Obtén los IDs de roles del usuario

        // Filtrar accesos según los roles o accesos sin roles asignados
        $accesos = Acceso::where(function ($query) use ($userRoles) {
            $query->whereHas('roles', function ($roleQuery) use ($userRoles) {
                $roleQuery->whereIn('roles.id', $userRoles);
            })
            ->orWhereDoesntHave('roles');
        })
        ->orWhere('nombre', 'dashboard') // Permitir siempre el acceso a "dashboard"
        ->get();

        return view('components.app-layout.sidebar', compact('accesos')); // Retorna la vista del sidebar con los accesos
    }


    public function index()
    {
        return view('main-page.accesos.AccesosMain');
    }
}

