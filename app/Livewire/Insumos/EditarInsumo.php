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
    #Select materiales
    public $materiales;
    public $materialSeleccionado;
    public $selectedMaterialesEditar = [];
    public $listeners = ['cargarModalEditarInsumo'];

    public function mount(Insumo $model)
    {
        $this->model = $model;
        $this->costo = $model->costo;
        $this->cantidad = $model->cantidad;
        $this->fecha = $model->fecha;
        $this->obraSeleccionada=$model->idObra;
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->obras = Obra::all();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();

        return view('livewire.insumos.editar-insumo');
    }

    public function editarInsumo()
    {
        $this->validate([
            'costo' => ['required', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'cantidad' => 'required|integer',
            'fecha' => 'required|date',
            'obraSeleccionada' => 'required|exists:obra,id', // Validar que el ID de obra exista en la tabla 'obras'
            //'selectedMateriales' => 'required|array',
            //'selectedMateriales.*' => 'exists:material,id', // Validación de que cada ID existe en la tabla materiales
        ]);
        try {
            $user = Auth::user();
            Insumo::editarInsumo($this->model['id'], $this->costo, $this->cantidad, $this->fecha, $this->obraSeleccionada, $this->selectedMaterialesEditar, $user->id);
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
        $this->costo = $this->model['costo'];
        $this->cantidad = $this->model['cantidad'];
        $this->fecha = $this->model['fecha'];
        $this->obras = Obra::all();
        $this->obraSeleccionada = $this->model['idObra'];
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
        $this->selectedMaterialesEditar = Material::whereIn('id', $this->model->materiales->pluck('id'))->get();

        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('costo');
        $this->reset('cantidad');
        $this->reset('fecha');
        $this->reset('obraSeleccionada');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function updatedMaterialSeleccionado($materialId)
    {
        $this->validate([
            'materialSeleccionado' => 'required|exists:material,id',
        ]);

        $material = Material::find($materialId);

        if ($material && !$this->selectedMaterialesEditar->contains($material)) {
            $this->selectedMaterialesEditar->push($material);
        }
    }



    public function eliminarMaterial($materialId)
    {
        $this->selectedMaterialesEditar = $this->selectedMaterialesEditar->filter(function($material) use ($materialId) {
            return $material->id !== $materialId;
        });
    }
}
