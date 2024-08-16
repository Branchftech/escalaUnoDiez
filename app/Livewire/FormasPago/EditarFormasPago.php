<?php

namespace App\Livewire\FormasPago;

use App\Livewire\ServicesComponent;
use App\Models\FormaPago;
use Illuminate\Support\Facades\Auth;

class EditarFormasPago extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre;

    public $listeners = ['cargarModalEditar'];

    public function mount(FormaPago $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;

    }

    public function render()
    {
        return view('livewire.formas-pago.editar-formas-pago');
    }

    public function editarFormasPago()
    {

        $this->validate([
            'nombre' => 'required|string',
        ]);

        try {
            $user = Auth::user();

            FormaPago::editarFormaPago($this->model->id, $this->nombre,  $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshFormasPagoTable')->to(FormasPagoTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Forma de Pago actualizada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar la Forma de Pago');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditar($model)
    {
        $this->model = FormaPago::find($model['id']);
        $this->nombre = $this->model['nombre'];
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
