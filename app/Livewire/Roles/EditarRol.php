<?php

namespace App\Livewire\Roles;

use App\Models\Permisos;
use App\Models\Roles;
use App\Livewire\ServicesComponent;
use Illuminate\Support\Facades\Log;

class EditarRol  extends ServicesComponent
{

    public $showModal = false;

    #Select permisos
    public $permisos;
    public $permisoSeleccionado;
    public $selectedPermisos = [];

    #modelo
    public $model;
    #input
    public $name;

    public $listeners = ['cargarModalEditar'];

    public function mount(Roles $model)
    {
        $this->model = $model;
        $this->name = $model->name;
        $this->permisos = Permisos::orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.roles.editar-rol');
    }

    public function editarRol()
    {

        if (!$this->permissionService->checkPermissions($this, ['editar-rol'], 'editar roles')) {
            $this->loggerService->logInfo('El usuario ' . auth()->user()->name . '-' . auth()->user()->id . ' intentó editar un rol sin tener el permiso requerido');
            return;
        }
        $this->validate([
            'name' => 'required|string',
        ]);

        try {

            $rol = Roles::where('name', $this->name)->first();

            if ($rol && $rol->id != $this->model->id) {
                $this->addError('name', 'El nombre del rol ya está en uso.');
                return;
            }
            $rol = Roles::editarRol($this->model->id, $this->name , $this->selectedPermisos);

            $this->showModal = false;
            $this->reset('name', 'selectedPermisos');
            $this->dispatch('refreshRolesTable')->to(RolesTable::class);
            $this->render();

            $this->alertService->success($this, 'Rol actualizado con éxito');


        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo actualizar el rol');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }



    public function cargarModalEditar($model)
    {
        $this->model = Roles::findOrfail($model['id']);
        $this->selectedPermisos = $this->model->permisos->all();
        $this->name = $this->model->name;
        $this->showModal = true;
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

    public function eliminarPermiso($index)
    {
        $this->selectedPermisos = array_filter($this->selectedPermisos, function($permiso) use ($index) {
            return $permiso->id !== $index;
        });
    }
}
