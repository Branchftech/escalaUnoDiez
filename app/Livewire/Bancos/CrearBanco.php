<?php

namespace App\Livewire\Bancos;

use App\Livewire\ServicesComponent;
use App\Models\Banco;
use Illuminate\Support\Facades\Auth;

class CrearBanco extends ServicesComponent
{
    public $nombre, $activo;
    public $showModal = false;

    public function render()
    {
        return view('livewire.bancos.crear-banco');
    }

    public function crearBanco()
    {
        $this->validate([
            'nombre' => 'required|string|unique:banco,nombre,NULL,id,deleted_at,NULL',
            'activo' => 'required|boolean',

        ]);
        try{
            $user = Auth::user();
            Banco::crearBanco($this->nombre, $this->activo, $user->id);
            $this->dispatch('refreshBancosTable')->to(BancosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Banco creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el Banco');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('nombre');
        $this->reset('activo');
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
