<?php

namespace App\Livewire\Accesos;

use App\Livewire\ServicesComponent;
use App\Models\Acceso;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class EditarAcceso extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre, $url, $icono;
    public $roles;
    public $rolSeleccionado;
    public $selectedRoles = [];
    public $listeners = ['cargarModalEditar'];

    public function mount(Acceso $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;
        $this->url = $model->url;
        $this->icono = $model->icono;
        $this->roles = Roles::orderBy('nombre', 'asc')->get();
        $this->selectedRoles = $model->roles; // Cargar roles actuales del acceso
    }

    public function render()
    {
        return view('livewire.accesos.editar-acceso');
    }

    public function editarAcceso()
    {
        $this->validate([
            'nombre' => 'required|string',
            'url' => 'required|string',
            'icono' => 'nullable|string',
        ]);

        try {
            $user = Auth::user();
            $accesoExistente = Acceso::where('nombre', $this->nombre)->first();

            if ($accesoExistente && $accesoExistente->id != $this->model->id) {
                $this->addError('nombre', 'El nombre del acceso ya está en uso.');
                return;
            }

            $this->model->update([
                'nombre' => $this->nombre,
                'url' => $this->url,
                'icono' => $this->icono,
            ]);

            $this->model->roles()->sync($this->selectedRoles->pluck('id'));

            $this->showModal = false;
            $this->dispatch('refreshAccesosTable')->to(AccesosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Acceso actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el acceso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditar($model)
    {
        $this->model = Acceso::findOrFail($model['id']);
        $this->nombre = $this->model->nombre;
        $this->url = $this->model->url;
        $this->icono = $this->model->icono;
        $this->roles = Roles::orderBy('nombre', 'asc')->get();
        $this->selectedRoles = $this->model->roles; // Cargar roles actuales
        $this->showModal = true;
    }

    public function updatedRolSeleccionado($rol)
    {
        $this->validate(['rolSeleccionado' => 'required|exists:roles,id']);
        $rol = Roles::find($rol);

        if ($rol && !$this->selectedRoles->contains('id', $rol->id)) {
            $this->selectedRoles->push($rol);
        }
    }

    public function eliminarRol($index)
    {
        $this->selectedRoles = $this->selectedRoles->reject(function ($rol) use ($index) {
            return $rol->id == $index;
        })->values();
    }

    public function limpiar()
    {
        $this->reset('nombre', 'url', 'icono', 'selectedRoles');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
