<?php

namespace App\Livewire\Insumos;

use App\Livewire\ServicesComponent;
use App\Models\Insumo;
use Illuminate\Support\Facades\Auth;

class EditarInsumo extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $costo, $cantidad, $fecha;

    public $listeners = ['cargarModalEditar'];

    public function mount(Insumo $model)
    {
        $this->model = $model;
        $this->costo = $model->costo;
        $this->cantidad = $model->fecha;
    }

    public function render()
    {
        return view('livewire.insumos.editar-insumo');
    }

    public function editarInsumo()
    {

        $this->validate([
            'costo' => 'integer',
            'cantidad' => 'integer',
            'fecha' => 'date',
        ]);

        try {
            $user = Auth::user();

            $insumo = Insumo::editarInsumo($this->model->id, $this->costo, $this->cantidad, $this->fecha, $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshInsumosTable')->to(InsumosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Insumo actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Insumo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditar($model)
    {
        $this->model = (object) $model;
        $this->costo = $model['costo'];
        $this->cantidad = $model['cantidad'];
        $this->fecha = $model['fecha'];
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('costo');
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
