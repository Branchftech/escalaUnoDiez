<?php

namespace App\Livewire\Estados;

use App\Models\Estado;
use App\Models\Pais;
use Illuminate\Support\Facades\Auth;
use App\Livewire\ServicesComponent;

class CrearEstado extends ServicesComponent
{
    public $nombre;
    public $idPais;
    public $showModal = false;
    public $paises;

    public function mount()
    {
        $this->paises = Pais::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.estados.crear-estado');
    }

    public function crearEstado()
    {
        $this->validate([
            'nombre' => 'required|string|unique:estados,nombre,NULL,id,deleted_at,NULL',
            'idPais' => 'required|exists:paises,id',
        ]);

        try {
            $user = Auth::user();

            Estado::create([
                'nombre' => $this->nombre,
                'idPais' => $this->idPais,
                'created_by' => $user->id,
            ]);

            $this->dispatch('refreshEstadosTable')->to(EstadosTable::class);
            $this->limpiar();
            $this->closeModal();
            $this->alertService->success($this, 'Estado creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el Estado');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset(['nombre', 'idPais']);
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
