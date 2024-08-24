<?php
namespace App\Livewire\BitacorasObras;

use App\Livewire\ServicesComponent;
use App\Models\BitacoraObra;
use Illuminate\Support\Facades\Auth;

class EliminarBitacoraObra extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarBitacora'];

    public function mount(BitacoraObra $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.bitacoras-obras.eliminar-bitacora-obra');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarBitacoraObra()
    {

        try {
            $user = Auth::user();
            BitacoraObra::eliminarBitacoraObra($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshBitacorasObrasTable')->to(BitacorasObrasTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Bitacora eliminada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Bitacora');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarBitacora($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
