<?php

namespace App\Livewire\Bancos;

use App\Livewire\ServicesComponent;
use App\Models\Banco;
use Illuminate\Support\Facades\Auth;

class EditarBanco extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre, $activo;

    public $listeners = ['cargarModalEditar'];

    public function mount(Banco $model)
    {
        $this->model = $model;
        $this->nombre = $model->nombre;
        $this->activo = $model->activo;
    }

    public function render()
    {
        return view('livewire.Bancos.editar-Banco');
    }

    public function editarBanco()
    {

        $this->validate([
            'nombre' => 'required|string',
            'activo' => 'required|boolean',
        ]);

        try {
            $user = Auth::user();
            $Banco = Banco::where('nombre', $this->nombre)->first();

            if ($Banco && $Banco->id != $this->model->id) {
                $this->addError('nombre', 'El nombre del Banco ya está en uso.');
                return;
            }
            $Banco = Banco::editarBanco($this->model->id, $this->nombre, $this->activo, $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshBancosTable')->to(BancosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Banco actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Banco');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditar($model)
    {
        $this->model = (object) $model;
        $this->nombre = $model['nombre'];
        $this->activo = $model['activo'];
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre');
        $this->reset('activo');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
