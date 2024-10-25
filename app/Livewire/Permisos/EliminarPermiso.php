<?php

namespace App\Livewire\Permisos;

use App\Models\Permisos;
use App\Livewire\ServicesComponent;

class EliminarPermiso extends ServicesComponent
{
    public $model;
    public $showModal = false;

    public $listeners = ['cargarModalEliminar'];

    public function mount(Permisos $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.permisos.eliminar-permiso');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }


    public function eliminarPermiso()
    {
        if (!$this->permissionService->checkPermissions($this, ['eliminar-permiso'], 'eliminar permisos')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó eliminar un permiso sin tener el permiso requerido');
            return;
        }
        try {
            Permisos::eliminarPermiso($this->model->id);
            $this->reset( 'showModal');

            $this->dispatch('refreshPermisosTable')->to(PermisosTable::class);
            $this->render();

            $this->alertService->success($this, 'Permiso eliminado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el permiso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }


    public function cargarModalEliminar($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

}
