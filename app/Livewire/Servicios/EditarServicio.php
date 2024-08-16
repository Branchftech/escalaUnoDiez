<?php

namespace App\Livewire\Servicios;

use App\Livewire\ServicesComponent;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class EditarServicio extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre, $activo;

    public $listeners = ['cargarModalEditarServicio'];

    public function mount(Servicio $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;
        $this->activo = $model->activo;
    }

    public function render()
    {
        return view('livewire.servicios.editar-servicio');
    }

    public function editarServicio()
    {

        $this->validate([
            'nombre' => 'required|string',
        ]);

        try {
            $user = Auth::user();
            $Servicio = Servicio::where('nombre', $this->nombre)->first();

            if ($Servicio && $Servicio->id != $this->model->id) {
                $this->addError('nombre', 'El nombre del Servicio ya está en uso.');
                return;
            }
            $Servicio = Servicio::editarServicio($this->model->id, $this->nombre, $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshServiciosTable')->to(ServiciosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Servicio actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Servicio');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarServicio($model)
    {
        $this->model = (object) $model;
        $this->nombre = $model['nombre'];
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
