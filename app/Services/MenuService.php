<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    public static function getMenuItemsByRole()
    {
        $user = Auth::user()->load('roles');

        // Si el usuario es Administrador, retorna todos los menús
        if ($user->hasRole('Administrador')) {
            return Menu::all();
        }

        // Para otros usuarios, retorna menús sin rol asignado o que coinciden con los roles del usuario
        return Menu::whereNull('idRol')  // Incluye menús sin rol (visibles para todos)
            ->orWhereHas('rol', function ($query) use ($user) {
                $query->whereIn('id', $user->roles->pluck('id')); // Menús que coincidan con roles del usuario
            })
            ->get();
    }
}
