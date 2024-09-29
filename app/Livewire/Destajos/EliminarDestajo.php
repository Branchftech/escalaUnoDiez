<?php
namespace App\Livewire\Destajos;

use App\Livewire\ServicesComponent;
use App\Models\Destajo;
use Illuminate\Support\Facades\Auth;

class EliminarDestajo extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarDestajo'];

    public function mount(Destajo $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.destajos.eliminar-destajo');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarDestajo()
    {

        try {
            $user = Auth::user();
            Destajo::eliminarDestajo($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshDestajosTable')->to(DestajosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Destajo eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Destajo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarDestajo($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
