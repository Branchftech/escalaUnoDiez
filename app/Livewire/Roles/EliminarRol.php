<?php

namespace App\Livewire\Roles;

use App\Models\Roles;
use App\Livewire\ServicesComponent;
use Illuminate\Support\Facades\Log;

class EliminarRol extends ServicesComponent
{
    #modelo
    public $model;

    #modal
    public $showModal = false;


    public $listeners = ['cargarModalEliminar'];

    public function mount(Roles $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.roles.eliminar-rol');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }


    public function eliminarRol()
    {

        if (!$this->permissionService->checkPermissions($this, ['eliminar-rol'], 'eliminar roles')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó eliminar un rol sin tener el permiso requerido');
            return;
        }
        try {
            Roles::eliminarRol($this->model->id);
            $this->reset( 'showModal');

            $this->dispatch('refreshRolesTable')->to(RolesTable::class);
            $this->render();

            $this->alertService->success($this, 'Rol eliminado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al eliminar el rol');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }


    public function cargarModalEliminar($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }
}
