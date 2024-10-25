<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Manejar una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Verifica si el usuario tiene el rol especificado
        if (!$user || !$user->roles->contains('nombre', $role)) {
            return redirect('/dashboard')->with('error', 'No tienes acceso a esta página.');
        }

        return $next($request);
    }
}
