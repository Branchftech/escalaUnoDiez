<?php

namespace App\Livewire\Insumos;

use App\Livewire\ServicesComponent;
use App\Models\Insumo;
use App\Models\Material;
use App\Models\Obra;
use Illuminate\Support\Facades\Auth;

class CrearInsumo extends ServicesComponent
{
    public $costo, $cantidad, $fecha;
    public $showModal = false;
    #select obras
    public $obras;
    public $obraSelected;
    #select materiales
    public $materiales;
    public $materialesSeleccionados;
    public $selectedMateriales = [];
    protected $listeners = ['refreshCrearInsumo' => '$refresh', 'actualizarMateriales' => 'actualizarMaterialesInsumos'];

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
        $this->validate([
            'costo' => 'required|numeric',
            'cantidad' => 'required|integer',
            'fecha' => 'required|date',
            'obraSelected' =>'required|exists:obra,id',
            'materialesSeleccionados' => 'required|array',
            'materialesSeleccionados.*' => 'min:1|exists:material,id', // Validación de que cada ID existe en la tabla materiales
        ]);
        try {
            $user = Auth::user();
            $materiales = Material::whereIn('id', $this->materialesSeleccionados)->get();
            Insumo::crearInsumo($this->costo, $this->cantidad, $this->fecha,$this->obraSelected, $materiales, $user->id);
            $this->dispatch('refreshInsumosTable')->to(InsumosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Insumo creado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el Insumo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('costo');
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->reset('obraSelected');
        $this->reset('materialesSeleccionados');
        $this->dispatch('clearSelect2');
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

    public function actualizarMaterialesInsumos()
    {
        $materiales =Material::orderBy('nombre', 'asc')->get();
        $this->dispatch('actualizarMaterialesInsumos', compact('materiales'));
    }
}
