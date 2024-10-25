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
        $this->accesos = Acceso::whereHas('roles', function ($query) use ($userRoles) {
                $query->whereIn('roles.id', $userRoles);
            })
            ->orWhereDoesntHave('roles') // Incluye accesos sin roles asignados
            ->get();
    }

    public function render()
    {
        return view('livewire.accesos.accesos');
    }
}
