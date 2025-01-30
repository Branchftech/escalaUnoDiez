<?php

namespace App\Livewire\Ciudades;

use App\Models\Ciudad;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;
use App\Livewire\ServicesComponent;

class CrearCiudad extends ServicesComponent
{
    public $nombre;
    public $idEstado;
    public $showModal = false;
    public $estados;

    public function mount()
    {
        $this->estados = Estado::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.ciudades.crear-ciudad');
    }

    public function crearCiudad()
    {
        $this->validate([
            'nombre' => 'required|string|unique:ciudades,nombre,NULL,id,deleted_at,NULL',
            'idEstado' => 'required|exists:estados,id',
        ]);

        try {
            $user = Auth::user();
            Ciudad::create([
                'nombre' => $this->nombre,
                'idEstado' => $this->idEstado,
                'created_by' => $user->id,
            ]);

            $this->limpiar();
            $this->closeModal();
            $this->dispatch('refreshCiudadesTable')->to(CiudadesTable::class);
            $this->alertService->success($this, 'Ciudad creada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear la ciudad');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset(['nombre', 'idEstado']);
        $this->estados = Estado::orderBy('nombre', 'asc')->get();
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
