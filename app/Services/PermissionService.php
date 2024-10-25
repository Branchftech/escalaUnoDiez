<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PermissionService
{
    protected AlertService $alertService;

    public function __construct()
    {
        $this->alertService = app(AlertService::class);
    }

    public function checkPermissions(Component $component,array $permissions, $action = 'realizar esta acción')
    {
        foreach ($permissions as $permission) {
            if (Auth::user()->can($permission)) {
                return true;
            }
        }

        $this->alertService->error($component, 'No tienes permiso para ' . $action . '.');
        return false;

    }

    public function checkRoles(Component $component,array $roles, $action = 'realizar esta acción')
    {
        foreach ($roles as $role) {
            if (Auth::user()->hasRole($role)) {
                return true;
            }
        }
        $this->alertService->error($component, 'No tienes el rol necesario para ' . $action . '.');
        return false;
    }

    public function checkPermissionsAndRoles(Component $component, array $permissions, array $roles, $action = 'realizar esta acción')
    {
        if ($this->checkPermissions($component, $permissions, $action) || $this->checkRoles($component, $roles, $action)) {
            return true;
        }
        $this->alertService->error($component, 'No tienes los permisos o roles necesarios para ' . $action . '.');
        return false;
    }
}
