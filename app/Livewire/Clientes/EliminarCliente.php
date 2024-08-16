<?php
namespace App\Livewire\Clientes;

use App\Livewire\ServicesComponent;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class EliminarCliente extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminar'];

    public function mount(Cliente $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.clientes.eliminar-cliente');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarCliente()
    {

        try {
            $user = Auth::user();
            Cliente::eliminarCliente($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshClientesTable')->to(ClientesTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Cliente eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Cliente');
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
