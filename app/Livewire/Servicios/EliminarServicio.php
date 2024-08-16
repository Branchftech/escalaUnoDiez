<?php
namespace App\Livewire\Servicios;

use App\Livewire\ServicesComponent;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class EliminarServicio extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarServicio'];

    public function mount(Servicio $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.servicios.eliminar-servicio');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarServicio()
    {

        try {
            $user = Auth::user();
            Servicio::eliminarServicio($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshServiciosTable')->to(ServiciosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Servicio eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Servicio');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarServicio($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
