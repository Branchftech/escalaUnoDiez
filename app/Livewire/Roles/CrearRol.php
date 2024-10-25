<?php

namespace App\Livewire\Roles;

use App\Models\Permisos;
use App\Models\Roles;
use App\Livewire\ServicesComponent;
use Illuminate\Support\Facades\Log;

class CrearRol extends ServicesComponent
{

    #Inputs
    public $name;

    #Select permisos
    public $permisos;
    public $permisoSeleccionado;
    public $selectedPermisos = [];

    #modal
    public $showModal = false;

    public function mount()
    {
        $this->name = '';
        $this->permisos = Permisos::orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.roles.crear-rol');
    }

    public function crearRol()
    {
        if (!$this->permissionService->checkPermissions($this, ['crear-rol'], 'crear roles')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó crear un rol sin tener el permiso requerido');
            return;
        }

        $this->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        try {
            $rol = Roles::crearRol($this->name, $this->selectedPermisos);

            $this->showModal = false;
            $this->reset('name','selectedPermisos');
            $this->dispatch('refreshRolesTable')->to(RolesTable::class);
            $this->render();


            $this->alertService->success($this, 'Rol creado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo crear el rol');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function updatedPermisoSeleccionado($permiso)
    {
        $this->validate([
            'permisoSeleccionado' => 'required|exists:permissions,id',
        ]);

        $permiso = Permisos::find($permiso);

        if ($permiso && !in_array($permiso, $this->selectedPermisos)) {
            $this->selectedPermisos[] = $permiso;
        }
    }

    public function limpiar()
    {
        $this->reset('name', 'selectedPermisos');
    }

    public function eliminarPermiso($index)
    {
        $this->selectedPermisos = array_filter($this->selectedPermisos, function($permiso) use ($index) {
            return $permiso->id !== $index;
        });
    }



}
