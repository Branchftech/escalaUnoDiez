<?php
namespace App\Livewire\Insumos;

use App\Livewire\ServicesComponent;
use App\Models\Insumo;
use Illuminate\Support\Facades\Auth;

class EliminarInsumo extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarInsumo'];

    public function mount(Insumo $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.insumos.eliminar-insumo');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarInsumo()
    {

        try {
            $user = Auth::user();
            Insumo::eliminarInsumo($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshInsumosTable')->to(InsumosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Insumo eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Insumo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarInsumo($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
