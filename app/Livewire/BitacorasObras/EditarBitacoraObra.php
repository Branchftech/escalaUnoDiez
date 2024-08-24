<?php

namespace App\Livewire\BitacorasObras;

use App\Livewire\ServicesComponent;
use App\Models\BitacoraObra;
use App\Models\Obra;
use Illuminate\Support\Facades\Auth;

class EditarBitacoraObra extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $descripcion;
    #select obras
    public $obras;
    public $obraSeleccionada;
    public $listeners = ['cargarModalEditarBitacora'];

    public function mount(BitacoraObra $model)
    {
        $this->model = $model;
        $this->descripcion = $model->descripcion;
        $this->obras = Obra::all();
    }

    public function render()
    {
        $this->obras = Obra::all();
        return view('livewire.bitacoras-obras.editar-bitacora-obra');
    }

    public function editarBitacoraObra()
    {

        $this->validate([
            'descripcion' => 'required|string',
            'obraSeleccionada' => 'required|exists:obra,id',
        ]);

        try {
            $user = Auth::user();

            $bitacoraObra = BitacoraObra::editarBitacoraObra($this->model->id, $this->descripcion, $this->obraSeleccionada, $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshBitacorasObrasTable')->to(BitacorasObrasTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Bitacora actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar la Bitacora');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarBitacora($model)
    {
        $this->model = (object) $model;
        $this->descripcion = $model['descripcion'];
        $this->obras = Obra::all();
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('descripcion');
        $this->reset('obraSeleccionada');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
