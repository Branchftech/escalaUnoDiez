<?php

namespace App\Livewire\Materiales;

use App\Livewire\ServicesComponent;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class CrearMaterial extends ServicesComponent
{
    public $nombre, $precioNormal;
    public $showModal = false;

    public function render()
    {
        return view('livewire.materiales.crear-material');
    }

    public function crearMaterial()
    {
        $user = Auth::user();

        $this->validate([
            'nombre' => 'required|string|unique:material,nombre,NULL,id,deleted_at,NULL',
            'precioNormal' => 'required',

        ]);
        Material::crearMaterial($this->nombre, $this->precioNormal, $user->id);
        $this->dispatch('refreshMaterialesTable')->to(MaterialesTable::class);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Material creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('nombre');
        $this->reset('precioNormal');
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
