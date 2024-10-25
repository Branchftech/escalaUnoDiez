<?php

namespace App\Livewire\Permisos;

use App\Models\Permisos;
use App\Livewire\ServicesComponent;

class CrearPermiso extends ServicesComponent
{

    public $name;
    public $showModal = false;

    public function render()
    {
        return view('livewire.permisos.crear-permiso');
    }

    public function crearPermiso()
    {
        if (!$this->permissionService->checkPermissions($this, ['crear-permiso'], 'crear permisos')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó crear un permiso sin tener el permiso requerido');
            return;
        }

        $this->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        try {
            $permiso = Permisos::crearPermiso($this->name);

            $this->reset('name', 'showModal');
            $this->dispatch('refreshPermisosTable')->to(PermisosTable::class);
            $this->render();


            $this->alertService->success($this, 'Permiso creado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el permiso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('name');
    }
}
