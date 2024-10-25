<?php

namespace App\Livewire\Permisos;

use App\Models\Permisos;
use App\Livewire\ServicesComponent;

class EditarPermiso extends ServicesComponent
{
    public $showModal = false;

    public $model;
    public $name;

    public $listeners = ['cargarModalEditar'];

    public function mount(Permisos $model)
    {
        $this->model = $model;
        $this->name = $model->name;
    }

    public function render()
    {
        return view('livewire.permisos.editar-permiso');
    }

    public function editarPermiso()
    {
        if (!$this->permissionService->checkPermissions($this, ['editar-permiso'], 'editar permisos')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó editar un permiso sin tener el permiso requerido');
            return;
        }

        $this->validate([
            'name' => 'required|string',
        ]);

        try {

            $permiso = Permisos::where('name', $this->name)->first();

            if ($permiso && $permiso->id != $this->model->id) {
                $this->addError('name', 'El nombre del permiso ya está en uso.');
                return;
            }
            $permiso = Permisos::editarPermiso($this->model->id, $this->name);

            $this->reset('showModal');
            $this->dispatch('refreshPermisosTable')->to(PermisosTable::class);
            $this->render();

            $this->alertService->success($this, 'Permiso actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el permiso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }


    public function cargarModalEditar($model)
    {
        $this->model = (object) $model;
        $this->name = $model['name'];
        $this->showModal = true;
    }
}
