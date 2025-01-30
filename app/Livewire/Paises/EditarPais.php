<?php

namespace App\Livewire\Paises;

use App\Livewire\ServicesComponent;
use App\Models\Pais;
use Illuminate\Support\Facades\Auth;

class EditarPais extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre;
    public $listeners = ['cargarModalEditarPais'];

    public function mount(Pais $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;

    }

    public function render()
    {
        $this->nombre = $this->model->nombre;

        return view('livewire.paises.editar-pais');
    }

    public function editarPais()
    {
        $this->validate([
            'nombre' => 'required|string',
        ]);

        try {
            $user = Auth::user();

            // Llamar a la función del modelo con las validaciones
            Pais::editarPais($this->model->id, $this->nombre, $user->id);

            $this->dispatch('refreshPaisesTable')->to(PaisesTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Pais actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Pais');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarPais($model)
    {
        $this->model = Pais::find($model['id']);
        $this->nombre = $this->model['nombre'];

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
