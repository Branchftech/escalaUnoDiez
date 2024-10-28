<?php

// app/Livewire/Accesos/Accesos.php
namespace App\Livewire\Accesos;

use Livewire\Component;
use App\Models\Acceso;
use Illuminate\Support\Facades\Auth;

class Accesos extends Component
{
    public $accesos;

    public function mount()
    {
        // Obtiene los roles del usuario y filtra los accesos según los roles asignados o sin roles
        $userRoles = Auth::user()->roles->pluck('id');
        // Filtra los accesos según los roles del usuario o accesos sin roles asignados
        $this->accesos = Acceso::where(function ($query) use ($userRoles) {
            $query->whereHas('roles', function ($roleQuery) use ($userRoles) {
                $roleQuery->whereIn('roles.id', $userRoles);
            })
            ->orWhereDoesntHave('roles');
        })
        ->orWhere('nombre', 'dashboard') // Permitir siempre el acceso a "dashboard"
        ->get();
    }

    public function render()
    {
        return view('livewire.accesos.accesos');
    }
}
