<?php

namespace App\Livewire\Estados;

use App\Livewire\ServicesComponent;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;

class EliminarEstado extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarEstado'];

    public function mount(Estado $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.estados.eliminar-estado');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarEstado()
    {

        try {
            $user = Auth::user();
            Estado::eliminarEstado($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshEstadosTable')->to(EstadosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Estado eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Estado');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarEstado($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
