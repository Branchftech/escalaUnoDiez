<?php

namespace App\Livewire\Estados;

use App\Livewire\ServicesComponent;
use App\Models\Estado;
use App\Models\Pais;
use Illuminate\Support\Facades\Auth;

class EditarEstado extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre;
    public $idPais;
    public $paises;
    public $listeners = ['cargarModalEditarEstado'];

    public function mount(Estado $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;

        $this->paises = Pais::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->nombre = $this->model->nombre;

        $this->paises = Pais::orderBy('nombre', 'asc')->get();
        return view('livewire.estados.editar-estado');
    }

    public function editarEstado()
    {
        $this->validate([
            'nombre' => 'required|string',
            'idPais' => 'required|exists:paises,id',
        ]);

        try {
            $user = Auth::user();

            // Llamar a la función del modelo con las validaciones
            Estado::editarEstado($this->model->id, $this->nombre, $user->id, $this->idPais);

            $this->dispatch('refreshEstadosTable')->to(EstadosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Estado actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Estado');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarEstado($model)
    {
        $this->model = Estado::find($model['id']);
        $this->nombre = $this->model['nombre'];

        $this->idPais = $this->model->idPais;
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre', 'idPais');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
