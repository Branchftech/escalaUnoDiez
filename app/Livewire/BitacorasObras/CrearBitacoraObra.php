<?php

namespace App\Livewire\BitacorasObras;

use App\Livewire\ServicesComponent;
use App\Models\BitacoraObra;
use Illuminate\Support\Facades\Auth;

class CrearBitacoraObra extends ServicesComponent
{
    public $descripcion;
    public $idObra;
    public $showModal = false;

    public function mount($id)
    {
        $this->idObra=$id;
    }

    public function render()
    {
        return view('livewire.bitacoras-obras.crear-bitacora-obra');
    }

    public function crearBitacoraObra()
    {
        $this->validate([
            'descripcion' => 'required|string|unique:bitacoraobra,descripcion,NULL,id,deleted_at,NULL',
            'idObra' => 'required|exists:obra,id',
        ]);
        try{
            $user = Auth::user();

            BitacoraObra::crearBitacoraObra($this->descripcion, $this->idObra,$user->id);
            $this->dispatch('refreshBitacorasObrasTable')->to(BitacorasObrasTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Bitacora creada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear la bitacora');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('descripcion');
        $this->reset('idObra');
        $this->closeModal();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
