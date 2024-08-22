<?php

namespace App\Livewire\Unidades;

use App\Livewire\ServicesComponent;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;

class CrearUnidad extends ServicesComponent
{
    public $nombre;
    public $showModal = false;

    public function render()
    {
        return view('livewire.unidades.crear-unidad');
    }

    public function crearUnidad()
    {
        $user = Auth::user();

        $this->validate([
            'nombre' => 'required|string|unique:Unidad,nombre,NULL,id,deleted_at,NULL'
        ]);
        Unidad::crearUnidad($this->nombre, $user->id);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Unidad creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('nombre');
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
