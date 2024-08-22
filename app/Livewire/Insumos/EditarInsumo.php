<?php

namespace App\Livewire\Insumos;

use App\Livewire\ServicesComponent;
use App\Models\Insumo;
use App\Models\Material;
use App\Models\Obra;
use Illuminate\Support\Facades\Auth;

class EditarInsumo extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $costo, $cantidad, $fecha;
    #select obras
    public $obras;
    public $obraSeleccionada;
    #select materiales
    public $materiales;
    public $materialesSeleccionados;
    public $selectedMateriales = [];
    public $listeners = ['cargarModalEditarInsumo'];

    public function mount(Insumo $model)
    {
        $this->model = $model;
        $this->costo = $model->costo;
        $this->cantidad = $model->cantidad;
        $this->fecha = $model->fecha;
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->costo = $this->model->costo;
        $this->cantidad = $this->model->cantidad;
        $this->fecha = $this->model->fecha;
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
        return view('livewire.insumos.editar-insumo');
    }

    public function editarInsumo()
    {
        try {
            $user = Auth::user();

            $this->validate([
                'costo' => 'numeric',
                'cantidad' => 'integer',
                'fecha' => 'date',
                'obraSeleccionada' => 'required|exists:obra,id', // Validar que el ID de obra exista en la tabla 'obras'
                'materialesSeleccionados.*' => 'exists:material,id', // Validación de que cada ID existe en la tabla materiales

            ]);

            Insumo::editarInsumo($this->model->id, $this->costo, $this->cantidad, $this->fecha, $this->obraSeleccionada, $this->materialesSeleccionados, $user->id);
            $this->dispatch('refreshInsumosTable')->to(InsumosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Insumo actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Insumo');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarInsumo($model)
    {
        $this->model = Insumo::find($model['id']);
        $this->costo = $model['costo'];
        $this->cantidad = $model['cantidad'];
        $this->fecha = $model['fecha'];
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('costo');
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->closeModal();
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
