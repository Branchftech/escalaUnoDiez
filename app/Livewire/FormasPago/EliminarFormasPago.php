<?php
namespace App\Livewire\FormasPago;

use App\Livewire\ServicesComponent;
use App\Models\FormaPago;
use Illuminate\Support\Facades\Auth;

class EliminarFormasPago extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminar'];

    public function mount(FormaPago $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.formas-pago.eliminar-formas-pago');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarFormasPago()
    {

        try {
            $user = Auth::user();
            FormaPago::eliminarFormaPago($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshFormasPagoTable')->to(FormasPagoTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Forma de Pago eliminada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar la Forma de Pago');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminar($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
