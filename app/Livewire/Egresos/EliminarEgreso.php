<?php
namespace App\Livewire\Egresos;

use App\Livewire\ServicesComponent;
use App\Models\Egreso;
use Illuminate\Support\Facades\Auth;

class EliminarEgreso extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarEgreso'];

    public function mount(Egreso $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.egresos.eliminar-egreso');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarEgreso()
    {

        try {
            $user = Auth::user();
            $egreso= Egreso::eliminarEgreso($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshEgresosTable')->to(EgresosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Egreso eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Egreso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarEgreso($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
