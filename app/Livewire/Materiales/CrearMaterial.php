<?php

namespace App\Livewire\Materiales;

use App\Livewire\ServicesComponent;
use App\Models\Material;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;

class CrearMaterial extends ServicesComponent
{
    public $nombre, $precioNormal;
    public $showModal = false;
    #select unidades
    public $unidades;
    public $unidadSelected;

    public function mount()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        return view('livewire.materiales.crear-material');
    }

    public function crearMaterial()
    {
        $user = Auth::user();

        $this->validate([
            'nombre' => 'required|string|unique:material,nombre,NULL,id,deleted_at,NULL',
            'precioNormal' => 'required',
            'unidadSelected' =>'exists:unidad,id',
        ]);
        Material::crearMaterial($this->nombre, $this->precioNormal, $this->unidadSelected, $user->id);
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
