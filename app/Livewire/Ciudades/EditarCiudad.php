<?php

namespace App\Livewire\Ciudades;

use App\Livewire\ServicesComponent;
use App\Models\Ciudad;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;

class EditarCiudad extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre;
    public $idEstado;
    public $estados;
    public $listeners = ['cargarModalEditarCiudad'];

    public function mount(Ciudad $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;

        $this->estados = Estado::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->nombre = $this->model->nombre;

        $this->estados = Estado::orderBy('nombre', 'asc')->get();
        return view('livewire.ciudades.editar-ciudad');
    }

    public function editarCiudad()
    {
        $this->validate([
            'nombre' => 'required|string',
            'idEstado' => 'required|exists:estados,id',
        ]);

        try {
            $user = Auth::user();

            // Llamar a la función del modelo con las validaciones
            Ciudad::editarCiudad($this->model->id, $this->nombre, $user->id, $this->idEstado);

            $this->dispatch('refreshCiudadesTable')->to(CiudadesTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Ciudad actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar la ciudad');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarCiudad($model)
    {
        $this->model = Ciudad::find($model['id']);
        $this->nombre = $this->model['nombre'];

        $this->idEstado = $this->model->idEstado;
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre', 'idEstado');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
