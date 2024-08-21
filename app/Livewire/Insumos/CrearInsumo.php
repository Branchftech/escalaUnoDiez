<?php

namespace App\Livewire\Insumos;

use App\Livewire\ServicesComponent;
use App\Models\Insumo;
use App\Models\Material;
use App\Models\Unidad;
use App\Models\Obra;
use Illuminate\Support\Facades\Auth;

class CrearInsumo extends ServicesComponent
{
    public $costo, $cantidad, $fecha;
    public $showModal = false;
    #select obras
    public $obras;
    public $obraSeleccionado;
    #select materiales
    public $materiales;
    public $materialesSeleccionados;
    public $selectedMateriales = [];

    public function mount()
    {
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
        return view('livewire.insumos.crear-insumo');
    }

    public function crearInsumo()
    {
        $user = Auth::user();

        $this->validate([
            'costo' => 'integer',
            'cantidad' => 'integer',
            'fecha' => 'date',
            //'obraSeleccionado' => 'required|exists:obras,id', // Validar que el ID de obra exista en la tabla 'obras'
            'materialesSeleccionados.*' => 'exists:material,id', // Validación de que cada ID existe en la tabla materiales

        ]);

        Insumo::crearInsumo($this->costo, $this->cantidad, $this->fecha,$this->obraSeleccionado, $this->materialesSeleccionados, $user->id);
        $this->dispatch('refreshInsumosTable')->to(InsumosTable::class);
        $this->render();
        $this->limpiar();
        $this->alertService->success($this, 'Insumo creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('costo');
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->reset('obraSeleccionado');
        $this->reset('materialesSeleccionados');
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

    public function updatedMaterialSeleccionado($material)
    {
        $this->validate([
            'materialesSeleccionados.*' => 'exists:material,id', // Validación de que cada ID existe en la tabla materiales
        ]);

        $material = Material::find($material);

        if ($material && !in_array($material, $this->selectedMateriales)) {
            $this->selectedMateriales[] = $material;
        }
    }

    public function eliminarMateriales($index)
    {
        $this->selectedMateriales = array_filter($this->selectedMateriales, function($material) use ($index) {
            return $material->id !== $index;
        });
    }
}
