<?php

namespace App\Livewire\Paises;

use App\Livewire\ServicesComponent;
use App\Models\Pais;
use Illuminate\Support\Facades\Auth;

class EliminarPais extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarPais'];

    public function mount(Pais $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.paises.eliminar-pais');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarPais()
    {

        try {
            $user = Auth::user();
            Pais::eliminarPais($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshPaisesTable')->to(PaisesTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Pais eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Pais');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarPais($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
