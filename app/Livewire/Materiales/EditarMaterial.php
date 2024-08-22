<?php

namespace App\Livewire\Materiales;

use App\Livewire\ServicesComponent;
use App\Models\Material;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;

class EditarMaterial extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $nombre, $precioNormal;
    #select unidades
    public $unidades;
    public $unidadSelected;

    public $listeners = ['cargarModalEditarMaterial'];

    public function mount(Material $model)
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        $this->model = $model;
        $this->nombre = $model->nombre;
        $this->precioNormal = $model->precioNormal;
    }

    public function render()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        return view('livewire.materiales.editar-material');
    }

    public function editarMaterial()
    {

        $this->validate([
            'nombre' => 'required|string',
            'precioNormal' => 'required|boolean',
            'unidadSelected' =>'exists:unidad,id',
        ]);

        try {
            $user = Auth::user();
            $material = Material::where('nombre', $this->nombre)->first();

            if ($material && $material->id != $this->model->id) {
                $this->addError('nombre', 'El nombre del material ya está en uso.');
                return;
            }
            $material = Material::editarMaterial($this->model->id, $this->nombre, $this->precioNormal, $this->unidadSelected, $user->id);

            $this->reset('showModal');
            $this->dispatch('refreshMaterialesTable')->to(MaterialesTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Material actualizado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Material');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEditarMaterial($model)
    {
        $this->model = Material::find($model['id']);
        $this->nombre = $model['nombre'];
        $this->precioNormal = $model['precioNormal'];
        $this->showModal = true;
    }
    public function limpiar()
    {
        $this->reset('nombre');
        $this->reset('precioNormal');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
