<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        // Detectar si la solicitud es de Livewire (solicitud AJAX)
        if ($request->header('X-Livewire')) {
            return $next($request); // Permitir solicitudes Livewire sin verificación
        }

        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Debes iniciar sesión.');
        }

        $routeName = $request->route()->getName();

        // Excluir rutas que no requieren validación de acceso específico
        if (in_array($routeName, ['dashboard', 'home', 'profile'])) {
            return $next($request);
        }

        // Obtener accesos del usuario basados en los roles
        $userAccesos = $user->accesos();

        // Verificar si el acceso solicitado está entre los accesos permitidos
        $hasAccess = $userAccesos->contains('url', $routeName);

        if (!$hasAccess) {
            return redirect('/dashboard')->with('error', 'No tienes acceso a esta página.');
        }

        return $next($request);
    }
}

