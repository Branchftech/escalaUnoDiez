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
    protected $listeners = ['refreshCrearInsumo' => '$refresh'];

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
        try {
            $user = Auth::user();

            $this->validate([
                'costo' => 'numeric',
                'cantidad' => 'integer',
                'fecha' => 'date',
                'obraSelected' =>'exists:obra,id',
                'materialesSeleccionados.*' => 'exists:material,id', // Validación de que cada ID existe en la tabla materiales

            ]);

            Insumo::crearInsumo($this->costo, $this->cantidad, $this->fecha,$this->obraSelected, $this->materialesSeleccionados, $user->id);
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
