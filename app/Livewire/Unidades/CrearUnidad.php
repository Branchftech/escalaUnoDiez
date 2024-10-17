<?php

namespace App\Livewire\Unidades;

use App\Livewire\ServicesComponent;
use App\Livewire\Materiales\CrearMaterial;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;

class CrearUnidad extends ServicesComponent
{
    public $nombre;
    public $model;
    public $showModal = false;
    #select unidades
    public $unidades;
    public $editarUnidadSelected;

    public function mount(Unidad $model)
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        $this->model = $model;
        $this->nombre = $model->nombre;
    }

    public function render()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        return view('livewire.unidades.crear-unidad');
    }

    public function crearEditarUnidad()
    {
        if (is_null($this->editarUnidadSelected)) {
            $this->validate([
                'nombre' => 'required|string|unique:unidad,nombre,NULL,id,deleted_at,NULL',
            ]);
        } else {
            $this->validate([
                'nombre' => 'required|string',
            ]);
        }
        try{
            $user = Auth::user();
            $unidad = Unidad::where('nombre', $this->nombre)->first();
            if ($unidad && $unidad->id != $this->model->id) {
                $this->addError('nombre', 'El nombre de la unidad ya está en uso.');
                return;
            }
            Unidad::crearEditarUnidad($this->editarUnidadSelected, $this->nombre, $user->id);
            $this->render();
            $this->limpiar();
            $this->closeModal();
            $this->alertService->success($this, 'Unidad guardada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear la unidad');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function updatedEditarUnidadSelected($unidadId)
    {
        if ($unidadId) {
            $unidad = Unidad::find($unidadId);
            if ($unidad) {
                $this->nombre = $unidad->nombre;
            }
        } else {
            $this->reset(['nombre']);
        }
    }

    public function limpiar()
    {
        $this->reset('nombre');
        $unidades = Unidad::orderBy('nombre', 'asc')->get();
        $this->dispatch('actualizarUnidades', compact('unidades'));
        $this->dispatch('actualizarUnidades')->to(CrearMaterial::class);
        //$this->closeModal();
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
