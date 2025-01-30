<?php

namespace App\Livewire\Paises;

use App\Models\Pais;
use Illuminate\Support\Facades\Auth;
use App\Livewire\ServicesComponent;

class CrearPais extends ServicesComponent
{
    public $nombre;
    public $showModal = false;

    public function render()
    {
        return view('livewire.paises.crear-pais');
    }

    public function crearPais()
    {
        $this->validate([
            'nombre' => 'required|string|unique:paises,nombre,NULL,id,deleted_at,NULL',
        ]);

        try {
            $user = Auth::user();

            Pais::create([
                'nombre' => $this->nombre,
                'created_by' => $user->id,
            ]);

            $this->dispatch('refreshPaisesTable')->to(PaisesTable::class);
            $this->limpiar();
            $this->closeModal();
            $this->alertService->success($this, 'País creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el País');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset(['nombre']);
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
