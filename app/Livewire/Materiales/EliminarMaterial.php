<?php
namespace App\Livewire\Materiales;

use App\Livewire\ServicesComponent;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class EliminarMaterial extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarMaterial'];

    public function mount(Material $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.materiales.eliminar-material');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarMaterial()
    {

        try {
            $user = Auth::user();
            Material::eliminarMaterial($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshMaterialesTable')->to(MaterialesTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Material eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Material');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarMaterial($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
