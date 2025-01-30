<?php

namespace App\Livewire\Ciudades;

use App\Livewire\ServicesComponent;
use App\Models\Ciudad;
use Illuminate\Support\Facades\Auth;

class EliminarCiudad extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarCiudad'];

    public function mount(Ciudad $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.ciudades.eliminar-ciudad');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarCiudad()
    {

        try {
            $user = Auth::user();
            Ciudad::eliminarCiudad($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshCiudadesTable')->to(CiudadesTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Ciudad eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar la Ciudad');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarCiudad($model)
    {
        $this->model = (object) $model;
        $this->showModal = true; // Abre el modal
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
