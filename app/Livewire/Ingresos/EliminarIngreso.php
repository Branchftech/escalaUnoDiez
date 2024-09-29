<?php

namespace App\Livewire\Ingresos;

use App\Livewire\ServicesComponent;
use App\Models\Ingreso;
use Illuminate\Support\Facades\Auth;

class EliminarIngreso extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarIngreso'];

    public function mount(Ingreso $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.ingresos.eliminar-ingreso');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarIngreso()
    {
        try {
            $user = Auth::user();
            Ingreso::eliminarIngreso($this->model->id, $user->id);
            $this->reset('showModal');
            $this->dispatch('refreshIngresosTable')->to(IngresosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Ingreso eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Ingreso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarIngreso($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
