<?php
namespace App\Livewire\Proveedores;

use App\Livewire\ServicesComponent;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;

class EliminarProveedor extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarProveedor'];

    public function mount(Proveedor $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.proveedores.eliminar-proveedor');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarProveedor()
    {

        try {
            $user = Auth::user();
            Proveedor::eliminarProveedor($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshProveedoresTable')->to(ProveedoresTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Proveedor eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Proveedor');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarProveedor($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
